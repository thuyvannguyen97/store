<?php

namespace App\Http\Controllers\frontend;

use App\models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Cart;

class HomeController extends Controller
{
    function getAbout(){
        return view('frontend.about');
    }
    function getContact(){
        return view('frontend.contact');
    }
    function getIndex(){
        $data['prd_new'] = Product::where('img', '<>', 'no-img.jpg')->orderBy('id', 'desc')->take(8)->get();
        $data['prd_featured'] = Product::where('featured',1)->where('img', '<>', 'no-img.jpg')->orderBy('id', 'desc')->take(4)->get();
        return view('frontend.index', $data);
    }
    function sendMail(request $r){
        $data['email'] = $r->email;
        // $data['cart'] = Cart::content();
        Mail::send('mail', $data, function ($message) use ($data){
            $message->from('thuyvannguyen97.bk@gmail.com', 'VIETPRO');
            $message->to($data['email'], 'Customer');
            $message->subject('Confirm Order');
        });
    }
}
