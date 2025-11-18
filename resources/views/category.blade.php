<x-layouts.app>

<style>
/* --- GRID LAYOUT --- */
.product-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin: 30px 0;
}

/* --- PRODUCT CARD --- */
.product_card {
    background: #ffffffcd;
    border-radius: 15px;
    box-shadow: 0 15px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: 0.3s;
    text-align: center;
    padding-bottom: 15px;
}
.product_card:hover {
    transform: translateY(-5px);
}

.product_img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.pc_content {
    padding: 20px;
}

.pc_content h2 {
    font-size: 1.9rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.pcc_in {
    font-size: 1.5rem;
    color: #666;
}

.pcc_price {
    font-size: 1.4rem;
    font-weight: bold;
    color: #000;
    margin-top: 5px;
}

.pcc_stock {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 15px;
}

/* --- BUTTONS --- */
.pcc_btns {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.btn {
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

/* --- SAME COLOR (as browse product) --- */
.viewbtn {
    background-color: #111;
    color: #fff;
}
.viewbtn:hover {
    background-color: #333;
}

/* --- RESPONSIVE --- */
/* Laptop - 4 columns */
@media (max-width: 1200px) {
    .product-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

/* iPad / Tablet - 3 columns */
@media (max-width: 992px) {
    .product-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Mobile Landscape - 2 columns */
@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Small Mobile - 1 column */
@media (max-width: 480px) {
    .product-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<div class="container">
    <h2 class="text-center mt-4">{{ $category->name }} Products</h2>

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
