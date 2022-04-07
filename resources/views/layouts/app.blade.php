<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/brands/favicon.ico') }}" type="image/png">

    <title>{{ config('app.name', 'The Property Manager') }} @yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.3.4/dist/flowbite.min.css" />

    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/b3c8174312.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.2.4/dist/cdn.min.js"></script>

    {{-- Flowbite --}}
    <script src="../path/to/flowbite/dist/flowbite.js"></script>

    @yield('styles')

    @livewireStyles
</head>

<body class="font-sans antialiased" body x-data="{'isModalOpen': false}" x-on:keydown.escape="isModalOpen=false">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-12xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

    </div>
    @include('layouts.notifications')
    @livewireScripts
    <!-- Load Facebook SDK for JavaScript -->
    @include('layouts.messenger-chatbot')
</body>

<script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>

@yield('scripts')

</html>