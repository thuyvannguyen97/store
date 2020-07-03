<?php

namespace App\Http\Controllers\backend;

use App\models\Product;
use App\models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;

class ProductController extends Controller
{
    function getProduct(){
        $data['products'] = Product::paginate(5);
        
        return view('backend.product.listproduct', $data);
    }

    function getAddProduct(){
        $data['categories'] = Category::all();
        return view('backend.product.addproduct', $data);
    }
    function postAddProduct(AddProductRequest $r){
        $product = new Product();
        $product->code = $r->code;
        $product->name = $r->name;
        $product->slug = Str::slug($r->name, '-');
        $product->price = $r->price;
        $product->featured = $r->featured;
        $product->state = $r->state;
        $product->info = $r->info;
        $product->describe = $r->describe;

        if ($r->hasFile('img')) {
            $file = $r->img;
            $fileName = Str::slug($r->name, '-').'.'.$file->getClientOriginalExtension();
            $file->move('backend/img', $fileName); //save into 'backend/img' folder
            $product->img = $fileName; //save into database
            // dd($fileName);
        }
        else {
            $product->img = 'no-img.jpg';
        }
        $product->category_id = $r->category;

        $product->save();
        return redirect('/admin/product')->with('notify', 'Add product successfully!');
    }

    function getEditProduct($productId){
        $data['product'] = Product::find($productId);
        $data['categories'] = Category::all();
        return view('backend.product.editproduct', $data);
    }
    function postEditProduct($productId, AddProductRequest $r){
        $product = Product::find($productId);
        $product->code = $r->code;
        $product->name = $r->name;
        $product->slug = Str::slug($r->name, '-');
        $product->price = $r->price;
        $product->featured = $r->featured;
        $product->state = $r->state;
        $product->info = $r->info;
        $product->describe = $r->describe;
        if ($product->img != 'no-img.jpg') {
            unlink('backend/img/'.$product->img); //if product had an image, remove it from 'backend/img', then insert new image
            $file = $r->img;
            $fileName = Str::slug($r->name, '-').'.'.$file->getClientOriginalExtension();
            $file->move('backend/img', $fileName); //save into 'backend/img' folder
            $product->img = $fileName; //save into database
        }
        $product->category_id = $r->category;

        $product->save();
        return redirect('/admin/product')->with('notify', 'Đã sửa thành công');
    }

    function getDelProduct($productId){
        Product::find($productId)->delete();
        return redirect()->back()->with('notify', 'Deleted');
    }
/*       ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name as cateName')
        ->get() */
}
