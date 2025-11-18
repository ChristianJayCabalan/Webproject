<div> <!-- ✅ single root element for Livewire -->

    <div class="container my-5">
        <div class="text-center my-4">
            <div class="d-inline-block px-5 py-3 rounded-3 shadow-lg position-relative"
                 style="background: rgba(139, 69, 19, 0.8);
                        background: linear-gradient(135deg, rgba(139,69,19,0.9), rgba(160,82,45,0.8));
                        color: #fff;
                        border: 3px solid #5a2d0c;">
                <h1 class="fw-bold mb-0">Up-Coming Product</h1>

                <!-- Nails -->
                <span style="position: absolute; top: 10px; left: 10px; 
                             width: 15px; height: 15px; background: #555; 
                             border-radius: 50%; box-shadow: inset 2px 2px 4px #000;">
                </span>
                <span style="position: absolute; top: 10px; right: 10px; 
                             width: 15px; height: 15px; background: #555; 
                             border-radius: 50%; box-shadow: inset 2px 2px 4px #000;">
                </span>
            </div>
        </div>

        @if($stocks->isEmpty())
            <div class="alert alert-info text-center fs-5">
                No upcoming stock available.
            </div>
        @else
            <div class="row g-4">
                @foreach ($stocks as $stock)
                    <div class="col-md-2-4"> <!-- custom 5 per row -->
                        <div class="card h-100 shadow rounded-4 border-0" 
                            style="background: rgba(255,255,255,0.8);">

                            @if ($stock->image)
                                <img src="{{ asset('storage/' . $stock->image) }}" 
                                     class="card-img-top rounded-top-5" 
                                     alt="{{ $stock->product_name }}" 
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <img src="{{ asset('theme_asset/home/img/default-product.png') }}" 
                                     class="card-img-top rounded-top-4" 
                                     alt="No Image" 
                                     style="height: 250px; object-fit: cover;">
                            @endif

                            <div class="card-body text-center">
                                <h2 class="card-title fw-bold" 
                                    style="color: #8bf581ff; text-shadow: 2px 2px 4px black;">
                                    {{ $stock->product_name }}
                                </h2>

                                <p class="mb-1">
                                    <strong>Category:</strong> 
                                    <span style="color: blue;">{{ $stock->category->name }}</span>
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

    <style>
    /* ✅ Custom column for 5 per row */
    @media (min-width: 768px) {
        .col-md-2-4 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }
    </style>

</div> <!-- ✅ end single root -->
