<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('order_history', compact('orders'));
    }
}
