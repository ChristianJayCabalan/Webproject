<div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/add-upcoming-stock.css') }}">

    <!-- Add/Edit Toggle Button -->
    <button class="ap-btn-toggle" wire:click="toggleForm">
        {{ $showForm ? 'Hide Form' : ($isEditing ? 'Edit Upcoming Product' : 'Add Upcoming Product') }}
    </button>

    <!-- Modal Form -->
    @if ($showForm)
    <div class="ap-modal-backdrop" wire:click.self="toggleForm">
        <div class="ap-modal">
            <h3 class="ap-modal-title">{{ $isEditing ? 'Edit Upcoming Product' : 'Add Upcoming Product' }}</h3>

            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'save' }}" enctype="multipart/form-data">

                <label class="ap-label">Category</label>
                <select wire:model.defer="category_id" class="ap-input">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="ap-error">{{ $message }}</span> @enderror

                <label class="ap-label mt-2">Product Name</label>
                <input type="text" wire:model.defer="product_name" class="ap-input">
                @error('product_name') <span class="ap-error">{{ $message }}</span> @enderror

                <label class="ap-label mt-2">Incoming Quantity</label>
                <input type="number" wire:model.defer="incoming_quantity" class="ap-input">
                @error('incoming_quantity') <span class="ap-error">{{ $message }}</span> @enderror

                <label class="ap-label mt-2">Expected Arrival</label>
                <input type="datetime-local" wire:model.defer="expected_arrival" class="ap-input">
                @error('expected_arrival') <span class="ap-error">{{ $message }}</span> @enderror

                <label class="ap-label mt-2">Image (optional)</label>
                <input type="file" wire:model="image" class="ap-file">
                @if ($image)
                    <div class="ap-image-preview">
                        <img src="{{ $image->temporaryUrl() }}" alt="Preview">
                    </div>
                @endif

                <div class="ap-modal-actions mt-3">
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
        <div class="ap-alert-success mt-3">{{ session('message') }}</div>
    @endif

    <!-- Upcoming Stocks Table -->
    <div class="card shadow rounded-lg mt-4">
        <div class="card-header card-header-stock d-flex justify-content-between align-items-center">
            <span>Upcoming Products</span>
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
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Expected Arrival</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stocks as $stock)
                        <tr wire:key="stock-{{ $stock->id }}">
                            <td>{{ $stocks->firstItem() + $loop->index }}</td>
                            <td>{{ $stock->category->name }}</td>
                            <td>{{ $stock->product_name }}</td>
                            <td>{{ $stock->incoming_quantity }}</td>
                            <td>{{ \Carbon\Carbon::parse($stock->expected_arrival)->format('M d, Y h:i A') }}</td>
                            <td>
                                @if ($stock->image)
                                    <img src="{{ asset('storage/' . $stock->image) }}" width="50" class="img-thumbnail">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <button wire:click="edit({{ $stock->id }})" class="btn btn-sm btn-primary">Edit</button>
                                <button wire:click="delete({{ $stock->id }})" class="btn btn-sm btn-danger ms-2">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-muted">No upcoming stocks found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $stocks->firstItem() ?? 0 }} to {{ $stocks->lastItem() ?? 0 }} of {{ $stocks->total() }} upcoming stocks
                </div>
                <div class="d-flex">
                    <button class="btn btn-sm btn-secondary me-1"
                            wire:click="previousPage"
                            @if($stocks->onFirstPage()) disabled @endif>
                        Previous
                    </button>
                    <button class="btn btn-sm btn-secondary"
                            wire:click="nextPage"
                            @if(!$stocks->hasMorePages()) disabled @endif>
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
