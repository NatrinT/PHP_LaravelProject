<?php

namespace App\Http\Controllers;

use App\Models\InvoiceModel;
use App\Models\LeaseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use RealRashid\SweetAlert\Facades\Alert;

class InvoiceController extends Controller
{
    // กำหนดสถานะที่อนุญาตให้ชัดเจน
    private const STATUSES = ['DRAFT', 'ISSUED', 'PAID', 'OVERDUE', 'CANCELED'];
    private const PAYMENT_STATUSES = ['PENDING', 'CONFIRMED', 'FAILED'];

    public function __construct()
    {
        // ใช middleware 'auth:admin' เพื่อบังคับใหตองล็อกอินในฐานะ admin กอนใชงาน
        // controller นี้
        // ถาไมล็อกอินหรือไมไดใช guard 'admin' จะถูก redirect ไปหนา login
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        Paginator::useBootstrap();
        $InvoiceList = InvoiceModel::with('lease')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('invoice.list', compact('InvoiceList'));
    }


    public function adding()
    {
        $leases = LeaseModel::orderBy('id', 'desc')
            ->get(['id', 'rent_amount']); // ดึง rent_amount มาด้วย
        return view('invoice.create', compact('leases'));
    }

    public function create(Request $request)
    {
        $messages = [
            'lease_id.required'   => 'กรุณาเลือก Lease',
            'lease_id.exists'     => 'Lease ไม่ถูกต้อง',
            'billing_period.required' => 'กรุณากำหนดงวดบิล',
            'due_date.required'   => 'กรุณากำหนดวันครบกำหนด',
            'amount_rent.required' => 'กรุณากรอกค่าเช่า',
            'amount_rent.numeric' => 'ค่าเช่าต้องเป็นตัวเลข',
            'total_amount.required' => 'กรุณากรอกยอดรวม',
            'status.in'           => 'สถานะไม่ถูกต้อง',
            'payment_status.in'   => 'สถานะการชำระเงินไม่ถูกต้อง',
            'receipt_file.mimes'  => 'รองรับเฉพาะ pdf, jpg, jpeg, png',
            'receipt_file.max'    => 'ไฟล์ต้องไม่เกิน 5MB',
        ];

        $validator = Validator::make($request->all(), [
            'lease_id'       => 'required|exists:leases,id',
            'billing_period' => 'required|string|min:7|max:7', // ตัวอย่าง YYYY-MM
            'due_date'       => 'required|date',
            'amount_rent'    => 'required|numeric|min:0',
            'amount_utilities' => 'nullable|numeric|min:0',
            'amount_other'   => 'nullable|numeric|min:0',
            'total_amount'   => 'required|numeric|min:0',
            'status'         => 'required|in:' . implode(',', self::STATUSES),
            'payment_status' => 'required|in:' . implode(',', self::PAYMENT_STATUSES),
            'receipt_file'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('invoice/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $path = null;
            if ($request->hasFile('receipt_file')) {
                $path = $request->file('receipt_file')->store('uploads/receipts', 'public');
            }

            InvoiceModel::create([
                'lease_id'        => $request->lease_id,
                'billing_period'  => $request->billing_period,
                'due_date'        => $request->due_date,
                'amount_rent'     => $request->amount_rent,
                'amount_utilities' => $request->amount_utilities,
                'amount_other'    => $request->amount_other,
                'total_amount'    => $request->total_amount,
                'status'          => $request->status,
                'payment_status'  => $request->payment_status,
                'paid_at'         => $request->paid_at,
                'receipt_file_url' => $path,
            ]);

            Alert::success('เพิ่ม Invoice สำเร็จ');
            return redirect('/invoice');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            // โหลด invoice พร้อม lease เผื่อใช้ใน view
            $invoice = InvoiceModel::with('lease')->findOrFail($id);

            // ดึง leases สำหรับ drop-down:
            // - ต้องมี rent_amount เพื่อให้ JS ออโต้กรอก Rent ได้
            // - ดึง room/user เพื่อเอาไปโชว์ label ให้สวยงาม (ถ้าอยากใช้)
            $leases = LeaseModel::with([
                'room:id,room_no',
                'user:id,full_name'
            ])
                ->orderBy('id', 'desc')
                ->get(['id', 'rent_amount', 'room_id', 'user_id']); // ✅ มี rent_amount แน่นอน

            // แตกตัวแปรส่งไป view
            $data = [
                'id'               => $invoice->id,
                'lease_id'         => $invoice->lease_id,
                'billing_period'   => $invoice->billing_period,
                'due_date'         => optional($invoice->due_date)->format('Y-m-d'),
                'amount_rent'      => $invoice->amount_rent,
                'amount_utilities' => $invoice->amount_utilities,
                'amount_other'     => $invoice->amount_other,
                'total_amount'     => $invoice->total_amount,
                'status'           => $invoice->status,
                'payment_status'   => $invoice->payment_status,
                'paid_at'          => optional($invoice->paid_at)->format('Y-m-d H:i:s'),
                'receipt_file_url' => $invoice->receipt_file_url,
            ];

            return view('invoice.edit', $data + compact('leases'));
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }


    public function update($id, Request $request)
    {
        $messages = [
            'lease_id.required'   => 'กรุณาเลือก Lease',
            'lease_id.exists'     => 'Lease ไม่ถูกต้อง',
            'billing_period.required' => 'กรุณากำหนดงวดบิล',
            'due_date.required'   => 'กรุณากำหนดวันครบกำหนด',
            'amount_rent.required' => 'กรุณากรอกค่าเช่า',
            'amount_rent.numeric' => 'ค่าเช่าต้องเป็นตัวเลข',
            'total_amount.required' => 'กรุณากรอกยอดรวม',
            'status.in'           => 'สถานะไม่ถูกต้อง',
            'payment_status.in'   => 'สถานะการชำระเงินไม่ถูกต้อง',
            'receipt_file.mimes'  => 'รองรับเฉพาะ pdf, jpg, jpeg, png',
            'receipt_file.max'    => 'ไฟล์ต้องไม่เกิน 5MB',
        ];

        $validator = Validator::make($request->all(), [
            'lease_id'       => 'required|exists:leases,id',
            'billing_period' => 'required|string|min:7|max:7',
            'due_date'       => 'required|date',
            'amount_rent'    => 'required|numeric|min:0',
            'amount_utilities' => 'nullable|numeric|min:0',
            'amount_other'   => 'nullable|numeric|min:0',
            'total_amount'   => 'required|numeric|min:0',
            'status'         => 'required|in:' . implode(',', self::STATUSES),
            'payment_status' => 'required|in:' . implode(',', self::PAYMENT_STATUSES),
            'paid_at'        => 'nullable|date',
            'receipt_file'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('invoice/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $invoice = InvoiceModel::findOrFail($id);

            $path = $invoice->receipt_file_url;
            if ($request->hasFile('receipt_file')) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $path = $request->file('receipt_file')->store('uploads/receipts', 'public');
            }

            $invoice->update([
                'lease_id'        => $request->lease_id,
                'billing_period'  => $request->billing_period,
                'due_date'        => $request->due_date,
                'amount_rent'     => $request->amount_rent,
                'amount_utilities' => $request->amount_utilities,
                'amount_other'    => $request->amount_other,
                'total_amount'    => $request->total_amount,
                'status'          => $request->status,
                'payment_status'  => $request->payment_status,
                'paid_at'         => $request->paid_at,
                'receipt_file_url' => $path,
            ]);

            Alert::success('อัปเดต Invoice สำเร็จ');
            return redirect('/invoice');
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function remove($id)
    {
        try {
            $invoice = InvoiceModel::find($id);
            if (!$invoice) {
                Alert::error('ไม่พบ Invoice');
                return redirect('/invoice');
            }

            if ($invoice->receipt_file_url && Storage::disk('public')->exists($invoice->receipt_file_url)) {
                Storage::disk('public')->delete($invoice->receipt_file_url);
            }

            $invoice->delete();

            Alert::success('ลบ Invoice สำเร็จ');
            return redirect('/invoice');
        } catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
            return redirect('/invoice');
        }
    }

    public function search(Request $request)
    {
        try {
            Paginator::useBootstrap();

            $keyword = trim((string)$request->input('keyword', ''));
            $by      = $request->input('by', 'all');

            $allowed = ['all', 'id', 'lease', 'user', 'room', 'status', 'payment', 'period', 'due', 'amount'];
            if (!in_array($by, $allowed, true)) {
                $by = 'all';
            }

            $query = InvoiceModel::with(['lease.room', 'lease.user']);

            // แปลงวันที่จากรูปแบบ dd/mm/YYYY → Y-m-d ถ้าใส่มาถูกฟอร์แมต
            $parsedDueYmd = null;
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $keyword)) {
                try {
                    $parsedDueYmd = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                } catch (\Exception $e) {
                    $parsedDueYmd = null; // ถ้า parse ไม่ผ่าน จะปล่อยไปใช้ LIKE เดิม
                }
            }


            if ($keyword !== '') {
                $like = '%' . $keyword . '%';
                $likeUpper = '%' . strtoupper($keyword) . '%';

                switch ($by) {
                    case 'id':
                        if (ctype_digit($keyword)) {
                            $query->where('id', (int)$keyword);
                        } else {
                            $query->whereRaw('1=0');
                        }
                        break;

                    case 'lease':
                        if (ctype_digit($keyword)) {
                            $query->where('lease_id', (int)$keyword);
                        } else {
                            $query->whereHas('lease', fn($q) => $q->where('id', 'LIKE', $like));
                        }
                        break;

                    case 'user':
                        $query->whereHas('lease.user', function ($u) use ($like) {
                            $u->where('full_name', 'LIKE', $like)
                                ->orWhere('email', 'LIKE', $like)
                                ->orWhere('phone', 'LIKE', $like);
                        });
                        break;

                    case 'room':
                        $query->whereHas('lease.room', fn($r) => $r->where('room_no', 'LIKE', $like));
                        break;

                    case 'status':
                        $query->where('status', 'LIKE', $likeUpper);
                        break;

                    case 'payment':
                        $query->where('payment_status', 'LIKE', $likeUpper);
                        break;

                    case 'period':
                        $query->where('billing_period', 'LIKE', $like);
                        break;

                    case 'due':
                        if ($parsedDueYmd) {
                            // ค้นเท่ากับวันนั้นแบบตรง ๆ (คอลัมน์เป็น DATE)
                            $query->whereDate('due_date', $parsedDueYmd);
                        } else {
                            // ถ้าไม่ได้ใส่เป็น dd/mm/YYYY ก็ใช้ LIKE เดิม (เช่นค้นบางส่วน)
                            $query->where('due_date', 'LIKE', $like);
                        }
                        break;

                    case 'amount':
                        $num = str_replace([','], '', $keyword);
                        if (is_numeric($num)) {
                            $query->where('total_amount', (float)$num);
                        } else {
                            $query->whereRaw('CAST(total_amount AS CHAR) LIKE ?', [$like]);
                        }
                        break;

                    case 'all':
                    default:
                        $query->where(function ($w) use ($keyword, $like, $likeUpper, $parsedDueYmd) {
                            $w->where('billing_period', 'LIKE', $like)
                                ->orWhere('status', 'LIKE', $likeUpper)
                                ->orWhere('payment_status', 'LIKE', $likeUpper)
                                // ถ้า parse วันที่สำเร็จ ใช้ whereDate ให้ตรงวัน; ถ้าไม่สำเร็จ ใช้ LIKE เหมือนเดิม
                                ->orWhere(function ($x) use ($parsedDueYmd, $like) {
                                    if ($parsedDueYmd) {
                                        $x->whereDate('due_date', $parsedDueYmd);
                                    } else {
                                        $x->where('due_date', 'LIKE', $like);
                                    }
                                })
                                ->orWhereRaw('CAST(total_amount AS CHAR) LIKE ?', [$like]);

                            $w->orWhereHas('lease', function ($q2) use ($keyword, $like) {
                                if (ctype_digit($keyword)) {
                                    $q2->where('id', (int)$keyword);
                                }
                                $q2->orWhereHas('room', fn($r) => $r->where('room_no', 'LIKE', $like))
                                    ->orWhereHas('user', function ($u) use ($like) {
                                        $u->where('full_name', 'LIKE', $like)
                                            ->orWhere('email', 'LIKE', $like)
                                            ->orWhere('phone', 'LIKE', $like);
                                    });
                            });

                            if (ctype_digit($keyword)) {
                                $w->orWhere('id', (int)$keyword)
                                    ->orWhere('lease_id', (int)$keyword);
                            }
                        });
                        break;
                }
            }

            $InvoiceList = $query->orderByDesc('id')
                ->paginate(10)
                ->appends($request->query());

            return view('invoice.list', compact('InvoiceList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
