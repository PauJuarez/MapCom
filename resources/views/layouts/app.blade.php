<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MapCom') }}</title>

        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">   
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <!-- Estrellas -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .bg-primary-variant-1 { background-color: #E3E4FC !important; }
            .bg-primary-variant-2 { background-color: #B5B9F7 !important; }
            .bg-primary-variant-3 { background-color: #878FF2 !important; }
            .bg-primary-variant-4 { background-color: #5564EB !important; }
            .bg-primary-variant-5 { background-color: #273EC8 !important; }
            .bg-primary-variant-6 { background-color: #15247F !important; }
            .bg-primary-variant-7 { background-color: #050C3B !important; }
    
            .bg-secondary-variant-1 { background-color: #EEEBFC !important; }
            .bg-secondary-variant-2 { background-color: #CCB9F7 !important; }
            .bg-secondary-variant-3 { background-color: #ADB0F2 !important; }
            .bg-secondary-variant-4 { background-color: #9155EB !important; }
            .bg-secondary-variant-5 { background-color: #6F29C4 !important; }
            .bg-secondary-variant-6 { background-color: #48167E !important; }
            .bg-secondary-variant-7 { background-color: #20063F !important; }
    
            .bg-info-variant-1 { background-color: #E9F2FC !important; }
            .bg-info-variant-1-5 { background-color:rgb(220, 239, 255) !important; }
            .bg-info-variant-2 { background-color: #ADD2F5 !important; }
            .bg-info-variant-3 { background-color: #55AFEB !important; }
            .bg-info-variant-4 { background-color: #4188B8 !important; }
            .bg-info-variant-5 { background-color: #2D6387 !important; }
            .bg-info-variant-6 { background-color: #1B4C59 !important; }
            .bg-info-variant-7 { background-color: #0A202F !important; }
    
            .bg-gray-variant-1 { background-color: #E5E3E7 !important; }
            .bg-gray-variant-2 { background-color: #BDBDC1 !important; }
            .bg-gray-variant-3 { background-color: #97979D !important; }
            .bg-gray-variant-4 { background-color: #72727A !important; }
            .bg-gray-variant-5 { background-color: #4F4F58 !important; }
            .bg-gray-variant-6 { background-color: #2F2F35 !important; }
            .bg-gray-variant-7 { background-color: #121215 !important; }
    
            .text-primary-variant-4 { color: #5564EB !important; }
            .text-secondary-variant-4 { color: #9155EB !important; }
            .text-info-variant-3 { color: #55AFEB !important; }
            .text-info-variant-4 { color: #E9F2FC !important; }
        </style>
    </head>
    
    <body class="font-sans antialiased bg-gray-variant-1">
        <div class="min-h-screen flex flex-row bg-gray-100">
            <!-- Sidebar or Navigation -->
            <aside class="w-18 md:w-64 lg:w-80 xl:w-96 bg-white shadow bg-primary-variant-2">
                @include('layouts.navigation')
            </aside>

            
            <!-- Main content area -->
            <div class="flex-1 flex flex-col">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow bg-primary-variant-5">
                        <div class="px-6 py-4">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
        
                <!-- Page Content -->
                <main class="flex-1 p-6 bg-info-variant-1">
                    {{ $slot }}
                </main>

            </div>
        </div>
        
    </body>
</html>
