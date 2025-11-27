<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Review;
use Livewire\Component;
use App\Models\Cart;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class SingleProductComponent extends Component
{
    use WithFileUploads;

    public $product;
    public $rating = 0;
    public $comment;
    public $image;

    public function mount($id)
    {
        $this->product = Product::with(['reviews.user'])->findOrFail($id);
    }

    public function addToCart($productId)
{
    $product = Product::findOrFail($productId);

    // If user is logged in - use database cart
    if (Auth::check()) {
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            // ADD TO QUANTITY (NOT ADD TO COUNT)
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // CREATE NEW CART ITEM ONLY IF NOT EXIST
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

    } else { 
        // GUEST USER – SESSION CART
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
    }

        $this->dispatch('cartUpdated');
        $this->dispatch('swal', ['title'=>'Added to Cart!','text'=>"{$product->title} has been added to your cart.",'icon'=>'success']);
    }

    public function addReview()
    {
        if (!Auth::check()) {
            $this->dispatch('swal', [
                'title' => 'You must be logged in to leave a review.',
                'icon' => 'error',
                'draggable' => true
            ]);
            return;
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $imagePath = $this->image ? $this->image->store('review_images', 'public') : null;

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'image' => $imagePath,
        ]);

        $this->product->load('reviews.user');
        $this->reset(['rating', 'comment', 'image']);

        $this->dispatch('swal', [
            'title' => 'Review submitted successfully!',
            'icon' => 'success',
            'draggable' => true
        ]);
    }

    public function render()
    {
        return view('livewire.single-product-component', [
            'product' => $this->product
        ]);
    }
}
