<div>
     <!-- footer -->
    <footer id="footer" class="bg-dark text-white py-5">
  <div class="container">
    <div class="row align-items-start">
      <!-- Logo & Description -->
<div class="col-lg-4 mb-4 text-center text-lg-start">
    <a href="{{ url('/') }}" class="cloudscape-logo d-inline-block mb-3">
        <h1>
            <span class="line1">
                <span>C</span><span>L</span><span>O</span><span>U</span><span>D</span><span>S</span><span>C</span><span>A</span><span>P</span><span>E</span>
            </span>
            <span class="line2">
                <span>V</span><span>A</span><span>P</span><span>E</span><span>S</span><span>H</span><span>O</span><span>P</span>
            </span>
        </h1>
    </a>
        <p class="text-muted">
          Cloudscape Online Vapelounge — The Vape Shop You Deserve! Discover premium products and unbeatable service.
        </p>
      </div>

      <!-- Navigation Links -->
      <div class="col-lg-4 mb-4">
        <h5 class="text-uppercase mb-3">Legal & Info</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('dashboard') }}" class="text-white-50 d-block mb-2">About Shop</a></li>
          <li><a href="{{ route('user.chat') }}" class="text-white-50 d-block mb-2">Message To Admin</a></li>
          <li><a href="{{ route('privacy.policy') }}" class="text-white-50 d-block mb-2">Privacy Policy</a></li>
          <li><a href="{{ route('cookie.policy') }}" class="text-white-50 d-block mb-2">Cookie Policy</a></li>
        </ul>
      </div>

      <!-- Contact & Social -->
      <div class="col-lg-4 mb-4">
        <h5 class="text-uppercase mb-3">Contact Us</h5>
        <p class="text-white-50 mb-2"><i class="fas fa-map-marker-alt me-2"></i>Zamora St. Poblacion, Talibon, Bohol</p>
        <p class="text-white-50 mb-2"><i class="fas fa-envelope me-2"></i>support@cloudscapevape.com</p>
        <p class="text-white-50"><i class="fas fa-phone me-2"></i>+63 900 123 4567</p>

        <div class="mt-3">
          <a href="#!" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
          <a href="#!" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
          <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
        </div>
      </div>
    </div>

    <hr class="border-secondary mt-4">
    <div class="text-center text-muted small">
      &copy; {{ date('Y') }} Cloudscape Vapeshop. All Rights Reserved.
    </div>
  </div>
</footer>
</div>