<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\UpcomingStock;

class SearchResults extends Component
{
    public $query;

    public function mount()
    {
        $this->query = request()->get('query');
    }

    public function render()
{
    // Search Products
$products = Product::with('category')
    ->where('title', 'like', "%{$this->query}%")
    ->orWhere('description', 'like', "%{$this->query}%")
    ->orWhereHas('category', function ($q) {
        $q->where('name', 'like', "%{$this->query}%");
    })
    ->get();


    // Search Categories
    $categories = Category::where('name', 'like', "%{$this->query}%")->get();

    // Search Upcoming Stocks
    $upcoming = UpcomingStock::with('category')
        ->where('product_name', 'like', "%{$this->query}%")
        ->orWhereHas('category', function ($q) {
            $q->where('name', 'like', "%{$this->query}%");
        })
        ->get();

    return view('livewire.search-results', [
        'products' => $products,
        'categories' => $categories,
        'upcoming' => $upcoming,
        'query' => $this->query
    ])->layout('components.layouts.app');
}

}
