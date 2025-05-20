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
<body class="antialiased mi-fondo-principal" style="height: 100vh; margin: 0;">
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh; padding: 20px;">
        <div class="col-md-4" style="width: 100%; max-width: 480px;">
            <div class="card mi-fondo-carta shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h1 style="font-weight: 700; font-size: 2.4em; color: #48167E; text-align: center; margin-bottom: 1.5rem; line-height: 1.2;">
                        Registrar-se
                    </h1>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nom')" class="form-label mi-texto-principal fw-semibold" />
                            <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" style="border-radius: 0.375rem;" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 alert alert-danger" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Correu electrònic')" class="form-label mi-texto-principal fw-semibold" />
                            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" style="border-radius: 0.375rem;" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 alert alert-danger" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Contrasenya')" class="form-label mi-texto-principal fw-semibold" />
                            <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" style="border-radius: 0.375rem;" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 alert alert-danger" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password_confirmation" :value="__('Confirma la contrasenya')" class="form-label mi-texto-principal fw-semibold" />
                            <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" style="border-radius: 0.375rem;" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 alert alert-danger" />
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <a class="mi-enlace" href="{{ route('login') }}" style="font-weight: 600; color: #48167E; text-decoration: none; transition: color 0.3s;">
                                {{ __('Ja estàs registrat?') }}
                            </a>

                            <div class="d-flex gap-3">
                                <button type="button" onclick="window.history.back()" class="btn mi-boton-registro" style="background-color: #CCB9F7; color: purple; border: 1px solid purple; border-radius: 0.375rem; padding: 0.5rem 1.25rem; font-weight: 600; transition: background-color 0.3s, color 0.3s;">
                                    Back
                                </button>

                                <x-primary-button class="btn mi-boton-registro" style="padding: 0.5rem 1.25rem; border-radius: 0.375rem; font-weight: 600;">
                                    {{ __('Registrar-se') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>