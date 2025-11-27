<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BrowseProductsComponent extends Component
{
    public function addToCart($productId)
{
    $product = Product::find($productId);
    if(!$product){
        $this->dispatch('swal', ['title'=>'Error','text'=>'Product not found.','icon'=>'error']);
        return;
    }

    if (Auth::check()) {
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity'); // Existing product → increment quantity
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }
    } else {
        $cart = session()->get('cart', []);
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity']++; // Existing product → increment quantity
        } else {
            $cart[$productId] = [
                'title'=>$product->title,
                'price'=>$product->price,
                'stock'=>$product->stock,
                'quantity'=>1
            ];
        }
        session()->put('cart', $cart);
    }
        $this->dispatch('cartUpdated');
        $this->dispatch('swal', ['title'=>'Added to Cart!','text'=>"{$product->title} has been added to your cart.",'icon'=>'success']);
    }

    public function render()
    {
        $now = \Carbon\Carbon::now();
        $expiredStocks = \App\Models\UpcomingStock::where('expected_arrival','<=',$now)->get();
        foreach($expiredStocks as $stock){
            \App\Models\Product::create($stock->toProduct());
            $stock->delete();
        }

        return view('livewire.browse-products-component', [
            'products'=>Product::all(),
        ]);
    }
}
