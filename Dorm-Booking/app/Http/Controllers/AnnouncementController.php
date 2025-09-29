<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementModel;
use App\Models\RoomModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{

    public function __construct()
    {
        // ใช middleware 'auth:admin' เพื่อบังคับใหตองล็อกอินในฐานะ admin กอนใชงาน
        // controller นี้
        // ถาไมล็อกอินหรือไมไดใช guard 'admin' จะถูก redirect ไปหนา login
        $this->middleware('auth:admin');
    }

    public function index()
    {
        Paginator::useBootstrap();
        $AnnouncementList = AnnouncementModel::orderBy('id', 'desc')->paginate(10);
        return view('announcement.list', compact('AnnouncementList'));
    }



    public function adding()
    {
        return view('announcement.create');
    }

    public function create(Request $request)
    {
        $messages = [
            'title.required' => 'กรุณากรอกข้อมูล',
            'title.unique' => 'หัวข้อซ้ำ เพิ่มใหม่อีกครั้ง',
            'body.required' => 'กรุณากรอกข้อมูล',
            'body.min' => 'ข้อความไม่เป็น 0 หรือต่ำกว่า :min',
            'link.required' => 'กรุณากรอกข้อมูล',
            'image.required' => 'กรุณาใส่ภาพประกอบ',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:announcement',
            'body' => 'required|min:1',
            'link' => 'required|min:1',
            'image' => 'required|file|mimes:jpg,jpeg,png,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('announcement/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $path = null;

            if ($request->hasFile('image')) {
                // เก็บไฟล์ใน storage/app/public/uploads/announcement
                $path = $request->file('image')->store('uploads/announcement', 'public');

                // แปลง path ให้เป็น URL สำหรับ public
                $url = asset('storage/' . $path);
            }

            // สร้างข้อมูลใน DB
            AnnouncementModel::create([
                'title' => strip_tags($request->input('title')),
                'body' => strip_tags($request->input('body')),
                'link' => strip_tags($request->input('link')),
                'image' => $path, // เก็บ path สำหรับเรียก asset('storage/...') ใน view
            ]);

            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/announcement');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    public function edit($id)
    {
        try {
            //query data for form edit 
            $announcement = AnnouncementModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($announcement)) {
                $id = $announcement->id;
                $title = $announcement->title;
                $body = $announcement->body;
                $link = $announcement->link;
                $image = $announcement->image;
                $updated_at = $announcement->updated_at;
                return view('announcement.edit', compact('id', 'title', 'body', 'link', 'image', 'updated_at'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit


    public function update($id, Request $request)
    {
        //vali msg 
        $messages = [
            'title.required' => 'กรุณากรอกข้อมูล',
            'title.unique' => 'หัวข้อซ้ำ เพิ่มใหม่อีกครั้ง',

            'link.required' => 'กรุณากรอกข้อมูล',

            'body.required' => 'กรุณากรอกข้อมูล',
            'body.min' => 'ข้อความไม่เป็น 0 หรือต่ำกว่า :min',
        ];


        //rule 
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:announcement',
            'body' => 'required|min:1',
            'link' => 'required|min:1',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ], $messages);

        //check 
        if ($validator->fails()) {
            return redirect('announcement/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $announcement = AnnouncementModel::find($id);
            $path = $announcement->image;

            // ถ้ามีอัปโหลดใหม่ ค่อยอัปเดต path และลบไฟล์เก่า
            if ($request->hasFile('image')) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $path = $request->file('image')->store('uploads/announcement', 'public');
            }

            $announcement->update([
                'title' => strip_tags($request->title),
                'body'  => strip_tags($request->body),
                'link'  => strip_tags($request->link),
                'image' => $path, // ถ้าไม่ได้อัปใหม่ จะเป็นของเดิม
            ]);

            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/announcement');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $announcement = AnnouncementModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $announcement->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/announcement');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //remove 

    public function search(Request $request)
    {
        try {
            Paginator::useBootstrap();

            $keyword = trim((string)($request->input('keyword', $request->input('q', ''))));
            $by      = $request->input('by', 'all');

            $allowed = ['all', 'id', 'title', 'body', 'link', 'image', 'created', 'updated', 'date'];
            if (!in_array($by, $allowed, true)) {
                $by = 'all';
            }

            $query = AnnouncementModel::query();

            // เตรียม like และลอง parse วันที่ dd/mm/YYYY -> Y-m-d
            $like = '%' . $keyword . '%';
            $parsedYmd = null;
            if ($keyword !== '' && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $keyword)) {
                try {
                    $parsedYmd = Carbon::createFromFormat('d/m/Y', $keyword)->format('Y-m-d');
                } catch (\Exception $e) {
                    $parsedYmd = null;
                }
            }

            if ($keyword !== '') {
                switch ($by) {
                    case 'id':
                        if (ctype_digit($keyword)) {
                            $query->where('id', (int)$keyword);
                        } else {
                            $query->whereRaw('1=0');
                        }
                        break;

                    case 'title':
                        $query->where('title', 'LIKE', $like);
                        break;

                    case 'body':
                        $query->where('body', 'LIKE', $like);
                        break;

                    case 'link':
                        $query->where('link', 'LIKE', $like);
                        break;

                    case 'image':
                        $query->where('image', 'LIKE', $like);
                        break;

                    case 'created':
                        if ($parsedYmd) {
                            $query->whereDate('created_at', $parsedYmd);
                        } else {
                            $query->where('created_at', 'LIKE', $like);
                        }
                        break;

                    case 'updated':
                        if ($parsedYmd) {
                            $query->whereDate('updated_at', $parsedYmd);
                        } else {
                            $query->where('updated_at', 'LIKE', $like);
                        }
                        break;

                    case 'date': // ค้นได้ทั้ง created/updated
                        $query->where(function ($w) use ($like, $parsedYmd) {
                            if ($parsedYmd) {
                                $w->whereDate('created_at', $parsedYmd)
                                    ->orWhereDate('updated_at', $parsedYmd);
                            } else {
                                $w->where('created_at', 'LIKE', $like)
                                    ->orWhere('updated_at', 'LIKE', $like);
                            }
                        });
                        break;

                    case 'all':
                    default:
                        $query->where(function ($w) use ($like, $parsedYmd, $keyword) {
                            $w->where('title', 'LIKE', $like)
                                ->orWhere('body', 'LIKE', $like)
                                ->orWhere('link', 'LIKE', $like)
                                ->orWhere('image', 'LIKE', $like);

                            if ($parsedYmd) {
                                $w->orWhereDate('created_at', $parsedYmd)
                                    ->orWhereDate('updated_at', $parsedYmd);
                            } else {
                                $w->orWhere('created_at', 'LIKE', $like)
                                    ->orWhere('updated_at', 'LIKE', $like);
                            }

                            if (ctype_digit($keyword)) {
                                $w->orWhere('id', (int)$keyword);
                            }
                        });
                        break;
                }
            }

            $AnnouncementList = $query->orderByDesc('id')
                ->paginate(10)
                ->appends($request->query());

            return view('announcement.list', compact('AnnouncementList'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} //class
