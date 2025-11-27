<x-layouts.app>
<link rel="stylesheet" href="{{ asset('css/category-list.css') }}">

<div class="container">
        <div class="container mt-5">
    <div class="text-center my-4">
        <div class="d-inline-block px-5 py-3 rounded-3 shadow-lg position-relative category-header">
            <h2 class="fw-bold mb-0">{{ $category->name }} Products</h2>

            <!-- Decorative Nails -->
            <span class="nail left"></span>
            <span class="nail right"></span>
        </div>
    </div>
</div>


    <div class="product-grid">
        @foreach ($category->products as $product)
            <div class="product_card">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product_img">

                <div class="pc_content">
                    <h2>{{ $product->title }}</h2>
                    <p class="pcc_in">
                        In 
                        <a href="{{ route('category.show', $product->category->id) }}">
                            {{ $product->category->name }}
                        </a>
                    </p>
                    <p class="pcc_price">₱ {{ $product->price }}</p>
                    <p class="pcc_stock">Available Stock: {{ $product->stock }}</p>

                    <div class="pcc_btns">
                        <a href="{{ route('product.show', $product->id) }}" class="btn viewbtn">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</x-layouts.app>
