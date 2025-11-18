<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('theme_asset/home/css/home.css') }}" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet" />

    <style>
      /* Background Image Styling */
      body {
        position: relative;
        z-index: 0;
      }
      html, body {
        height: 100%;
        margin: 0;
}


      body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset("images/485301921_640991548730384_6080995640366602240_n.jpg") }}') no-repeat center center;
        background-size: cover;
        filter: blur(8px);
        z-index: -1;
      }

      .nav-link-custom {
        color: black;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s;
      }

      .nav-link-custom:hover,
      .nav-link-custom.active {
        color: #ff7f28; /* Orange on hover/active */
      }
    </style>

    <title>{{ $title ?? "SingleVendorVapeShop" }}</title>
    @livewireStyles
  </head>