<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $products = Product::all();
        return view('orders/index', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        //user id
        $id = Auth::id();
        $order = new Order();
        $order->product_id = $request->product_id;
        $order->total = $request->total;
        $order->user_id = $id;
        $order->save();

        return Response()->json($order);
    }

}
