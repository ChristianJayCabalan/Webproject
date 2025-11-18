  <!DOCTYPE html>
  <html lang="en">

  <!-- Head -->  
  <x-head />
  
  <body class="d-flex flex-column min-vh-100">

    <!-- HEADER DESKTOP -->
    <x-header-dekstop />


<!-- MOBILE HEADER -->
<x-mobile-header />

<!-- Mobile Search Modal -->
<x-mobile-search />

 <!-- Content -->
    <div class="container">
      <div class="text-center my-4">
        <h1 class="fw-bold text-uppercase"></h1>
      </div>
      {{ $slot }}
    </div>

    
   <!-- Mobile Bottom Navigation -->
    <x-nav />

    <!-- Footer -->
    <x-footer />
    <div class="backdrop-filter"></div>

    <!-- Scripts -->
    <x-script />

  </body>
  </html>
