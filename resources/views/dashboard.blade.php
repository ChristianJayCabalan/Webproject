<x-layouts.app>
<body class="about-page">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <!-- Hero Section (Keep as is - User satisfied) -->
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

    <!-- Our Happy Vapers - Enhanced with Swiper -->
    <section class="vape-people container-fluid my-5" data-aos="fade-right" style="max-width: 1200px; margin:auto;">
        <h2 class="section-title mb-5">Our Happy Vapers</h2>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @forelse($reviews as $review)
                    <div class="swiper-slide person">
                        @if($review->image)
                            <img src="{{ asset('storage/'.$review->image) }}" 
                                 alt="Review Image" 
                                 class="mb-3">
                        @endif
                        <p style="font-size:0.95rem; margin: 10px 0;">"{{ $review->comment }}"</p>
                        <p class="fw-bold mt-2" style="font-size:0.9rem; color: #a1ffce;">– {{ $review->user->name }}</p>
                    </div>
                @empty
                    <p class="text-center text-muted">No reviews yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Products - Enhanced with Animations -->
    <section class="featured-products container-fluid my-5" data-aos="fade-up">
        <div class="container" style="max-width: 1200px;">
            <h2 class="section-title mb-5">Featured Products</h2>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card product_card h-100">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : '/images/default-product.jpg' }}" 
                                 class="card-img-top" alt="{{ $product->title }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->title }}</h5>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">{{ Str::limit($product->description, 60) }}</p>
                                <p class="fw-bold mb-3" style="color: #ff9900; font-size: 1.2rem;">₱{{ number_format($product->price, 2) }}</p>
                                <div class="pcc_btns mt-auto">
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
        </div>
    </section>

    <!-- About / Brand Story - Enhanced Design -->
    <section class="about-brand container-fluid my-5" data-aos="fade-left" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 text-center" data-aos="zoom-in">
                <img src="/images/485301921_640991548730384_6080995640366602240_n.jpg" 
                     alt="Cloudscape Vapeshop" 
                     class="img-fluid" 
                     style="max-height:400px; object-fit:cover;">
            </div>
            <div class="col-lg-6" data-aos="fade-up">
                <h2 class="section-title" style="color:#ff9900; text-align: left; margin-bottom: 20px;">Our Story</h2>
                <p class="brand-text mb-4">
                    Cloudscape Vapeshop started with the vision of redefining your vaping journey.  
                    We offer premium quality products, unbeatable service, and a seamless shopping experience.  
                    Every puff is crafted for quality, style, and satisfaction.
                </p>
                <a href="{{ route('products.browse') }}" 
                   class="btn btn-lg rounded-pill" 
                   style="background: linear-gradient(135deg, #ff9900, #ff6b6b); color: white; border: none; padding: 15px 40px; font-weight: 700; text-decoration: none; transition: all 0.3s ease;"
                   onmouseover="this.style.transform='scale(1.08)'; this.style.boxShadow='0 15px 40px rgba(255, 153, 0, 0.5)';"
                   onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                   Explore Products
                </a>
            </div>
        </div>
    </section>

    <!-- Customer Reviews - Enhanced with Glassmorphism -->
    <section class="reviews container-fluid my-5" data-aos="fade-up" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
        <h2 class="section-title mb-5">Customer Reviews</h2>
        <div class="row g-4 justify-content-center">
            @forelse($reviews as $review)
                <div class="col-12 col-md-6 col-lg-4" data-aos="flip-left">
                    <div class="review-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $review->user->profile_photo 
                                        ? asset('storage/'.$review->user->profile_photo) 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}" 
                                 alt="{{ $review->user->name }}" 
                                 class="rounded-circle me-2" 
                                 style="width:45px; height:45px; object-fit:cover;">
                            <div>
                                <strong class="d-block" style="color: #ff9900;">{{ $review->user->name }}</strong>
                                @if($review->rating)
                                    <div class="text-warning small">⭐ {{ $review->rating }}/5</div>
                                @endif
                            </div>
                        </div>
                        <p class="text-muted small mb-3" style="line-height: 1.6;">{{ Str::limit($review->comment, 100) }}</p>
                        <div class="text-center mb-3">
                            <img src="{{ $review->product->image 
                                        ? asset('storage/'.$review->product->image) 
                                        : '/images/default-product.jpg' }}" 
                                 alt="{{ $review->product->title }}" 
                                 class="rounded"
                                 style="width:100px; height:100px; object-fit:cover;">
                            <small class="d-block mt-2" style="color: #a1ffce;">{{ $review->product->title }}</small>
                        </div>
                        <small class="text-muted d-block text-center">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No reviews yet.</p>
            @endforelse
        </div>
    </section>

    <!-- Map Section - Enhanced -->
    <section class="map-section container-fluid my-5" data-aos="fade-up" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
        <h2 class="section-title mb-4">Find Us Here</h2>
        <div class="map-wrapper">
            <iframe 
                src="https://www.google.com/maps?q=10.1468759,124.3228501&hl=es;z=17&output=embed" 
                width="100%" 
                height="400" 
                style="border:0; border-radius:15px;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <!-- CTA Section - Enhanced -->
    <section class="cta container-fluid my-5" data-aos="fade-up" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
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
            const heroH1 = document.querySelector('.hero-content h1');
            if (heroH1) heroH1.classList.add('animate');
        };
    </script>

</body>
</x-layouts.app>
