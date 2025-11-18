<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;

    public $name;
    public $isEditing = false;
    public $editId;
    public $showForm = false;
    public $search = ''; // 🔹 Live search property

    protected $paginationTheme = 'bootstrap';

    // 🔹 Reset pagination when typing in search
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function saveCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->isEditing) {
            $category = Category::find($this->editId);
            if ($category) {
                $category->update(['name' => $this->name]);
                session()->flash('message', 'Category updated successfully!');
            }
        } else {
            Category::create(['name' => $this->name]);
            session()->flash('message', 'Category added successfully!');
        }

        $this->resetForm();
        $this->resetPage(); // 🔹 reset pagination after add/update
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $this->name = $category->name;
            $this->editId = $id;
            $this->isEditing = true;
            $this->showForm = true;
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            session()->flash('message', 'Category deleted successfully!');
            $this->resetPage(); // 🔹 reset pagination after delete
        }
    }

    private function resetForm()
    {
        $this->name = '';
        $this->editId = null;
        $this->isEditing = false;
        $this->showForm = false;
    }

    public function render()
    {
        // 🔹 Apply live search filter
        $categories = Category::when($this->search, function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->latest()
                    ->paginate(10);

        return view('livewire.category-component', compact('categories'))
               ->layout('components.layouts.admin');
    }
}
