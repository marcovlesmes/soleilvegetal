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
<body class="bg-gray-200">
    <div class="container mx-auto mt-5">
        <nav class="flex justify-evenly items-center">
            <img src="{{ asset('images/soleil-vegetal-logo.png') }}" alt="Soleil Vegetal">
            <ul class="flex-grow flex justify-evenly">
                <li class="group uppercase text-primary font-semibold hover:text-secondary hover:bg-gray-200 px-5 relative"><a href="">Artistas</a>
                    <ul class="absolute hidden group-hover:block bg-gray-200  left-0">
                        @foreach ($autors as $autor)
                        <li class="text-primary font-normal capitalize hover:text-secondary text-sm max-w-max p-0 py-3 text-center mx-auto"><a href="{{ route('autors.show', $autor->id) }}">{{$autor->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="group uppercase text-primary font-semibold hover:text-secondary">
                    <a href="{{ route('artworks.index') }}">Obras</a>
                </li>
                <li class="group uppercase text-primary font-semibold hover:text-secondary">
                    <a href="#">Contacto</a>
                </li>
                <li class="group text-gray-300 font-light">
                    <a href="#">Español</a> - <a href="#">English</a>
                </li>
            </ul>
        </nav>
        <nav class="flex justify-end space-x-4">
        <a class="text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900 h-8 w-8 shadow-icon" href="#">
            <svg class="h-6 w-6 mx-auto"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
            </a>
        
            
            <div class="text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900 h-8 w-8 shadow-icon" href="#">
                <a href="#">
                    <svg class="h-6 w-6 text-primary"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M22 4.01c-1 .49-1.98.689-3 .99-1.121-1.265-2.783-1.335-4.38-.737S11.977 6.323 12 8v1c-3.245.083-6.135-1.395-8-4 0 0-4.182 7.433 4 11-1.872 1.247-3.739 2.088-6 2 3.308 1.803 6.913 2.423 10.034 1.517 3.58-1.04 6.522-3.723 7.651-7.742a13.84 13.84 0 0 0 .497 -3.753C20.18 7.773 21.692 5.25 22 4.009z" /></svg>
                </a>
            </div>
            <div class="text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900 h-8 w-8 shadow-icon" href="#"">
                <a href="#">
                    <svg class="h-6 w-6 text-primary"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z" />  <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" /></svg>
                </a>
            </div>

            
            <div class="text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900 h-8 w-8 shadow-icon" href="#">
                <a href="#" >
                <svg class="h-6 w-6 text-primary "  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />  <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />  <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" /></svg>
                </a>
            </div>
            
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