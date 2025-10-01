<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\UsersModel;
use App\Models\LeaseModel;
use App\Models\RoomModel;
use App\Models\InvoiceModel;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.homepage');
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
}
