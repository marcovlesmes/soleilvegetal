@extends('layouts.app')
@section('content')
    <div class="mb-14">
        <a class="block mb-6 text-yellow-500 hover:text-yellow-400" href="{{ route('artworks.index') }}">
            <svg class="h-3 w-3 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            {{ __('common.go_back') }}
        </a>
        <h2 class="text-3xl text-primary">{{ __('common.title') }}: {{ $item->name }}</h2>
        <p class="font-medium">{{ $item->year }}</p>
        <p class="font-medium">{{ __('common.artist') }}: {{ $item->autor->first()->name }}</p>
    </div>
    <div x-data="imageSwitcher()" x-init="init()" class="grid grid-cols-dictionary gap-y-8 gap-x-16 py-5 w-3/4 mx-auto">
        <div>
            <div x-ref="mainContainer" class="preview-image mb-6">
                @if ($item->image->isEmpty())
                    <img class="max-h-full min-w-full object-cover align-botton" src="{{ asset('images/no-image.png') }}"
                        alt="No image avalible">
                @else
                    <div x-ref="zoomZone" class="bg-black bg-opacity-40 absolute hidden pointer-events-none"></div>
                    <img x-ref="image" x-on:mouseenter="initZoomImage(event)" x-on:mousemove="zoomTo(event)" x-on:mouseleave="killZoomImage()" class="max-h-full min-w-full object-cover align-botton"
                        src="{{ asset($item->image->sortBy('priority')->first()->image_source) }}"
                        alt="{{ $item->name }}">
                @endif
            </div>
            <ul class="flex flex-wrap">
                @foreach ($item->image->sortBy('priority') as $image)
                    <li class="flex-grow-1 h-16">
                        <img @click="swapImage({{ $image->id }})" id="thumb-{{ $image->id }}"
                            class="max-h-full min-w-full object-cover align-botton cursor-pointer"
                            src="{{ asset($image->image_source) }}" alt="{{ $item->name }}">
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <div x-ref="viewer" class="absolute shadow hidden"></div>
            <h3 class="text-lg font-semibold text-gray-800 my-6 pb-2 ">{{ __('common.about_the_artwork') }}: </h3>
            <div class="grid grid-cols-dictionary gap-y-2">
                <span class="font-medium mb-12">{{ __('common.title') }}:</span> <span
                    class="text-primary mb-12">{{ $item->name }}</span>
                <span class="font-medium mb-6">{{ __('common.year') }}:</span> <span
                    class="text-primary mb-4">{{ $item->year }}</span>
                <span class="font-medium">{{ __('common.artist') }}:</span> <span
                    class="text-primary">{{ $item->autor->first()->name }}</span>
                <span class="font-medium">{{ __('common.technique') }}:</span> <span
                    class="text-primary">{{ $item->technique->first()->name }}</span>
                <span class="font-medium">{{ __('common.format') }}:</span> <span
                    class="text-primary">{{ $item->format }}</span>
                <span class="font-medium">{{ __('common.edition') }}:</span> <span
                    class="text-primary">{{ $item->edition }}</span>
                <span class="font-medium">{{ __('common.colophon') }}:</span>
                <p class="text-primary">{{ $item->description }}</p>
                <span class="font-medium">{{ __('commerce.price') }}:</span> <span
                    class="text-primary">???{{ $item->price }}</span>
            </div>
        </div>
        <div class="flex mt-6 gap-x-2">
            <p class="px-4 text-primary font-medium">{{ __('common.share') }}</p>
            <a class="p-1 text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900"
                href="#">
                <svg class="h-4 w-4 mx-auto" viewBox="0 0 24 24" stroke-width="2" stroke="none" fill="currentColor"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M0 0h24v24H0z" />
                    <path fill="white" d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                </svg>
            </a>
            <a class="p-1 text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900"
                href="#">
                <svg class="h-4 w-4 mx-auto" viewBox="0 0 438.529 438.529" stroke-width="2" stroke="none" fill="currentColor"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M409.141,109.203c-19.608-33.592-46.205-60.189-79.798-79.796C295.751,9.801,259.065,0,219.281,0
              C179.5,0,142.812,9.801,109.22,29.407c-33.597,19.604-60.194,46.201-79.8,79.796C9.809,142.8,0.008,179.485,0.008,219.267
              c0,44.35,12.085,84.611,36.258,120.767c24.172,36.172,55.863,62.912,95.073,80.232c-0.762-20.365,0.476-37.209,3.709-50.532
              l28.267-119.348c-4.76-9.329-7.139-20.93-7.139-34.831c0-16.175,4.089-29.689,12.275-40.541
              c8.186-10.85,18.177-16.274,29.979-16.274c9.514,0,16.841,3.14,21.982,9.42c5.142,6.283,7.705,14.181,7.705,23.7
              c0,5.896-1.099,13.084-3.289,21.554c-2.188,8.471-5.041,18.273-8.562,29.409c-3.521,11.132-6.045,20.036-7.566,26.692
              c-2.663,11.608-0.476,21.553,6.567,29.838c7.042,8.278,16.372,12.423,27.983,12.423c20.365,0,37.065-11.324,50.107-33.972
              c13.038-22.655,19.554-50.159,19.554-82.514c0-24.938-8.042-45.21-24.129-60.813c-16.085-15.609-38.496-23.417-67.239-23.417
              c-32.161,0-58.192,10.327-78.082,30.978c-19.891,20.654-29.836,45.352-29.836,74.091c0,17.132,4.854,31.505,14.56,43.112
              c3.235,3.806,4.283,7.898,3.14,12.279c-0.381,1.143-1.141,3.997-2.284,8.562c-1.138,4.565-1.903,7.522-2.281,8.851
              c-1.521,6.091-5.14,7.994-10.85,5.708c-14.654-6.085-25.791-16.652-33.402-31.689c-7.614-15.037-11.422-32.456-11.422-52.246
              c0-12.753,2.047-25.505,6.14-38.256c4.089-12.756,10.468-25.078,19.126-36.975c8.663-11.9,19.036-22.417,31.123-31.549
              c12.082-9.135,26.787-16.462,44.108-21.982s35.972-8.28,55.959-8.28c27.032,0,51.295,5.995,72.8,17.986
              c21.512,11.992,37.925,27.502,49.252,46.537c11.327,19.036,16.987,39.403,16.987,61.101c0,28.549-4.948,54.243-14.842,77.086
              c-9.896,22.839-23.887,40.778-41.973,53.813c-18.083,13.042-38.637,19.561-61.675,19.561c-11.607,0-22.456-2.714-32.548-8.135
              c-10.085-5.427-17.034-11.847-20.839-19.273c-8.566,33.685-13.706,53.77-15.42,60.24c-3.616,13.508-11.038,29.119-22.27,46.819
              c20.367,6.091,41.112,9.13,62.24,9.13c39.781,0,76.47-9.801,110.062-29.41c33.595-19.602,60.192-46.199,79.794-79.791
              c19.606-33.599,29.407-70.287,29.407-110.065C438.527,179.485,428.74,142.795,409.141,109.203z" />
                </svg>
            </a>
        </div>
        @if ($item->stock > 0)
            <form action="{{ route('cartItems.store') }}" method="post">
                @csrf
                <input type="text" class="hidden" name="id" value="{{ $item->id }}">
                <button class="block bg-orange-500 text-white py-2 px-6 flex-shrink w-1/3 hover:bg-orange-400 transition-colors"
                    type="submit">{{ __('common.add') }} <svg class="inline h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg></button>
                @error('id')
                    <small class="w-1/2 block text-center" style="color:red">{{ $message }}</small>
                @enderror
            </form>
        @else
            <span style="color:red">{{ __('common.this_article_is_not_available') }}</span>
        @endif
    </div>
@endsection
