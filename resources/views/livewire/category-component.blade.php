<div>
    <link rel="stylesheet" href="{{ asset('css/add-product.css') }}">

    <!-- Toggle Button -->
    <button class="ap-btn-toggle" wire:click="$toggle('showForm')">
        {{ $showForm ? 'Hide Form' : ($isEditing ? 'Edit Category' : 'Add New Category') }}
    </button>

    <!-- Modal Form -->
    @if ($showForm)
    <div class="ap-modal-backdrop" wire:click.self="$set('showForm', false)">
        <div class="ap-modal">
            <h3 class="ap-modal-title">{{ $isEditing ? 'Edit Category' : 'Add New Category' }}</h3>
            <form wire:submit.prevent="saveCategory">
                <label class="ap-label">Category Name</label>
                <input type="text" wire:model.defer="name" class="ap-input" placeholder="Enter category name" />
                @error('name') <span class="ap-error">{{ $message }}</span> @enderror

                <div class="ap-modal-actions">
                    <button type="submit" class="ap-btn-submit" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $isEditing ? 'Update Category' : 'Add Category' }}</span>
                        <span wire:loading>Processing...</span>
                    </button>
                    <button type="button" class="ap-btn-cancel" wire:click="$set('showForm', false)">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="ap-alert-success mt-2">{{ session('message') }}</div>
    @endif



    <!-- Categories Table -->
    <div class="card shadow rounded-lg mt-2">
        <div class="card-header" style="background-color: #ff7f28; color: white;">
            <span>Category List</span>
            
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr wire:key="category-{{ $category->id }}">
                            <td>{{ $categories->firstItem() + $loop->index }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <button wire:click="editCategory({{ $category->id }})" class="btn btn-sm btn-primary">Edit</button>
                                <button x-data @click="if(confirm('Are you sure?')) { $wire.deleteCategory({{ $category->id }}) }" class="btn btn-sm btn-danger ms-2">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3">No categories found.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} categories
                    </div>
                    <div>
                        <button class="btn btn-sm btn-secondary me-1" wire:click="previousPage" @if($categories->onFirstPage()) disabled @endif>Previous</button>
                        <button class="btn btn-sm btn-secondary" wire:click="nextPage" @if(!$categories->hasMorePages()) disabled @endif>Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
