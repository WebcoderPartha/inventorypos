<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Vat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{

    public function addToCart(Request $request, $id){

        $product = Product::where('id', $id)->first();

        $addedCart = Cart::where('product_id', $id)->first();

        if ($addedCart){

            $quantity = 1;

            $total_quantity = $addedCart->product_quantity + $quantity;

            $total_subtotal = $product->selling_price * $total_quantity;

            $addedCart->product_id = $product->id;
            $addedCart->product_name = $product->product_name;
            $addedCart->product_quantity = $total_quantity;
            $addedCart->product_price = $product->selling_price;
            $addedCart->product_subtotal = $total_subtotal;
            $addedCart->save();

            return Response::json("Product added successfully");

        }else{

            $quantity = 1;
            $cart = new Cart();
            $cart->product_id = $product->id;
            $cart->product_name = $product->product_name;
            $cart->product_quantity = $quantity;
            $cart->product_price = $product->selling_price;
            $cart->product_subtotal = $product->selling_price * $quantity;
            $cart->save();
            return Response::json("Product added successfully");

        }

    }

    public function getAddToCart(){

        $cart = Cart::all();
        return Response::json($cart);

    }

    public function incrementCart($id){

        $cart = Cart::where('id', $id)->first();

        $quantity = 1;
        $updateQty = $cart->product_quantity + $quantity;
        $cart->product_quantity = $updateQty;
        $cart->product_subtotal = $cart->product_price * $updateQty;
        $cart->save();

        return Response::json("Item quantity increment successfully");

    }

    public function decrementCart($id){

        $quantity = Cart::where('id', $id)->decrement('product_quantity');

        $cart = Cart::where('id', $id)->first();
        $cart->product_subtotal = $cart->product_subtotal - $cart->product_price;
        $cart->save();

        return Response::json("Item quantity decrement successfully");

    }

    public function removeCart($id){

        $cart = Cart::where('id', $id)->first();
        $cart->delete();
        return Response::json("Cart item removed successfully");

    }

    public function cartDetails(){

        $totalQty = Cart::sum('product_quantity');
        $subtotal = Cart::sum('product_subtotal');
        $get_vat = Vat::where('id', 1)->first();
        $vat = $get_vat->vat;

        $total = ($subtotal * $vat)/100 + $subtotal;

        return Response::json([
            'total_qty'     => $totalQty,
            'total_subtial' => $subtotal,
            'total'           =>$total
        ]);
    }




}
