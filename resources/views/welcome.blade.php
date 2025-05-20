<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head style="background-color:#4188b8;">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'MapCom') }}</title>

        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">   
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
        @endif
    </head>
    <body style="background-color:#e3e4fc;" class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center min-h-screen flex-col">
        <header " style="background-color: #273ec8; padding: 10px; width: 100%; height: auto;">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a 
                            href="{{ url('/Home') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-[#273ec8] dark:bg-[#1e2d91] hover:bg-[#1e2d91] dark:hover:bg-[#14247e]"
                            style="background-color: #15247F; color: #ADD2F5;"
                            >
                            Inici
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                            style="color: #B5B9F7; font-weight: bold; font-size: 1.2em;""
                        >
                            Inicia sessió
                        </a>

                        @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                            style="background-color: #B5B9F7; font-weight: bold; font-size: 1.2em;""
                        >
                        Registra't
                    </a>
                    
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        <img src="{{ asset('img/Logo.png') }}" alt="Logo" width="350" height="350" class="w-24 lg:w-32 mb-6" />
        <div  class="flex flex-col items-center justify-center w-full lg:max-w-4xl max-w-[335px]">
            <h1 style="color: #050c3b"class="text-3xl lg:text-5xl font-bold text-center mb-6 dark:text-[#EDEDEC] text-[#1b1b18]">
                Us donem la benvinguda a MapCom
            </h1>
            <p style="color: #050c3b" class="text-sm lg:text-base text-center mb-6 dark:text-[#EDEDEC] text-[#1b1b18]">
                MapCom és una plataforma per localitzar establiments en línia. L'entorn de desenvolupament amb
                Laravel Sail ja està configurat. Puja la teva botiga a la nostra pàgina i comença a créixer.
            </p>
            <div style="color: #050c3b" class="bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#19140035] dark:border-[#3E3E3A] rounded-sm p-4 mb-6">
                <code class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                    Gràcies per confiar en nosaltres
                </code>
            </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>