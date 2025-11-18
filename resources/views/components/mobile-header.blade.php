<header class="mobile-header d-md-none d-flex justify-content-between align-items-center px-3 py-2 bg-white shadow-sm position-relative">
  
  <!-- Logo Left (Stacked) -->
  <a href="{{ route('products.browse') }}" class="mobile-logo d-flex flex-column align-items-start text-decoration-none">
    <h1 class="line1 m-0" style="font-size: 1.5rem;">CLOUDSCAPE</h1>
    <h2 class="line2 m-0" style="font-size: 1rem;">ONLINE VAPESHOP</h2>
  </a>

  <div class="d-flex align-items-center gap-2">

    <!-- Up-Coming Product Button -->
    <a href="{{ route('upcoming.stock') }}" class="btn btn-danger btn-sm d-flex align-items-center pulse">
      <i class="fa-solid fa-fire me-1"></i> Up-Coming Product
      <span class="badge bg-warning text-dark ms-1">Hot!</span>
    </a>

    <!-- Mobile Search Icon -->
    <button type="button" class="mobile-search-btn btn btn-light border" data-bs-toggle="modal" data-bs-target="#mobileSearchModal">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>

  </div>

</header>