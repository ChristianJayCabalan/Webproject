<div id="menu" class="menu-wrap hide">
    <div id="hideshow" class="menu-toggle-btn">
                  <span class="w-75"></span><span class="w-50"></span><span></span>
                </div>
        <!-- Logo -->
        <div class="logo text-center py-3">
          <h1>
            <span class="line1"><span>C</span><span>L</span><span>O</span><span>U</span><span>D</span><span>S</span><span>C</span><span>A</span><span>P</span><span>E</span></span>
            <span class="line2"><span>V</span><span>A</span><span>P</span><span>E</span><span>S</span><span>H</span><span>O</span><span>P</span></span>
          </h1>
        </div>

        <!-- Admin Profile -->
        <div class="admin-profile text-center py-4 border-bottom position-relative">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                 alt="Admin Profile" class="rounded-circle mb-2" width="80" height="80" style="object-fit: cover;">
            <div class="dropdown position-absolute" style="top: 10px; right: 10px;">
                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                            <i class="fas fa-user-edit me-2"></i> Update Profile
                        </a>
                    </li>
                </ul>
            </div>
            <h6 class="mb-0 mt-2" style="color: black;">{{ Auth::user()->name }}</h6>
            <small class="text-muted">Administrator</small>
        </div>

        <ul class="insideScroll text-white mt-2">
          <li class="hover"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-house-damage"></i> Overview</a></li>
          <li class="hover"><a href="{{ route('admin.categories') }}"><i class="fa-solid fa-list-ul"></i> Categories</a></li>
          <li class="hover"><a href="{{ route('admin.chat') }}"><i class="fa-solid fa-message"></i> Message</a></li>
          <li class="hover"><a href="{{ route('admin.add-product') }}"><i class="fa-solid fa-plus"></i> Product</a></li>
          <li class="hover"><a href="{{ route('upcoming.stocks') }}"><i class="fa-solid fa-plus"></i> Add Up-comming Product</a></li>
          <li class="hover"><a href="{{ route('admin.orders') }}"><i class="fa-solid fa-cart-shopping"></i> Order History</a></li>
          <li class="hover">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-one"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
              </form>
          </li>
        </ul>
      </div>