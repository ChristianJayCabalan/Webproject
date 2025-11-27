<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartCountComponent extends Component
{
    public $cartCount = 0;

    protected $listeners = [
        'cartUpdated' => 'updateCartCount'
    ];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        if (Auth::check()) {
            // Count distinct products for logged-in user
            $this->cartCount = Cart::where('user_id', Auth::id())->count();
        } else {
            // Count distinct products in session cart
            $cart = session()->get('cart', []);
            $this->cartCount = count($cart);
        }
    }

    public function render()
    {
        return view('livewire.cart-count-component', [
            'cartCount' => $this->cartCount
        ]);
    }
}
