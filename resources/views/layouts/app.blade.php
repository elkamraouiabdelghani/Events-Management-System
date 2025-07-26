<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('application.name', 'SG.Events') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset(config('application.favicon', 'images/applications/favicon.ico')) }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="wrapper">
            @include('layouts.navigation')

            <div class="content-wrapper">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow pt-2 pb-2">
                        <div class="container-fluid py-3">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="container-fluid py-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
