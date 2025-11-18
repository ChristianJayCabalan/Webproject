<div class="product-grid">
    @foreach ($products as $product)
        <div class="product_card">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product_img">

            <div class="pc_content">
                <h2>{{ $product->title }}</h2>
                <p class="pcc_in">In <a href="{{ route('category.show', $product->category->id) }}">{{ $product->category->name }}</a></p>
                <p class="pcc_price">₱ {{ $product->price }}</p>
                <p class="pcc_stock">Available Stock <span>&nbsp;</span>{{ $product->stock }}</p>

                <div class="pcc_btns">
    <button wire:click="addToCart({{ $product->id }})" class="btn addtocart">Add To Cart</button>
    <a href="{{ route('product.show', $product->id) }}" class="btn viewbtn">View Details</a>
</div>

            </div>
        </div>
    @endforeach

</div>
