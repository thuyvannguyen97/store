<?php

namespace App\Http\Controllers\frontend;

use App\models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;

class CartController extends Controller
{
    function getCart(){
        $data['cart'] = Cart::content();
        // dd($data['cart']->toarray());
        $data['total'] = Cart::total(0,"",".");
        return view('frontend.cart.cart', $data);
    }
    function addCart(request $r){
        $prd = Product::find($r->id_product);
        if ($r->quantity != '') {
            $qty = $r->$quantity;
        }
        else {
            $qty = 1;
        }
        Cart::add(['id' => $prd->code, 'name' => $prd->name, 'qty' => $qty, 'price' => $prd->price, 'weight' => 0, 'options' => ['img' => $prd->img]]);
        return redirect('/cart');
    }
    function delCart($rowId){
        Cart::remove($rowId);
        return redirect('/cart');
    }
    function updateCart($rowId, $qty){
        Cart::update($rowId, $qty);
        return 'success';
    }
}
