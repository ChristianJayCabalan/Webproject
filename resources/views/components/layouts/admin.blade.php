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

      <x-sidebar />

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
              <div class="menu-toggle-box p-2 rounded" style="background-color: #ffffff; display: inline-block; border: 2px solid #b1b0b0ff;">
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

 @php
    $unreadMessages = auth()->check()
        ? \App\Models\Message::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count()
        : 0;
@endphp
<a href="{{ route('admin.chat') }}" style="text-decoration: none; color: inherit;">
    <div wire:poll.5s="loadUnreadMessages" 
         class="notif-icon position-relative" 
         style="cursor:pointer;">
         
        <i class="fas fa-envelope fa-lg"></i>

        @if($unreadMessages > 0)
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
        @endif
    </div>
</a>





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
