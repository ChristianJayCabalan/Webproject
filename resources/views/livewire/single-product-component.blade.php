<div> <!-- ✅ Single root wrapper for Livewire -->

    <div class="row">
        <div class="col-12">
            <div class="product_card">
                <!-- Product Image & Details -->
                <div class="row">
                    <!-- Left: Image -->
                    <div class="col-lg-4">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="product_img w-100 rounded shadow-sm">
                    </div>

                    <!-- Right: Details + Reviews -->
                    <div class="col-lg-8">
                        <div class="row">
                            <!-- Details -->
                            <div class="col-md-7">
                                <div class="pc_content">
                                    <h2>{{ $product->title }}</h2>
                                    <p class="pcc_in">
                                        In 
                                        <a href="{{ route('category.show', $product->category->id) }}">
                                            {{ $product->category->name }}
                                        </a>
                                    </p>
                                    <p class="pcc_price">₱{{ $product->price }}</p>
                                    <p class="pcc_description">{{ $product->description }}</p>
                                    <div class="pcc_btns">
                                        <button wire:click="addToCart({{ $product->id }})" class="btn btn-primary rounded-pill">
                                            <i class="fas fa-cart-plus me-2"></i> Add To Cart
                                        </button>
                                    </div>
                                </div>

                                @if (session()->has('message'))
                                    <div class="alert alert-success d-flex align-items-center justify-content-between p-3 mt-3 rounded shadow-sm">
                                        <div>
                                            <i class="fas fa-check-circle me-2"></i>
                                            {{ session('message') }}
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>

                            <!-- Reviews Display -->
                            <div class="col-md-5">
                                <div class="review_section p-3 border rounded bg-light shadow-sm h-100">
                                    <h4 class="fw-bold mb-3" style="color: #000;">Customer Reviews</h4>
                                    <div class="review-list" style="max-height: 350px; overflow-y: auto;">
                                        @forelse ($product->reviews as $review)
                                            <div class="d-flex align-items-start mb-3">
                                                <img src="{{ $review->user->profile_photo 
                                                    ? asset('storage/' . $review->user->profile_photo) 
                                                    : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}" 
                                                    alt="{{ $review->user->name }}" 
                                                    class="rounded-circle me-2"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                <div class="p-2 rounded shadow-sm flex-grow-1" 
                                                     style="background-color: #f0f9ff; border: 1px solid #cce7ff; color: #000;">
                                                    <strong>{{ $review->user->name }}</strong>
                                                    <small class="text-muted ms-2">{{ $review->created_at->diffForHumans() }}</small>
                                                    @if($review->rating)
                                                        <p class="mb-1 text-warning">⭐ {{ $review->rating }} / 5</p>
                                                    @endif
                                                    <p class="mb-0">{{ $review->comment }}</p>
                                                    @if($review->image)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $review->image) }}" 
                                                                 alt="Review Image" 
                                                                 class="rounded shadow-sm"
                                                                 style="width: 100%; max-width: 200px; height: 200px; object-fit: cover; border: 1px solid #ddd;">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted">No reviews yet. Be the first to review!</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end inner row -->
                    </div>
                </div>

                <!-- Add Review Form -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="review_form_section p-4 border rounded shadow-sm bg-white">
                            <h3 class="fw-bold">Add a Review</h3>
                            @auth
                                <form wire:submit.prevent="addReview" enctype="multipart/form-data" class="review-form mt-3">

    <!-- Rating -->
    <div class="mb-3">
        <label class="fw-bold">Your Rating:</label>
        <div class="star-rating">
            @for ($i = 1; $i <= 5; $i++)
                <i class="fa-star {{ $rating >= $i ? 'fa-solid text-warning' : 'fa-regular text-warning' }}"
                   wire:click="$set('rating', {{ $i }})"
                   style="cursor:pointer; font-size:1.5rem;"></i>
            @endfor
        </div>
        @error('rating') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <!-- Image Upload -->
    <div class="mb-3">
        <label class="fw-bold">Upload Image (optional):</label>
        <input type="file" wire:model="image" class="form-control form-control-sm">
        @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
        @if ($image)
            <div class="mt-2">
                <p class="text-muted mb-1 small">Preview:</p>
                <img src="{{ $image->temporaryUrl() }}" 
                     alt="Review Image Preview" 
                     class="rounded shadow-sm border"
                     style="width: 100%; max-width: 120px; height: 120px; object-fit: cover;">
            </div>
        @endif
    </div>

    <!-- Comment -->
    <div class="mb-3">
        <label class="fw-bold">Your Review:</label>
        <textarea wire:model="comment" class="form-control" rows="3" placeholder="Write your review here..."></textarea>
        @error('comment') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn btn-success w-100 rounded-pill">Submit Review</button>

    <div wire:loading wire:target="addReview" class="text-muted mt-2">
        Submitting your review...
    </div>

</form>

                            @else
                                <p>You need to <a href="{{ route('login') }}">log in</a> to leave a review.</p>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('swal', event => {
        Swal.fire({
            title: event.detail.title,
            icon: event.detail.icon,
            draggable: event.detail.draggable ?? false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    });
</script>
