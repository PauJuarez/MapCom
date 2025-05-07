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
            background-color: #5564eb;
        }

        .mi-fondo-carta { /* Nueva clase para el fondo de la tarjeta */
            background-color: #e9f2fc; /* Un gris claro de ejemplo, ¡cámbialo! */
        }
        /* Puedes añadir más clases para otros elementos y colores */
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased mi-fondo-principal">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card mi-fondo-carta">  <div class="card-body">
                        <x-auth-session-status class="mb-4 alert alert-success" :status="session('status')" />
                        <img src="{{ asset('img/Logo.png') }}" alt="Logo" width="250" height="250" class="w-24 lg:w-32 mb-6 mx-auto block" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" class="form-label mi-color-principal" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2 alert alert-danger" />
                            </div>

                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Password')" class="form-label mi-color-principal" />
                                <x-text-input id="password" class="form-control"
                                                type="password"
                                                name="password"
                                                required autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2 alert alert-danger" />
                            </div>

                            <div class="mb-3 form-check mi-color-principal">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link mi-color-principal" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif

                                <x-primary-button class="btn btn-primary ms-3 mi-boton-principal">
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>