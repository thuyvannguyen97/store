<?php

namespace App\Http\Controllers\frontend;

use App\models\Product;
use App\models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function getDetail($slug_prd){
        $arr = explode('-', $slug_prd);
        $prd_id = array_pop($arr);
        $data['prd'] = Product::find($prd_id);
        //findOrFail() 
        /*Instead of:
        $user = User::find($id);
        if (!$user) { abort (404); } */

        // dd($slug_prd);
        return view('frontend.product.detail', $data);
    }

    function getShop(request $r){
        if ($r->start != "") {
        //where-between
           $data['products'] = Product::where('img','<>','no-img.jpg')->whereBetween('price', [$r->start, $r->end])->orderBy('updated_at', 'desc')->paginate(6);
        }
        else {
        $data['products'] = Product::where('img','<>','no-img.jpg')->orderBy('updated_at', 'desc')->paginate(6);
        }
        $data['categories'] = Category::all();
        return view('frontend.product.shop', $data);
    }

    function getPrdCate($slug_cate, request $r){
        if ($r->start != "") {
            $data['products'] = Category::where('slug', $slug_cate)->first()->product()
            ->where('img','<>','no-img.jpg')
            ->whereBetween('price', [$r->start, $r->end])
            ->orderBy('updated_at', 'desc')->paginate(6);
            // dd($slug_cate);
        }
        else {
            $data['products'] = Category::where('slug', $slug_cate)->first()->product()
            ->where('img','<>','no-img.jpg')
            ->orderBy('updated_at', 'desc')->paginate(6);
        }
        $data['categories'] = Category::all();
        return view('frontend.product.shop', $data);
        
    }
    
}
