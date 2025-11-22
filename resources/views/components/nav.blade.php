


<nav class="mobile-bottom-nav d-lg-none">
    <a href="{{ route('products.browse') }}" class="{{ request()->routeIs('products.browse') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>

    <!-- Categories Dropdown -->
    <div class="dropdown dropup">
        <a href="#" class="dropdown-toggle {{ request()->is('category/*') ? 'active' : '' }}" data-bs-toggle="dropdown">
            <i class="fa-solid fa-list-ul"></i>
            <span>Categories</span>
        </a>
        <ul class="dropdown-menu text-center">
            @php $categories = App\Models\Category::all(); @endphp
            @foreach ($categories as $category)
                <li>
                    <a class="dropdown-item {{ request()->is('category/'.$category->id) ? 'active' : '' }}" 
                       href="{{ route('category.show', $category->id) }}">
                       {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    @auth
    <a href="{{ route('cart') }}" class="nav-link-custom position-relative {{ request()->routeIs('cart') ? 'active' : '' }}">
        <i class="fa-solid fa-cart-shopping me-2"></i> Cart
        <!-- Cart Count Livewire -->
 <livewire:cart-count-component />
    </a>
@endauth


    <!-- Profile Dropdown -->
    @guest
        <a href="{{ route('login') }}">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span>Login</span>
        </a>
    @else
    <div class="dropdown dropup">
    <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                 alt="Profile Picture"
                 class="rounded-circle"
                 style="width:40px; height:30px; object-fit:cover;" />

            <!-- Red notification circle -->
            <livewire:user-notifications wire:poll.5s />
        <span>Profile</span>
    </a>
    <ul class="dropdown-menu text-start">
        <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                <i class="fa-solid fa-user-pen me-1"></i>
                <span>Update Profile</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.chat') }}">
                <i class="fa-solid fa-envelope me-1"></i>
                <span>Message to Admin</span>
                <livewire:user-notifications wire:poll.5s />
                
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.orders') }}">
                <i class="fa-solid fa-box me-1"></i>
                <span>Order List</span>
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form id="logoutFormMobile" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center">
                    <i class="fa-solid fa-right-from-bracket me-1"></i>
                    <span>Logout</span>
                </button>
            </form>
        </li>
    </ul>
</div>

    @endguest
</nav>