<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{


    public function orderSuccess(Request $request){

        $validateData = $request->validate([
            'customer_id' => 'required',
            'advance' => 'required',
            'due' => 'required',
            'pay_by' => 'required'
        ]);

        $order = new Order();

//        $order->customer_id = $request->customer_id;
//        $order->advance = $request->advance;
//        $order->due = $request->due;
//        $order->pay_by = $request->pay_by;
//        $order->total_qty = $request->total_qty;
//        $order->total_subtotal = $request->total_subtotal;
//        $order->vat = $request->vat;
//        $order->total = $request->total;
//        $order->order_date = date('d-m-Y');
//        $order->order_month = date('F');
//        $order->order_year = date('Y');

        $orderId            = Order::insertGetId([
            'customer_id'   => $request->customer_id,
            'advance'       => $request->advance,
            'due'           => $request->due,
            'pay_by'        => $request->pay_by,
            'total_qty'     => $request->total_qty,
            'total_subtotal'=> $request->total_subtotal,
            'vat'           => $request->vat,
            'total'         => $request->total,
            'order_date'    => date('d-m-Y'),
            'order_month'   => date('F'),
            'order_year'    => date('Y'),
        ]);

        $orderDetails = Cart::all();

        foreach ($orderDetails as $order_detail){
            $product_id = $order_detail->product_id;
            $product_quantity = $order_detail->product_quantity;
            $product_price = $order_detail->product_price;
            $product_subtotal = $order_detail->product_subtotal;

            // Insert Order Details
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $orderId;
            $orderDetail->product_id = $product_id;
            $orderDetail->product_qty = $product_quantity;
            $orderDetail->product_price = $product_price;
            $orderDetail->product_subtotal = $product_subtotal;
            $orderDetail->save();

            // Update Quantity
            $product = Product::where('id', $product_id)->first();
            $update_qty = $product->quantity - $product_quantity;
            $product->quantity = $update_qty;
            $product->save();

            // Delete Cart Item
            $cart = Cart::where('id', $order_detail->id)->first();

            $cart->delete();
        }

        return Response::json("Order done successfully");

    }

    public function getTodayOrder(){

        $date = date('d-m-Y');
        $order = Order::with('customer')->where('order_date', $date)->orderByDesc('id')->get();
        return Response::json($order);

    }

    public function getOrderDetails($id){

        $orderDetail = OrderDetail::with('product')->where('order_id', $id)->get();
        return Response::json($orderDetail);

    }

    public function getSingleOrder($id){
        $order = Order::with('customer')->where('id', $id)->first();
        return Response::json($order);
    }

    public function getAllOrder(){

        $order = Order::with('customer')->orderByDesc('id')->get();
        return Response::json($order);

    }

    public function searchOrder(Request $request){

        $validateData = $request->validate([
            'date' => 'required'
        ]);

        $date = date('d-m-Y', strtotime($request->date));
        $order = Order::with('customer')->where('order_date', $date)->orderByDesc('id')->get();

        return Response::json($order);

    }

    public function todaySale(){

        $todayDate = date('d-m-Y');
        $sale = Order::where('order_date', $todayDate)->sum('total');
        return Response::json($sale);

    }
    public function todayIncome(){

        $todayDate = date('d-m-Y');
        $income = Order::where('order_date', $todayDate)->sum('advance');
        return Response::json($income);

    }
    public function todayDue(){

        $todayDate = date('d-m-Y');
        $due = Order::where('order_date', $todayDate)->sum('due');
        return Response::json($due);

    }
    public function todayExpense(){

        $todayDate = date('d-m-Y');
        $expense = Expense::where('expense_date', $todayDate)->sum('expense_amount');
        return Response::json($expense);

    }

    public function getStockOutProduct(){

        $product = Product::with('category')->where('quantity', '<', 1)->orderByDesc('id')->get();
        return Response::json($product);

    }

}
