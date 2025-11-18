<x-layouts.app>
<body class="about-page">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">

    <!-- AOS CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <!-- Hero Section -->
<section class="hero py-5" data-aos="fade-up" style="padding-top:100px; padding-bottom:80px;">
    <div class="overlay"></div>
    <div class="hero-content text-center">
        <h1 class="mb-4">
            <span class="welcome-text">Welcome to</span><br>
            <span class="modern-title">Cloudscape Vapeshop</span>
        </h1>
        <p class="modern-subtitle mb-4">Redefining Your Vape Journey with Style</p>
        <a href="{{ route ('products.browse')}}" class="btn-modern">Shop Now</a>
    </div>
</section>

<!-- Our Happy Vapers -->
<section class="vape-people container-fluid my-5" data-aos="fade-right" style="max-width: 1200px; margin:auto;">
    <h2 class="section-title text-center mb-5">Our Happy Vapers</h2>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @forelse($reviews as $review)
                <div class="swiper-slide person text-center">
                    @if($review->image)
                        <img src="{{ asset('storage/'.$review->image) }}" 
                             alt="Review Image" 
                             class="rounded shadow-sm mb-3"
                             style="width:180px; height:180px; object-fit:cover;">
                    @endif
                    <p style="font-size:1rem;">“{{ $review->comment }}”</p>
                    <p class="fw-bold mt-1" style="font-size:0.95rem;">– {{ $review->user->name }}</p>
                </div>
            @empty
                <p class="text-center text-muted">No reviews yet.</p>
            @endforelse
        </div>
    </div>
</section>



    <!-- Featured Products -->
    <section class="featured-products container my-5" data-aos="fade-up">
        <h2 class="section-title text-dark mb-4">Featured Products</h2>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
                <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card product_card shadow-sm rounded h-100">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/default-product.jpg' }}" 
                             class="card-img-top p-2 rounded-top" alt="{{ $product->title }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-dark">{{ $product->title }}</h5>
                            <p class="text-muted mb-2">{{ Str::limit($product->description, 60) }}</p>
                            <p class="text-primary fw-bold mb-3">₱{{ number_format($product->price, 2) }}</p>
                            <div class="pcc_btns mt-auto d-flex justify-content-between">
                                <button class="addtocart" data-id="{{ $product->id }}">
                                    <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                </button>
                                <a href="{{ route('product.show', $product->id) }}" class="viewbtn">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- About / Brand Story -->
    <section class="about-brand container py-5" data-aos="fade-left">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 text-center" data-aos="zoom-in">
                <img src="/images/485301921_640991548730384_6080995640366602240_n.jpg" 
                     alt="Cloudscape Vapeshop" 
                     class="img-fluid rounded shadow" 
                     style="max-height:400px; object-fit:cover;">
            </div>
            <div class="col-lg-6" data-aos="fade-up">
                <h2 class="section-title display-5 fw-bold mb-3" style="color:#222;">Our Story</h2>
                <p class="brand-text mb-4" style="color:#555; font-size:1.1rem; line-height:1.8;">
                    Cloudscape Vapeshop started with the vision of redefining your vaping journey.  
                    We offer premium quality products, unbeatable service, and a seamless shopping experience.  
                    Every puff is crafted for quality, style, and satisfaction.
                </p>
                <a href="{{ route('products.browse') }}" 
                   class="btn btn-primary btn-lg rounded-pill shadow-sm">
                   Explore Products
                </a>
            </div>
        </div>
    </section>

    <!-- Customer Reviews -->
    <section class="reviews container my-5" data-aos="fade-up">
        <h2 class="section-title text-center mb-5">Customer Reviews</h2>
        <div class="row g-4 justify-content-center">
            @forelse($reviews as $review)
                <div class="col-12 col-md-6 col-lg-2" data-aos="flip-left">
                    <div class="review-card p-3 rounded shadow-sm h-100 bg-white d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ $review->user->profile_photo 
                                        ? asset('storage/'.$review->user->profile_photo) 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}" 
                                 alt="{{ $review->user->name }}" 
                                 class="rounded-circle me-2" 
                                 style="width:40px; height:40px; object-fit:cover;">
                            <div>
                                <strong class="text-dark fs-6">{{ $review->user->name }}</strong>
                                @if($review->rating)
                                    <div class="text-warning small mt-1">⭐ {{ $review->rating }}/5</div>
                                @endif
                            </div>
                        </div>
                        <p class="text-secondary small flex-grow-1">{{ Str::limit($review->comment, 100) }}</p>
                        <div class="mt-2 text-center">
                            <img src="{{ $review->product->image 
                                        ? asset('storage/'.$review->product->image) 
                                        : '/images/default-product.jpg' }}" 
                                 alt="{{ $review->product->title }}" 
                                 class="rounded shadow-sm"
                                 style="width:100px; height:100px; object-fit:cover;">
                            <small class="d-block mt-2 text-muted">{{ $review->product->title }}</small>
                        </div>
                        <small class="text-muted mt-2">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No reviews yet.</p>
            @endforelse
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section container my-5" data-aos="fade-up">
        <h2 class="section-title text-center mb-4">Find Us Here</h2>
        <div class="map-wrapper rounded shadow-sm overflow-hidden">
            <iframe 
                src="https://www.google.com/maps?q=10.1468759,124.3228501&hl=es;z=17&output=embed" 
                width="100%" 
                height="400" 
                style="border:0; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.1);" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta container text-center" data-aos="fade-up">
        <h2>Ready to Explore Our Collection?</h2>
        <a href="{{ route ('products.browse')}}" class="btn-modern">Shop Now</a>
    </section>

    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200,
            easing: 'ease-in-out',
            once: true
        });

        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: { delay: 2500, disableOnInteraction: false },
            breakpoints: {
                576: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
                1200: { slidesPerView: 4 },
            },
        });

        window.onload = function () {
            document.querySelector('.hero-content h1').classList.add('animate');
        };
    </script>

    <style>
    .about-brand {
        background-color: #f9f9f9;
        border-radius: 15px;
        padding: 60px 30px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .section-title {
        position: relative;
    }

    .section-title::after {
        content: '';
        width: 60px;
        height: 3px;
        background-color: #ff6b6b;
        display: block;
        margin-top: 10px;
        border-radius: 2px;
    }
    </style>

</body>
</x-layouts.app>
