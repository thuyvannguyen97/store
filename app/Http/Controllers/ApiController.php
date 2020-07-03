<?php

namespace App\Http\Controllers;

use App\models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function getHome(){
        $data['prd_new'] = Product::where('img', '<>', 'no-img.jpg')->orderBy('id', 'desc')->take(8)->get();
        $data['prd_featured'] = Product::where('featured',1)->where('img', '<>', 'no-img.jpg')->orderBy('id', 'desc')->take(4)->get();

        return response()->json($data, 200);
    }
    function getDetail($id_prd){
        $prd = Product::find($id_prd);

        return response()->json($data, 200);
    }
    function sendMail(request $r){

        $data['email'] = $r->email;
        Mail::send('Html.view', $data, function ($message) use ($data){
            $message->from('john@johndoe.com', 'John Doe');
            $message->sender('john@johndoe.com', 'John Doe');
            $message->to('john@johndoe.com', 'John Doe');
            $message->cc('john@johndoe.com', 'John Doe');
            $message->bcc('john@johndoe.com', 'John Doe');
            $message->replyTo('john@johndoe.com', 'John Doe');
            $message->subject('Subject');
            $message->priority(3);
            $message->attach('pathToFile');
        });

        $message=[
            'error' => 'success'
        ];
        return response()->json($data, 200);
    }
    function getPaginate(){
        $products = Product::paginate(2);
        return response()->json($data, 200);
    }
}
