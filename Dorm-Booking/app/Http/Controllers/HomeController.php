<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\UsersModel;
use App\Models\LeaseModel;
use App\Models\RoomModel;
use App\Models\InvoiceModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        Paginator::useBootstrap();

        $rooms = RoomModel::where('status', 'AVAILABLE')
            ->orderBy('id', 'desc')
            ->paginate(12);

        // dropdown data (ดึงจาก DB + การันตีว่ามีทั้ง 3 type)
        $typesDb  = RoomModel::select('type')->distinct()->orderBy('type')->pluck('type')->toArray();
        $types    = array_values(array_unique(array_merge(['STANDARD', 'DELUXE', 'LUXURY'], $typesDb)));

        // สาขาใน DB ใช้ EN: SRINAKARIN / RAMA9 / ASOKE
        $branches = RoomModel::select('branch')->distinct()->orderBy('branch')->pluck('branch')->toArray();

        return view('home.homepage', [
            'rooms'    => $rooms,
            'types'    => $types,
            'branches' => $branches,
        ]);
    }

    public function RoomPage(Request $request)
    {
        try {
            // ✅ เอาเฉพาะห้อง AVAILABLE (กันเคส/เว้นวรรค)
            $availableQ = RoomModel::whereRaw("TRIM(UPPER(status)) = 'AVAILABLE'");

            // ✅ รายชื่อสาขาที่ "มีห้องว่างจริง" (ไว้โชว์ในปุ่มกรอง)
            $branches = (clone $availableQ)
                ->whereNotNull('branch')->where('branch', '!=', '')
                ->distinct()->orderBy('branch')->pluck('branch');

            // ✅ รับสาขาที่เลือกจาก query string
            $selectedBranch = strtoupper(trim($request->query('branch', '')));

            // ✅ ใช้ตัวกรองสาขาถ้ามีเลือก
            $roomsQ = clone $availableQ;
            if ($selectedBranch !== '') {
                $roomsQ->whereRaw("TRIM(UPPER(branch)) = ?", [$selectedBranch]);
            }

            // ✅ ประเภทห้องจากชุดข้อมูลที่ถูกกรองแล้ว (โชว์เฉพาะที่ยังมีห้องจริง)
            $types = (clone $roomsQ)
                ->whereNotNull('type')->where('type', '!=', '')
                ->distinct()->orderBy('type')->pluck('type');

            // ✅ ห้องว่างทั้งหมด (ตามตัวกรอง) สำหรับทำ swiper (ไม่ limit — ให้ swiper เลื่อน)
            $rooms = $roomsQ->orderBy('branch')
                ->orderBy('type')
                ->orderBy('floor')
                ->orderBy('room_no')
                ->get();

            // ✅ กลุ่มซ้อน [$branch][$type] => Collection<RoomModel>
            $byBranchType = $rooms->groupBy(['branch', 'type']);

            return view('content.roomContent', [
                'branches'       => $branches,
                'types'          => $types,
                'byBranchType'   => $byBranchType,
                'selectedBranch' => $selectedBranch,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function helpPage(Request $request)
    {
        return view('content.helpContent');
    }


    public function dashboard(Request $request)
    {
        // ===== สรุปภาพรวม =====
        $totalUsers   = UsersModel::count();
        $activeUsers  = UsersModel::where('status', 'ACTIVE')->count();

        $totalLeases    = LeaseModel::count();
        $activeLeases   = LeaseModel::where('status', 'ACTIVE')->count();
        $pendingLeases  = LeaseModel::where('status', 'PENDING')->count();
        $endedLeases    = LeaseModel::where('status', 'ENDED')->count();
        $canceledLeases = LeaseModel::where('status', 'CANCELED')->count();

        $roomsByStatus = RoomModel::select('status', DB::raw('COUNT(*) as c'))
            ->groupBy('status')
            ->pluck('c', 'status')
            ->all();
        $roomsAvailable   = $roomsByStatus['AVAILABLE']   ?? 0;
        $roomsOccupied    = $roomsByStatus['OCCUPIED']    ?? 0;
        $roomsMaintenance = $roomsByStatus['MAINTENANCE'] ?? 0;

        // ===== สถานะใบแจ้งหนี้ (Donut) =====
        $invoiceStatusCounts = InvoiceModel::select('status', DB::raw('COUNT(*) as c'))
            ->groupBy('status')
            ->pluck('c', 'status')
            ->all();
        $invoicePaid     = $invoiceStatusCounts['PAID']     ?? 0;
        $invoiceIssued   = $invoiceStatusCounts['ISSUED']   ?? 0;
        $invoiceDraft    = $invoiceStatusCounts['DRAFT']    ?? 0;
        $invoiceOverdue  = $invoiceStatusCounts['OVERDUE']  ?? 0;
        $invoiceCanceled = $invoiceStatusCounts['CANCELED'] ?? 0;

        // ===== Leases เริ่มใหม่รายเดือน (12 เดือนล่าสุด) =====
        $start12m = Carbon::now()->startOfMonth()->subMonths(11);
        $monthKeys12 = [];
        for ($i = 0; $i < 12; $i++) {
            $monthKeys12[] = $start12m->copy()->addMonths($i)->format('Y-m');
        }
        $leasesMonthlyRaw = LeaseModel::select(
            DB::raw("DATE_FORMAT(start_date, '%Y-%m') as ym"),
            DB::raw('COUNT(*) as c')
        )
            ->whereDate('start_date', '>=', $start12m->toDateString())
            ->groupBy('ym')
            ->pluck('c', 'ym')
            ->all();

        $leasesMonthlyLabels = [];
        $leasesMonthlyData   = [];
        foreach ($monthKeys12 as $ym) {
            $leasesMonthlyLabels[] = Carbon::createFromFormat('Y-m', $ym)->isoFormat('MMM YY');
            $leasesMonthlyData[]   = $leasesMonthlyRaw[$ym] ?? 0;
        }

        // ===== Utilities/Rent/Other รายเดือน (สลับ 6M/12M) =====
        // ===== Utilities/Rent/Other รายเดือน (สลับ 6M/12M) =====
        $buildMonthlySeries = function (int $months) {
            $start = \Illuminate\Support\Carbon::now()->startOfMonth()->subMonths($months - 1);

            // รายชื่อเดือนในช่วง (YYYY-MM)
            $keys = [];
            for ($i = 0; $i < $months; $i++) {
                $keys[] = $start->copy()->addMonths($i)->format('Y-m');
            }

            // ดึงยอดรวมต่อเดือน (ไม่ใช้ JSON_OBJECT)
            $rows = \App\Models\InvoiceModel::selectRaw("
            billing_period,
            SUM(amount_utilities) AS util,
            SUM(amount_rent)      AS rent,
            SUM(amount_other)     AS other_amt,
            SUM(total_amount)     AS total_amt
        ")
                ->whereIn('billing_period', $keys)
                ->groupBy('billing_period')
                ->get()
                ->keyBy('billing_period'); // ได้เป็น Collection keyed ด้วย 'YYYY-MM'

            $labels     = [];
            $seriesUtil = [];
            $seriesRent = [];
            $seriesOther = [];
            $seriesTotal = [];

            foreach ($keys as $ym) {
                $labels[] = \Illuminate\Support\Carbon::createFromFormat('Y-m', $ym)->isoFormat('MMM YY');

                $row = $rows->get($ym); // stdClass หรือ null
                $seriesUtil[]  = $row ? (float) $row->util      : 0.0;
                $seriesRent[]  = $row ? (float) $row->rent      : 0.0;
                $seriesOther[] = $row ? (float) $row->other_amt : 0.0;
                $seriesTotal[] = $row ? (float) $row->total_amt : 0.0;
            }

            return [
                'labels'     => $labels,
                'seriesUtil' => $seriesUtil,
                'seriesRent' => $seriesRent,
                'seriesOther' => $seriesOther,
                'seriesTotal' => $seriesTotal,
            ];
        };


        $m6  = $buildMonthlySeries(6);
        $m12 = $buildMonthlySeries(12);

        return view('dashboard.index', [
            // Cards
            'totalUsers'       => $totalUsers,
            'activeUsers'      => $activeUsers,
            'totalLeases'      => $totalLeases,
            'activeLeases'     => $activeLeases,
            'roomsAvailable'   => $roomsAvailable,
            'roomsOccupied'    => $roomsOccupied,
            'roomsMaintenance' => $roomsMaintenance,

            // Lease status (ส่งให้ใช้จริงใน donut)
            'pendingLeases'    => $pendingLeases,
            'endedLeases'      => $endedLeases,
            'canceledLeases'   => $canceledLeases,

            // Invoice status
            'invoicePaid'     => $invoicePaid,
            'invoiceIssued'   => $invoiceIssued,
            'invoiceDraft'    => $invoiceDraft,
            'invoiceOverdue'  => $invoiceOverdue,
            'invoiceCanceled' => $invoiceCanceled,

            // Leases per month
            'leasesMonthlyLabels' => $leasesMonthlyLabels,
            'leasesMonthlyData'   => $leasesMonthlyData,

            // Utilities/Rent/Other series
            'labels6'  => $m6['labels'],
            'util6'    => $m6['seriesUtil'],
            'rent6'    => $m6['seriesRent'],
            'other6'   => $m6['seriesOther'],
            'total6'   => $m6['seriesTotal'],
            'labels12' => $m12['labels'],
            'util12'   => $m12['seriesUtil'],
            'rent12'   => $m12['seriesRent'],
            'other12'  => $m12['seriesOther'],
            'total12'  => $m12['seriesTotal'],
        ]);
    }

    public function showRoom(Request $request)
    {
        Paginator::useBootstrap();

        $rooms = RoomModel::where('status', 'AVAILABLE')
            ->orderBy('id', 'desc')
            ->paginate(12);

        // dropdown data (ดึงจาก DB + การันตีว่ามีทั้ง 3 type)
        $typesDb  = RoomModel::select('type')->distinct()->orderBy('type')->pluck('type')->toArray();
        $types    = array_values(array_unique(array_merge(['STANDARD', 'DELUXE', 'LUXURY'], $typesDb)));

        // สาขาใน DB ใช้ EN: SRINAKARIN / RAMA9 / ASOKE
        $branches = RoomModel::select('branch')->distinct()->orderBy('branch')->pluck('branch')->toArray();

        return view('searchRoom.homepage', [
            'rooms'    => $rooms,
            'types'    => $types,
            'branches' => $branches,
        ]);
    }

    public function searchRoom(Request $request)
    {
        Paginator::useBootstrap();

        // ===== รับค่าและ normalize ให้ตรงกับ DB =====
        $branch   = trim((string) $request->query('branch', ''));  // คาดว่าจะเป็น SRINAKARIN/RAMA9/ASOKE หรือว่าง
        $type     = trim((string) $request->query('type', ''));    // STANDARD/DELUXE/LUXURY หรือว่าง
        $roomNo   = trim((string) $request->query('roomNo', ''));
        $start    = trim((string) $request->query('start_date', ''));
        $end      = trim((string) $request->query('end_date', ''));

        // ถ้าเลือกวันเดียว ให้ใช้วันเดียวกันทั้ง start/end
        if ($start && !$end) {
            $end = $start;
        }

        // map ภาษาไทย -> โค้ดอังกฤษ (กันพลาดแม้ว่าหน้าบ้านจะส่ง EN อยู่แล้ว)
        $branchMap = [
            'ศรีนครินทร์' => 'SRINAKARIN',
            'SRINAKARIN'   => 'SRINAKARIN',
            'พระราม 9'     => 'RAMA9',
            'RAMA 9'       => 'RAMA9',
            'RAMA9'        => 'RAMA9',
            'อโศก'         => 'ASOKE',
            'ASOKE'        => 'ASOKE',
            ''             => '',
        ];
        $branch = $branchMap[$branch] ?? strtoupper($branch);

        $allowedTypes = ['STANDARD', 'DELUXE', 'LUXURY'];
        $type = strtoupper($type);
        if (!in_array($type, $allowedTypes, true)) {
            $type = ''; // ถ้าค่ามั่ว ๆ มา ให้ถือว่าไม่กรอง
        }

        $q = RoomModel::query();

        // กรองสาขา (เป๊ะกับค่าใน DB)
        if ($branch !== '') {
            $q->where('branch', $branch);
        }

        // กรองรูปแบบห้อง (ENUM ใน DB เป็นตัวพิมพ์ใหญ่)
        if ($type !== '') {
            $q->where('type', $type);
        }

        // ชื่อ/เลขห้อง
        if ($roomNo !== '') {
            $q->where('room_no', 'LIKE', "%{$roomNo}%");
        }

        // ===== กรอง “ความว่างตามช่วงเวลา” จากตาราง leases =====
        // เงื่อนไข: ต้อง "ไม่มี" lease (ACTIVE/PENDING) ที่ช่วงวันที่ซ้อนกับช่วงที่ค้นหา
        if ($start && $end) {
            $q->whereNotExists(function ($sub) use ($start, $end) {
                $sub->select(DB::raw(1))
                    ->from('leases')
                    ->whereColumn('leases.room_id', 'rooms.id')
                    ->whereNull('leases.deleted_at')                 // ไม่สน lease ที่ถูกลบแล้ว
                    ->whereIn('leases.status', ['ACTIVE', 'PENDING']) // ปรับตามธุรกิจคุณ
                    ->where(function ($w) use ($start, $end) {
                        $w->whereBetween('leases.start_date', [$start, $end])
                            ->orWhereBetween('leases.end_date', [$start, $end])
                            ->orWhere(function ($z) use ($start, $end) {
                                $z->where('leases.start_date', '<=', $start)
                                    ->where('leases.end_date', '>=', $end);
                            });
                    });
            });
        } else {
            // ถ้าไม่เลือกวันที่ ให้แสดงเฉพาะห้องว่างตามสถานะ
            $q->where('status', 'AVAILABLE');
        }

        $rooms = $q->orderBy('id', 'desc')
            ->paginate(12)
            ->appends($request->query());

        // dropdown data (สำหรับแสดงผลเดิม)
        $typesDb  = RoomModel::select('type')->distinct()->orderBy('type')->pluck('type')->toArray();
        $types    = array_values(array_unique(array_merge(['STANDARD', 'DELUXE', 'LUXURY'], $typesDb)));
        $branches = RoomModel::select('branch')->distinct()->orderBy('branch')->pluck('branch')->toArray();

        return view('searchRoom.homepage', compact('rooms', 'types', 'branches'));
    }

    public function myBooking()
    {
        
        return view('content.myBookingContent');
    }
}
