<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class BrowseProductsComponent extends Component
{
    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text'  => 'Product not found.',
                'icon'  => 'error',
            ]);
            return;
        }

        // Get existing cart
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'title'    => $product->title,
                'price'    => $product->price,
                'stock'    => $product->stock,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        // Trigger header badge update
        $this->dispatch('cartUpdated');

        // SweetAlert
        $this->dispatch('swal', [
            'title' => 'Added to Cart!',
            'text'  => "{$product->title} has been added to your cart.",
            'icon'  => 'success',
        ]);
    }

    public function render()
    {
        $now = \Carbon\Carbon::now();

        // Move expired upcoming stock → product
        $expiredStocks = \App\Models\UpcomingStock::where('expected_arrival', '<=', $now)->get();
        foreach ($expiredStocks as $stock) {
            \App\Models\Product::create($stock->toProduct());
            $stock->delete();
        }

        return view('livewire.browse-products-component', [
            'products' => \App\Models\Product::all(),
        ]);
    }
}
