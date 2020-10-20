<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="turbolinks-cache-control" content="no-cache">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/profile/profile.png') }}">
    <title>{{ config('app.name', 'DMS') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @livewireStyles
    <style>
        .progress-bar {
            background: linear-gradient(to right, var(--color) var(--scroll), transparent 0);
            background-repeat: no-repeat;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            z-index: 1;
        }
    </style>
    <!-- Scripts -->
    <script src="{{ asset('js/alpine.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
<div class="progress-bar"></div>
<div class="min-h-screen bg-gray-100">
    @livewire('navigation-dropdown')

    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

@stack('modals')

<script>
    var element = document.documentElement,
        body = document.body,
        scrollTop = 'scrollTop',
        scrollHeight = 'scrollHeight',
        progress = document.querySelector('.progress-bar'),
        scroll;

    document.addEventListener('scroll', function () {
        scroll = (element[scrollTop] || body[scrollTop]) / ((element[scrollHeight] || body[scrollHeight]) - element.clientHeight) * 100;
        progress.style.setProperty('--color', 'red');
        progress.style.setProperty('--scroll', scroll + '%');
    });
</script>
@livewireScripts
</body>
</html>
