<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($id)
    {
        $category = Category::findOrFail($id);

        // Show only 5 products per page
        $products = Product::where('category_id', $id)
            ->paginate(5);

        return view('category', compact('products', 'category'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        $categories = Category::where('name', 'like', '%' . $query . '%')->get();

        return view('search-results', compact('query', 'products', 'categories'));
    }
}
