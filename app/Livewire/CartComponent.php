<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;

class CartComponent extends Component
{
    public $cart = [];
    public $total = 0;
    public $phoneNumber;

    public $province = 'Bohol';
    public $municipality = 'Talibon';
    public $barangay;
    public $purok;

    public $barangays = [];
    public $puroks = [];

    public $allBarangays = [
        'Bagacay', 'Balintawak', 'Burgos', 'Busalian', 'Calituban',
        'Cataban', 'Guindacpan', 'Magsaysay', 'Mahanay', 'Nocnocan',
        'Poblacion', 'Rizal', 'Sag', 'San Agustin', 'San Carlos',
        'San Francisco', 'San Isidro', 'San Jose', 'San Pedro',
        'San Roque', 'Santo Niño', 'Sikatuna', 'Suba', 'Tanghaligue', 'Zamora'
    ];

    public $allPuroks = [
        'Bagacay' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Balintawak' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Burgos' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Busalian' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Calituban' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Cataban' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Guindacpan' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Magsaysay' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Mahanay' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Nocnocan' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Poblacion' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Rizal' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Sag' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'San Agustin' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'San Carlos' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'San Francisco' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'San Isidro' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'San Jose' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'San Pedro' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'San Roque' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Santo Niño' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Sikatuna' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Suba' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Tanghaligue' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
        'Zamora' => ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'],
    ];

    public function mount()
    {
        $this->loadCart();

        $this->barangays = $this->allBarangays;
        $this->barangay = null;
        $this->puroks = ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'];
        $this->purok = null;
    }

    public function loadCart()
    {
        if(Auth::check()){
            $this->cart = Cart::with('product')->where('user_id', Auth::id())->get()->mapWithKeys(function($item){
                return [$item->product_id => [
                    'title' => $item->product->title,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'image' => $item->product->image,
                    'id' => $item->product->id,
                ]];
            })->toArray();
        } else {
            $this->cart = session()->get('cart', []);
        }

        $this->calculateTotal();
    }

    public function removeFromCart($productId)
    {
        if(Auth::check()){
            Cart::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        } else {
            unset($this->cart[$productId]);
            session()->put('cart', $this->cart);
        }

        $this->loadCart();

        $this->dispatch('swal', [
            'title' => 'Removed from Cart!',
            'text'  => 'The product has been removed from your cart.',
            'icon'  => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function updateQuantity($productId, $quantity)
    {
        $quantity = max(1, (int)$quantity);

        if(Auth::check()){
            Cart::where('user_id', Auth::id())->where('product_id', $productId)->update(['quantity' => $quantity]);
        } else {
            $this->cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $this->cart);
        }

        $this->loadCart();
    }

    public function updatedBarangay($value)
    {
        $this->puroks = $this->allPuroks[$value] ?? ['Purok 1','Purok 2','Purok 3','Purok 4','Purok 5','Purok 6','Purok 7'];
        $this->purok = null;
    }

    public function confirmOrder()
    {
        if(empty($this->cart)){
            $this->dispatch('swal', ['title'=>'Oops!', 'text'=>'Your cart is empty!', 'icon'=>'error']);
            return;
        }

        if(!$this->barangay){
            $this->dispatch('swal', ['title'=>'Reminder!', 'text'=>'Please select your Barangay.','icon'=>'warning']);
            return;
        }

        if(!$this->purok){
            $this->dispatch('swal', ['title'=>'Reminder!', 'text'=>'Please select your Purok.','icon'=>'warning']);
            return;
        }

        if(!$this->phoneNumber || strlen($this->phoneNumber) !== 11){
            $this->dispatch('swal', ['title'=>'Reminder!', 'text'=>'Phone number must be exactly 11 digits.','icon'=>'warning']);
            return;
        }

        $this->validate([
            'barangay' => 'in:' . implode(',', $this->allBarangays),
        ]);

        foreach($this->cart as $productId => $item){
            $productTotal = $item['price'] * $item['quantity'];

            Order::create([
                'product_id' => $productId,
                'user_id' => Auth::id(),
                'quantity' => $item['quantity'],
                'price_per_item' => $item['price'],
                'total_price' => $productTotal,
                'status' => 'pending',
                'province' => $this->province,
                'municipality' => $this->municipality,
                'barangay' => $this->barangay,
                'purok' => $this->purok,
                'phone_number' => $this->phoneNumber,
            ]);
        }

        if(Auth::check()){
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }

        $this->reset(['cart','total','barangay','purok','phoneNumber']);
        $this->dispatch('swal', ['title'=>'Success!','text'=>'Order successfully placed!','icon'=>'success']);
    }

    public function calculateTotal()
    {
        $this->total = array_reduce($this->cart, function ($carry, $item){
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function render()
    {
        return view('livewire.cart-component', [
            'cart' => $this->cart,
            'total' => $this->total,
            'barangays' => $this->barangays,
            'puroks' => $this->puroks,
        ]);
    }
}
