<header id="header">
      
      <div class="container">
        <div class="d-flex align-items-center justify-content-between">

          <!-- Logo + Menu -->
          <div class="d-flex align-items-center gap-3">

            <!-- Logo -->
            <a href="{{ route('products.browse') }}" class="cloudscape-logo me-4">
              <h1>
                <span class="line1">
                  <span>C</span><span>L</span><span>O</span><span>U</span><span>D</span>
                  <span>S</span><span>C</span><span>A</span><span>P</span><span>E</span>
                </span>
                <span class="line2">
                  <span>V</span><span>A</span><span>P</span><span>E</span>
                  <span>S</span><span>H</span><span>O</span><span>P</span>
                </span>
              </h1>
            </a>

            

            <!-- Navigation -->
            <nav class="d-flex align-items-center gap-4">

              <!-- Home -->
              <a href="{{ route('products.browse') }}" class="nav-link-custom {{ request()->routeIs('products.browse') ? 'active' : '' }}">
                <i class="fa-solid fa-house me-2"></i> Home
              </a>

              <!-- Categories Dropdown -->
              <div class="dropdown">
                <a href="#!" class="dropdown-toggle nav-link-custom {{ request()->is('category/*') ? 'active' : '' }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-list-ul me-2"></i> Categories
                </a>
                @php $categories = App\Models\Category::all(); @endphp
                <ul class="dropdown-menu">
                  @foreach ($categories as $category)
                    <li>
                      <a class="dropdown-item {{ request()->is('category/'.$category->id) ? 'active' : '' }}" href="{{ route('category.show', $category->id) }}">
                        {{ $category->name }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>

              <!-- Cart/Login -->
              @auth
    <a href="{{ route('cart') }}" class="nav-link-custom position-relative {{ request()->routeIs('cart') ? 'active' : '' }}">
        <i class="fa-solid fa-cart-shopping me-2"></i> Cart

        <!-- Cart Count Livewire -->
        <livewire:cart-count-component />
    </a>
@endauth



              <!-- Up-Coming Product -->
              <div class="ms-auto d-none d-md-block me-5">
                <a href="{{ route('upcoming.stock') }}" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm pulse">
                  <i class="fa-solid fa-fire me-2"></i> Up-Coming Product
                  <span class="badge bg-warning text-dark ms-2">Hot!</span>
                </a>
              </div>

            </nav>
          </div>

          <!-- Search Form -->
          <form action="{{ route('search.results') }}" method="GET" class="d-flex align-items-center">
            <input type="text" name="query" placeholder="Search..." class="form-control" style="height: 40px; width: 200px; border-radius: 40px; padding-left: 10px;" />
            <button type="submit" class="btn btn-primary ms-1" style="height: 40px; width: 46px; border-radius: 50px;">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </form>



          <!-- Desktop User Menu -->
<div class="d-flex align-items-center d-none d-md-flex">
    @guest
          <a href="{{ route('login') }}" class="nav-link-custom me-3 {{ request()->routeIs('login') ? 'active' : '' }}">
              <i class="fa-solid fa-right-to-bracket me-3"></i> Login
          </a>
          <a href="{{ route('login') }}">
              <div class="theme-wrap me-3">
                  <div class="theme-icon-wrap">
                      <i class="fa-solid fa-cart-shopping"></i>
                  </div>
              </div>
          </a>
      @else
          <!-- Profile dropdown kapag naka-login -->
<div class="dropdown position-relative">
    <a href="#" 
       class="d-flex align-items-center text-decoration-none"
       id="userDropdown"
       onclick="event.preventDefault(); toggleDropdown(this)">

        <!-- Profile Picture -->
        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
             alt="Profile Picture"
             class="rounded-circle me-2"
             style="width:40px; height:40px; object-fit:cover;" />

        <!-- User Name -->
        <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span> 
        &nbsp;
        &nbsp;
        <i class="fa-solid fa-caret-down text-dark" id="dropdownIcon"></i>
    </a>

    <ul class="dropdown-menu shadow position-absolute end-0 mt-2" id="userDropdownMenu">
        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen me-2"></i> Update Profile</a></li>
        <li><a class="dropdown-item" href="{{ route('user.chat') }}"><i class="fa-solid fa-envelope me-2"></i> Message to Admin</a></li>
        <li><a class="dropdown-item" href="{{ route('user.orders') }}"><i class="fa-solid fa-box me-2"></i> Order List</a></li>
        <li><hr class="dropdown-divider" /></li>
        <li>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="button" id="logoutBtn" class="dropdown-item">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</div>

      @endguest
        </div>
      </div>
      </div>
</header>