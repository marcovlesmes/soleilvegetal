<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Soleil Vegetal') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200">
    @include('widget.sidebar')
    @if (Auth::check())
        @include('widget.shoppingcart')
    @endif
    <a class="block ml-20 mt-5" href="{{ url('/') }}">
        <img class="h-12 w-auto" src="{{ asset('images/soleil-vegetal-logo.png') }}" alt="Soleil Vegetal">
    </a>
    <div class="container mx-auto mt-5">
        @yield('content')
    </div>
</body>
</html>
