<?php

namespace App\Http\Controllers\frontend;

use Cart;
use App\models\Order;
use App\models\ProductOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    function getCheckout(){
        $data['cart'] = Cart::content();
        $data['total'] = Cart::total(0,"",".");
        return view('frontend.checkout.checkout', $data);
    }
    function postCheckout(CheckoutRequest $r){
        $order = new Order();
        $order->full = $r->fname;
        $order->address = $r->address;
        $order->email = $r->email;
        $order->phone = $r->phone;
        $order->total = Cart::total(0,"","");
        $order->state = 2;
        $order->save();
        //save each product of cart into table ProductOrder
        foreach(Cart::content() as $row){
            $prd = new ProductOrder();
            $prd->code = $row->id;
            $prd->name = $row->name;
            $prd->price = $row->price;
            $prd->qty = $row->qty;
            $prd->img = $row->options->img;
            $prd->order_id = $order->id;
            $prd->save();
        }
        //delete cart when checkout was complete
        Cart::destroy();
        return redirect('/checkout/complete/'.$order->id);

    }

    function getComplete($order_id){
        $data['order'] = Order::find($order_id);
        return view('frontend.checkout.complete', $data);
    }
}
