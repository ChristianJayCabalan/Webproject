<div class="container-fluid mt-4">

<h2>Orders</h2>

    
    {{-- Table List --}}
    <div class="card shadow rounded-lg mt-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #ff7f28; color: white;">
            <span>All Orders</span>

            

            {{-- 🔍 Search by Date + Filter Button --}}
            <div class="input-group input-group-sm w-auto">
    <input type="date" 
           wire:model.defer="search" 
           class="form-control">

    @if ($search)
        <!-- Back button visible only when search is not empty -->
        <button type="button" class="btn btn-warning ms-1" wire:click="clearFilter">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    @endif

    <button class="btn btn-success ms-1" wire:click="applyFilter">
        <i class="fas fa-search"></i> Filter
    </button>
</div>

        </div>

        {{-- Success / Error Messages --}}
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 text-center align-middle">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price/Item</th>
                            <th>Total</th>
                            <th>User</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Date Ordered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $orders->firstItem() + $loop->index }}</td> <!-- ✅ global numbering -->
                                <td>{{ $order->product->title }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>₱ {{ number_format($order->price_per_item, 2) }}</td>
                                <td>₱ {{ number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->purok }}, {{ $order->barangay }}, {{ $order->municipality }}, {{ $order->province }}</td>
                                <td>{{ $order->phone_number ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->status == 'approved') bg-success
                                        @elseif($order->status == 'cancelled') bg-danger
                                        @else bg-warning text-dark
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button 
                                            class="btn btn-sm btn-success" 
                                            wire:click="approveOrder({{ $order->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="approveOrder({{ $order->id }})">
                                            <span wire:loading.remove wire:target="approveOrder({{ $order->id }})">Approve</span>
                                            <span wire:loading wire:target="approveOrder({{ $order->id }})">
                                                <i class="fas fa-spinner fa-spin"></i> Processing...
                                            </span>
                                        </button>

                                        <button 
                                            class="btn btn-sm btn-danger" 
                                            wire:click="cancelOrder({{ $order->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="cancelOrder({{ $order->id }})">
                                            <span wire:loading.remove wire:target="cancelOrder({{ $order->id }})">Cancel</span>
                                            <span wire:loading wire:target="cancelOrder({{ $order->id }})">
                                                <i class="fas fa-spinner fa-spin"></i> Cancelling...
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                </div>

                <div>
                    <button class="btn btn-sm btn-secondary me-1" 
                            wire:click="previousPage" 
                            @if($orders->onFirstPage()) disabled @endif>
                        Previous
                    </button>
                    <button class="btn btn-sm btn-secondary" 
                            wire:click="nextPage" 
                            @if(!$orders->hasMorePages()) disabled @endif>
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
