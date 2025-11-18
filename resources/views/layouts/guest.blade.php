<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('{{ asset('images/484976726_1428780068278572_2063448245134224851_n.jpg') }}') no-repeat center center fixed;
    background-size: cover;
    filter: blur(8px); /* <-- dito ang blur */
    z-index: -1; /* para nasa likod ng content */
}


            /* Semi-transparent white container */
            .transparent-container {
                background: rgba(255, 255, 255, 0.7); /* Adjust transparency as needed */
                border-radius: 10px; /* Smooth rounded edges */
                padding: 20px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Light shadow for contrast */
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 transparent-container">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
