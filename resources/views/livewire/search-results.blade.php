<div class="container mt-5">
    <div class="text-center my-4">
    <div class="d-inline-block px-5 py-3 rounded-3 shadow-lg position-relative"
         style="background: linear-gradient(135deg, rgba(139,69,19,0.9), rgba(160,82,45,0.8));
                color: #fff;
                border: 3px solid #5a2d0c;">
        <h3 class="fw-bold mb-0">
            Search Results for: 
            <span style="color: #ffdd57;">"{{ $query }}"</span> <!-- 🌟 Change color here -->
        </h3>

        <!-- Decorative Nails -->
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



    {{-- Products --}}
    @if($products->count())
        <h4 class="mt-4">Products</h4>
       <div class="product-grid">
    @foreach ($products as $product)
        <div class="product_card">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product_img">

            <div class="pc_content">
                <h2>{{ $product->title }}</h2>
                <p class="pcc_in">In 
                    <a href="{{ route('category.show', $product->category->id ?? '#') }}">
                        {{ $product->category->name ?? 'N/A' }}
                    </a>
                </p>
                <p class="pcc_price">₱ {{ number_format($product->price, 2) }}</p>
                <p class="pcc_stock">Available Stock: {{ $product->stock }}</p>

                <div class="pcc_btns">
                    <button wire:click="addToCart({{ $product->id }})" class="btn addtocart">Add To Cart</button>
                    <a href="{{ route('product.show', $product->id) }}" class="btn viewbtn">View Details</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

    @endif

   {{-- Upcoming Stocks --}}
@if($upcoming->count())
<div class="container my-5">
    <!-- Section Title -->
    <div class="text-center mb-4">
    <div class="d-inline-block px-5 py-3 rounded-3 shadow-lg position-relative"
         style="background: linear-gradient(135deg, rgba(139,69,19,0.9), rgba(160,82,45,0.8));
                color: #fff;
                border: 3px solid #5a2d0c;">
        <h2 class="fw-bold mb-0">Upcoming Products</h2>

        <!-- Decorative Nails -->
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


    <!-- Cards -->
    {{-- Upcoming Stocks --}}
@if($upcoming->count())
<div class="container my-5">
    

    <div class="product-grid">
        @foreach ($upcoming as $stock)
            <div class="product_card">
                @if ($stock->image)
                    <img src="{{ asset('storage/' . $stock->image) }}" 
                         class="product_img" 
                         alt="{{ $stock->product_name }}">
                @else
                    <img src="{{ asset('theme_asset/home/img/default-product.png') }}" 
                         class="product_img" 
                         alt="No Image">
                @endif

                <div class="pc_content text-center">
                    <h2>{{ $stock->product_name }}</h2>
                    <p class="pcc_in">In <a href="#">{{ $stock->category->name ?? 'N/A' }}</a></p>
                    <p class="pcc_stock">Quantity: {{ $stock->incoming_quantity }}</p>
                    <p class="pcc_stock text-danger">
                        Expected: {{ \Carbon\Carbon::parse($stock->expected_arrival)->format('M d, Y h:i A') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

</div>
@endif


    
</div>
