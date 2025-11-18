<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- External Files Linking -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      crossorigin="anonymous"
    />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- Internal Files Linking -->
    <link rel="stylesheet" href="{{ asset('theme_asset/dash/css/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/add-upcoming-stock.css') }}">

    <title>{{ $title ?? "CloudScapeVapeShop" }}</title>
    @livewireStyles

    <!-- Logo Fire Animation & Responsive CSS -->
    <style>
      /* Logo Container */
      .logo h1 { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 2rem; font-weight: bold; margin: 0; text-align: center; line-height: 1.2; }
      .logo h1 .line1, .logo h1 .line2 { display: block; }
      .logo h1 span { display: inline-block; animation: fire 1.5s infinite alternate; }
      .logo h1 .line1 span:nth-child(1){animation-delay:0s;} /*... repeat for each span ...*/ 
      @keyframes fire {0%{color:#ffb347;transform:translateY(0) scale(1);}50%{color:#ff7733;transform:translateY(-3px) scale(1.1);}100%{color:#ff3300;transform:translateY(0) scale(1);}}
      @media (max-width:576px){.logo h1{font-size:1.5rem;}}
    </style>
  </head>

  <body>
    <div class="wrapper-parent">
      <!-- Sidebar menu -->
      <div id="menu" class="menu-wrap hide">
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

      <div class="responsive-overlay"></div>

      <!-- Main Content Div -->
<div class="content-wrap">
  <div class="top-bar sticky-top">
    <div class="container-fluid">
      <div class="row px-3">
        <div class="col-12">
          <div class="row">
            <!-- Menu Toggle Button inside white box with stroke -->
            <div class="col-2">
              <div class="menu-toggle-box p-2 rounded" style="background-color: #ffffff; display: inline-block; border: 2px solid #ff7f28;">
                <div id="hideshow" class="menu-toggle-btn">
                  <span class="w-75"></span><span class="w-50"></span><span></span>
                </div>
                <div id="hideshow" class="menu-toggle-btn lg">
                  <span class="w-75"></span><span class="w-50"></span><span></span>
                </div>
              </div>
            </div>

            <!-- Empty space for alignment -->
            <div class="col-10 d-flex justify-content-end align-items-center">
              <div class="col-10 d-flex justify-content-end align-items-center">
                    <div class="dropdown-center no-icon-dropdown">
                      <a href="#"><i class='bx bxl-telegram'></i></a>
                    </div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


        <!-- Dashboard main content section -->
        <div class="main-content">
          <div class="container-fluid">
            {{ $slot }}
          </div>
        </div>
      </div>
    </div>

    <!-- External JS Linking -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Internal JS Linking -->
    <script src="{{ asset('theme_asset/dash/js/dash.js') }}"></script>
    <script>
    window.addEventListener('close-modal', () => {
        let modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
        modal.hide();
    });
</script>


    @livewireScripts
    @stack('scripts')
  </body>
</html>
