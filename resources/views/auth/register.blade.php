<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        /* Tus colores personalizados */
        .mi-fondo-principal {
            background-color: #9155eb;
        }

        .mi-fondo-carta {
            background-color: #eee8fc; /* Fondo blanco para la tarjeta de registro */
            border: 1px solid #dee2e6; /* Un borde sutil para la tarjeta */
            border-radius: 0.25rem;
        }

        .mi-texto-principal {
            color:rgb(43, 55, 67); /* Un color de texto oscuro */
        }

        .mi-enlace {
            color: #17a2b8; /* Un color secundario para el enlace */
            text-decoration: none;
        }

        .mi-enlace:hover {
            text-decoration: underline;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased mi-fondo-principal">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card p-4 mi-fondo-carta">
                    <img src="{{ asset('img/Logo.png') }}" alt="Logo" width="250" height="250" class="w-24 lg:w-32 mb-6 mx-auto block" />

                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <x-input-label for="name" :value="__('Name')" class="form-label mi-texto-principal" />
                            <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 alert alert-danger" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="email" :value="__('Email')" class="form-label mi-texto-principal" />
                            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 alert alert-danger" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="password" :value="__('Password')" class="form-label mi-texto-principal" />
                            <x-text-input id="password" class="form-control"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 alert alert-danger" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label mi-texto-principal" />
                            <x-text-input id="password_confirmation" class="form-control"
                                            type="password"
                                            name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 alert alert-danger" />
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <a class="mi-enlace" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>

                            <x-primary-button class="btn btn-primary ms-4 mi-boton-registro">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>