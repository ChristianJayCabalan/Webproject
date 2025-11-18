<?php

namespace App\Http\Controllers;

use App\Models\UpcomingStock;
use Illuminate\Http\Request;

class UpcomingStockController extends Controller
{
    public function index()
    {
        // Load upcoming stocks with their related product and category
        $upcomingStocks = UpcomingStock::with('product.category')
            ->where('status', 'pending')
            ->orderBy('expected_arrival', 'asc')
            ->get();

        return view('up_comming_stock.up_comming_stock', compact('upcomingStocks'));
    }
}

