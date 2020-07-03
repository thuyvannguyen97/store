<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use App\models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function getCategory(){
        $data['categories'] = Category::all();
        return view('backend.category.category', $data);
    }
    function postAddCategory(AddCategoryRequest $r){
        $cate = new Category();
        $cate->name = $r->name;
        $cate->slug = Str::slug($r->name, '-');
        $cate->parent = $r->parent;

        $cate->save();
        return redirect()->back()->with('notify', 'Add category successfully!');
    }
    
    function getEditCategory($cateId){
        $data['categories']=Category::all();
        $data['category'] = Category::find($cateId);
        return view('backend.category.editcategory', $data);
    }
    function postEditCategory($cateId, EditCategoryRequest $r){
        $cate = Category::find($cateId);
        $cate->name = $r->name;
        $cate->slug = Str::slug($r->name, '-');
        $cate->parent = $r->parent;    

        $cate->save();
        return redirect()->back()->with('notify', 'Edit category successfully!');
    }

    function getDelCategory($cateId){
        $cate=Category::find($cateId);
        $categories=Category::all();

        Category::where('parent',$cate->id)->update(["parent"=>"$cate->parent"]);
        $cate->delete();
        return redirect('admin/category')->with('notify','Đã xóa thành công');
    }
}

