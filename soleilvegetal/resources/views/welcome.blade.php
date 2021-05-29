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
    <style>
        .group:hover>ul {display: block;}
    </style>
</head>
<body>
    <div class="container mx-auto mt-5">
        <nav class="flex justify-evenly items-center">
            <img src="{{ asset('images/soleil-vegetal-logo.png') }}" alt="Soleil Vegetal">
            <ul class="flex-grow flex justify-evenly">
                <li class="group uppercase text-green-900 font-semibold hover:text-yellow-600 hover:bg-gray-200 px-5 relative"><a href="">Artistas</a>
                    <ul class="absolute hidden group-hover:block bg-gray-200  left-0">
                        @foreach ($autors as $autor)
                        <li class="text-green-900 font-normal capitalize hover:text-yellow-600 text-sm max-w-max p-0 py-3 text-center mx-auto"><a href="{{ route('autors.show', $autor->id) }}">{{$autor->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="group uppercase text-green-900 font-semibold hover:text-yellow-600">
                    <a href="{{ route('artworks.index') }}">Obras</a>
                </li>
                <li class="group uppercase text-green-900 font-semibold hover:text-yellow-600">
                    <a href="#">Contacto</a>
                </li>
                <li class="group text-gray-300 font-light">
                    <a href="#">Español</a> - <a href="#">English</a>
                </li>
            </ul>
        </nav>
        <nav>
            <a href="#">
                <img src="facebook.svg" alt="facebook">
            </a>
            <a href="#">
                <img src="twitter.svg" alt="twitter">
            </a>
            <a href="#">
                <img src="youtube.svg" alt="youtube">
            </a>
            <a href="#">
                <img src="instagram.svg" alt="instagram">
            </a>
        </nav>
        <div class="container">
            <div id="carousel">
                @foreach ($items as $item)
                    <div class="item-container">
                        <img src="{{ $item->image_src }}" alt="Obras de arte">
                        <p>{{ $item->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>