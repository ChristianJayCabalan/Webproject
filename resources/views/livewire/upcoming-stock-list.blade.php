<div> <!-- ✅ single root element for Livewire -->

    <div class="container my-5">
        <!-- Header -->
        <div class="text-center my-4">
            <div class="d-inline-block px-5 py-3 rounded-3 shadow-lg position-relative upcoming-header">
                <h1 class="fw-bold mb-0">Up-Coming Product</h1>

                <span class="nail-left"></span>
                <span class="nail-right"></span>
            </div>
        </div>

        @if($stocks->isEmpty())
            <div class="alert alert-info text-center fs-5">
                No upcoming stock available.
            </div>
        @else
            <div class="row g-4">
                @foreach ($stocks as $stock)
                    <div class="col-stock"> <!-- responsive column -->
                        <div class="card h-100 shadow rounded-4 border-0 card-stock">

                            <img src="{{ $stock->image ? asset('storage/' . $stock->image) : asset('theme_asset/home/img/default-product.png') }}" 
                                 class="card-img-top rounded-top-5" 
                                 alt="{{ $stock->product_name }}" 
                                 style="height: 250px; object-fit: cover;">

                            <div class="card-body text-center">
                                <h2 class="card-title fw-bold card-title-stock">
                                    {{ $stock->product_name }}
                                </h2>

                                <p class="mb-1">
                                    <strong>Category:</strong> 
                                    <span class="text-primary">{{ $stock->category->name }}</span>
                                </p>

                                <p class="mb-1">
                                    <strong>Quantity:</strong> {{ $stock->incoming_quantity }}
                                </p>

                                <p class="mb-1 text-danger">
                                    <strong>Expected:</strong> {{ \Carbon\Carbon::parse($stock->expected_arrival)->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
<link rel="stylesheet" href="{{ asset('css/up-coming-list.css') }}">

</div> <!-- ✅ end single root -->
