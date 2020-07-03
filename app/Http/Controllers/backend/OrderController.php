<?php

namespace App\Http\Controllers\backend;

use App\models\Order;
use App\models\ProductOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    function getOrder(){
        $data['orders'] = Order::where('state',2)->orderBy('updated_at', 'desc')->get();
        return view('backend.order.order', $data);
    }
    function getDetailOrder($orderId){
        $data['order']=Order::find($orderId);
        return view('backend.order.detailorder', $data);
    }
    function getPaid($orderId){
        $order = Order::find($orderId);
        $order->state = 1;
        $order->save();
        return redirect('/admin/order/processed');
    }
    function getProcessed(){
        $data['processed'] = Order::where('state',1)->orderBy('updated_at', 'desc')->get();        
        return view('backend.order.processed', $data);
    }
}
