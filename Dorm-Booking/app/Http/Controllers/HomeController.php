<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use App\Models\ProductModel; //model



class HomeController extends Controller
{

    public function index()
    {
        Paginator::useBootstrap(); // ใช้ Bootstrap pagination
        $products = ProductModel::orderBy('id', 'desc')->paginate(8); //order by & pagination
        //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('home.product_index', compact('products'));
    }

    public function detail($id)
    {
        try {
            $product = ProductModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404

            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($product)) {
                $id = $product->id;
                $product_name = $product->product_name;
                $product_detail = $product->product_detail;
                $product_price = $product->product_price;
                $product_img = $product->product_img;
                $dateCreate = $product->dateCreate;
                return view('home.product_detail', compact('id', 'product_name', 'product_detail', 'product_price', 'product_img','dateCreate'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit

    public function searchProduct(Request $request){
        // print_r($_GET)
        // exit;
        Paginator::useBootstrap();
        $keyword = $request->keyword;
        if(strlen($keyword) > 0){
            // query data by searching
            $products = ProductModel::where('product_name','like',"%{$keyword}%")->paginate(8);
        }else{
            $products = ProductModel::orderBy('id','desc')->paginate(8);
        }
        return view('home.product_index',compact('products','keyword'));
    } // searchProduct

} //class
