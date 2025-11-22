<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Cart;
use App\Models\UpcomingStock;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class BrowseProductsComponent extends Component
{
    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);

        if (!$product) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'text'  => 'Product not found.',
                'icon'  => 'error',
            ]);
            return;
        }

        if (Auth::check()) {
            // Save to database if logged in
            $cartItem = Cart::firstOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $productId],
                ['quantity' => 0]
            );
            $cartItem->increment('quantity', $quantity);
        } else {
            // Save to session if guest
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'title'    => $product->title,
                    'price'    => $product->price,
                    'stock'    => $product->stock,
                    'quantity' => $quantity,
                ];
            }
            session()->put('cart', $cart);
        }

        // Notify frontend for cart badge update
        $this->dispatchBrowserEvent('cartUpdated');

        // SweetAlert notification
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Added to Cart!',
            'text'  => "{$product->title} has been added to your cart.",
            'icon'  => 'success',
        ]);
    }

    public function render()
    {
        $now = Carbon::now();

        // Move expired upcoming stock → products
        $expiredStocks = UpcomingStock::where('expected_arrival', '<=', $now)->get();
        foreach ($expiredStocks as $stock) {
            Product::create($stock->toProduct());
            $stock->delete();
        }

        return view('livewire.browse-products-component', [
            'products' => Product::all(),
        ]);
    }
}
