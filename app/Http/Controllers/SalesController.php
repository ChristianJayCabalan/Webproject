<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function weekly()
{
    $orders = Order::with(['user', 'product'])
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->where('status', 'approved')
        ->get();

    // Calculate total of all sales
    $totalSales = $orders->sum('total_price');

    return view('sales.weekly', [
        'orders' => $orders,
        'title' => 'Weekly Sales',
        'totalSales' => $totalSales
    ]);
}



    public function monthly()
    {
        $orders = Order::with(['user', 'product'])
            ->whereMonth('created_at', now()->month)
            ->where('status', 'approved')
            ->get();

        $totalSales = $orders->sum('total_price');

        return view('sales.monthly', [
            'orders' => $orders,
            'title' => 'Monthly Sales',
            'totalSales' => $totalSales
        ]);
    }



    public function yearly()
{
    $orders = Order::with(['user', 'product'])
        ->whereYear('created_at', now()->year)
        ->where('status', 'approved') // only approved sales
        ->get();

    $totalSales = $orders->sum('total_price');

    return view('sales.yearly', [
        'orders' => $orders,
        'title' => 'Yearly Sales',
        'totalSales' => $totalSales
    ]);
}

}
