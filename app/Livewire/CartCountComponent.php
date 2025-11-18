<?php

namespace App\Livewire;

use Livewire\Component;

class CartCountComponent extends Component
{
    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public $count = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $cart = session('cart', []);
        $this->count = array_sum(array_column($cart, 'quantity'));
    }

    public function render()
    {
        return view('livewire.cart-count-component');
    }
}
