<div>
    <link rel="stylesheet" href="{{ asset('css/add-product.css') }}">


    <!-- Add/Edit Product Button -->
    <button class="ap-btn-toggle" wire:click="toggleForm">
        {{ $showForm ? 'Hide Form' : ($isEditing ? 'Edit Product' : 'Add New Product') }}
    </button>

    <!-- Modal Form -->
    @if ($showForm)
    <div class="ap-modal-backdrop" wire:click.self="toggleForm">
        <div class="ap-modal">
            <h3 class="ap-modal-title">{{ $isEditing ? 'Edit Product' : 'Add New Product' }}</h3>
            <form wire:submit.prevent="{{ $isEditing ? 'updateProduct' : 'saveProduct' }}" enctype="multipart/form-data">

                <label class="ap-label">Product Name</label>
                <input type="text" wire:model.defer="title" class="ap-input" />
                @error('title') <span class="ap-error">{{ $message }}</span> @enderror

                <label class="ap-label mt-2">Category</label>
                <select wire:model.defer="category_id" class="ap-input">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="ap-error">{{ $message }}</span> @enderror

                <label class="ap-label mt-2">Description</label>
                <textarea wire:model.defer="description" class="ap-input"></textarea>

                <label class="ap-label mt-2">Price</label>
                <input type="number" wire:model.defer="price" class="ap-input" />

                <label class="ap-label mt-2">Stock</label>
                <input type="number" wire:model.defer="stock" class="ap-input" />

                <label class="ap-label mt-2">Product Image</label>
                <input type="file" wire:model="image" class="ap-file" />
                @if ($image)
                    <div class="ap-image-preview">
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview">
                    </div>
                @endif

                <div class="ap-modal-actions">
                    <button type="submit" class="ap-btn-submit" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $isEditing ? 'Update Product' : 'Add Product' }}</span>
                        <span wire:loading>Processing...</span>
                    </button>
                    <button type="button" class="ap-btn-cancel" wire:click="toggleForm">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="ap-alert-success">{{ session('message') }}</div>
    @endif

    <!-- Product Table -->
    <div class="card shadow rounded-lg mt-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #ff7f28; color: white;">
            <span>Product List</span>
            <div class="input-group input-group-sm w-auto">
                <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="Search...">
                <button class="btn btn-success" wire:click="applyFilter">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr wire:key="product-{{ $product->id }}">
                                <td>{{ $products->firstItem() + $loop->index }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>₱ {{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" width="50" class="img-thumbnail">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>
                                    <button wire:click="editProduct({{ $product->id }})" class="btn btn-sm btn-primary">Edit</button>
                                    <button wire:click="deleteProduct({{ $product->id }})" class="btn btn-sm btn-danger ms-2">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7">No products found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>
                <div class="d-flex justify-content-center">
    <button class="btn btn-sm btn-secondary me-1" wire:click="previousPage" @if($products->onFirstPage()) disabled @endif>Previous</button>
    <button class="btn btn-sm btn-secondary" wire:click="nextPage" @if(!$products->hasMorePages()) disabled @endif>Next</button>
</div>

            </div>
        </div>
    </div>
</div>
