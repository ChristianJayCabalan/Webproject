<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\UpcomingStock;

class AddUpcomingStock extends Component
{
    use WithFileUploads, WithPagination;

    public $category_id, $product_name, $incoming_quantity, $expected_arrival, $image;
    public $upcomingStockId;
    public $isEditing = false;
    public $search = '';
    public $showForm = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'category_id' => 'required|exists:categories,id',
        'product_name' => 'required|string|max:255',
        'incoming_quantity' => 'required|integer|min:1',
        'expected_arrival' => 'required|date|after:today',
        'image' => 'nullable|image|max:10240',
    ];

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->resetForm();
    }

    public function applyFilter()
    {
        $this->resetPage();
    }
    // Clear search and restore full table
public function clearSearch()
{
    $this->search = '';
    $this->resetPage();
}


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate();
        $imagePath = $this->image ? $this->image->store('upcoming_stocks', 'public') : null;

        UpcomingStock::create([
            'category_id' => $this->category_id,
            'product_name' => $this->product_name,
            'incoming_quantity' => $this->incoming_quantity,
            'expected_arrival' => $this->expected_arrival,
            'image' => $imagePath,
        ]);

        $this->resetForm();
        $this->showForm = false;
        session()->flash('message', 'Upcoming stock added successfully!');
    }

    public function edit($id)
    {
        $stock = UpcomingStock::findOrFail($id);

        $this->upcomingStockId = $stock->id;
        $this->category_id = $stock->category_id;
        $this->product_name = $stock->product_name;
        $this->incoming_quantity = $stock->incoming_quantity;
        $this->expected_arrival = \Carbon\Carbon::parse($stock->expected_arrival)->format('Y-m-d\TH:i');
        $this->image = null;
        $this->isEditing = true;
        $this->showForm = true;

        // 🔹 Fix: go to page containing this stock
        $page = $this->getPageOfItem($stock->id);
        $this->gotoPage($page);
    }

    public function update()
    {
        $this->validate();
        $stock = UpcomingStock::findOrFail($this->upcomingStockId);

        $imagePath = $stock->image;
        if ($this->image) {
            $imagePath = $this->image->store('upcoming_stocks', 'public');
        }

        $stock->update([
            'category_id' => $this->category_id,
            'product_name' => $this->product_name,
            'incoming_quantity' => $this->incoming_quantity,
            'expected_arrival' => $this->expected_arrival,
            'image' => $imagePath,
        ]);

        $this->resetForm();
        $this->showForm = false;
        session()->flash('message', 'Upcoming stock updated successfully!');
    }

    public function delete($id)
    {
        $stock = UpcomingStock::findOrFail($id);
        if ($stock->image) {
            \Storage::delete('public/' . $stock->image);
        }
        $stock->delete();
        session()->flash('message', 'Upcoming stock deleted successfully!');
    }

    private function resetForm()
    {
        $this->reset(['category_id', 'product_name', 'incoming_quantity', 'expected_arrival', 'image', 'upcomingStockId', 'isEditing']);
    }

    // 🔹 Helper: calculate page number for the edited stock
    private function getPageOfItem($id)
    {
        $perPage = 10;
        $allIds = UpcomingStock::latest()->pluck('id')->toArray();
        $index = array_search($id, $allIds);
        return $index !== false ? intval(floor($index / $perPage)) + 1 : 1;
    }

    public function render()
{
    $stocks = UpcomingStock::with('category')
        ->when($this->search, function ($query) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('product_name', 'like', $searchTerm)
                  ->orWhereHas('category', fn($q2) => $q2->where('name', 'like', $searchTerm))
                  ->orWhere('incoming_quantity', 'like', $searchTerm)
                  ->orWhere('expected_arrival', 'like', $searchTerm);
            });
        })
        ->latest()
        ->paginate(10);

    return view('livewire.add-upcoming-stock', [
        'categories' => Category::all(),
        'stocks' => $stocks,
    ])->layout('components.layouts.admin');
}

}
