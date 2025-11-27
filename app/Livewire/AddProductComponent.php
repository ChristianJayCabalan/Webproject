<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class AddProductComponent extends Component
{
    use WithFileUploads, WithPagination;

    public $title, $description, $price, $image, $category_id, $stock;
    public $product_id; // For editing
    public $isEditing = false;
    public $search = '';
    public $showForm = false;

    protected $paginationTheme = 'bootstrap';

    // Toggle form
    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetFields();
        }
    }

    // Reset fields
    private function resetFields()
    {
        $this->reset(['title', 'category_id', 'description', 'price', 'stock', 'image', 'product_id', 'isEditing']);
    }

    // Search filter
    public function updatingSearch()
    {
        $this->resetPage();
    }
    // Clear search and restore full table
public function clearSearch()
{
    $this->search = '';
    $this->resetPage();
}


    public function applyFilter()
    {
        $this->resetPage();
    }

    // Add product
    public function saveProduct()
    {
        $this->validate([
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:5',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|max:1024',
        ]);

        $path = $this->image ? $this->image->store('products', 'public') : null;

        Product::create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $path,
        ]);

        session()->flash('message', 'Product added successfully!');
        $this->toggleForm();
    }

    // Edit product
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $product->id;
        $this->title = $product->title;
        $this->category_id = $product->category_id;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->isEditing = true;
        $this->showForm = true; // modal opens
    }

    // Update product
    public function updateProduct()
    {
        $this->validate([
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:5',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|max:1024',
        ]);

        $product = Product::findOrFail($this->product_id);

        $product->update([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
        ]);

        if ($this->image) {
            $product->update([
                'image' => $this->image->store('products', 'public'),
            ]);
        }

        session()->flash('message', 'Product updated successfully!');
        $this->toggleForm();
    }

    // Delete product
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            \Storage::delete('public/' . $product->image);
        }
        $product->delete();
        session()->flash('message', 'Product deleted successfully!');
    }

    public function render()
{
    $products = Product::with('category')
        ->when($this->search, function ($query) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhereHas('category', fn($q2) => $q2->where('name', 'like', $searchTerm))
                  ->orWhere('price', 'like', $searchTerm)
                  ->orWhere('stock', 'like', $searchTerm);
            });
        })
        ->latest()
        ->paginate(10);

    return view('livewire.add-product-component', [
        'categories' => Category::all(),
        'products' => $products,
    ])->layout('components.layouts.admin');
}

}
