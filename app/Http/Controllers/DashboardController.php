<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        // Featured products (stock > 0), limit sa 4
        $featuredProducts = Product::where('stock', '>', 0)
                                   ->latest()
                                   ->take(4)
                                   ->get();

        // Latest 5 customer reviews
        $reviews = Review::with('user')->latest()->take(5)->get();

        return view('dashboard', compact('featuredProducts', 'reviews'));
    }
}

