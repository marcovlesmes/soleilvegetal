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
    <div class="container mx-auto mt-5">
        <nav class="flex justify-evenly items-center">
            <img src="{{ asset('images/soleil-vegetal-logo.png') }}" alt="Soleil Vegetal">
        </nav>
        <nav class="flex justify-end space-x-4 mb-5">
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
                <svg class="h-4 w-4 mx-auto" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="none"
                    fill="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M22 4.01c-1 .49-1.98.689-3 .99-1.121-1.265-2.783-1.335-4.38-.737S11.977 6.323 12 8v1c-3.245.083-6.135-1.395-8-4 0 0-4.182 7.433 4 11-1.872 1.247-3.739 2.088-6 2 3.308 1.803 6.913 2.423 10.034 1.517 3.58-1.04 6.522-3.723 7.651-7.742a13.84 13.84 0 0 0 .497 -3.753C20.18 7.773 21.692 5.25 22 4.009z" />
                </svg>
            </a>
            <a class="p-1 text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900"
                href="#">
                <svg class="h-4 w-4 mx-auto" viewBox="0 0 24 24" fill="currentColor" stroke="none" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z" />
                    <polygon fill="white" points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" />
                </svg>
            </a>
            <a class="p-1 text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900"
                href="#">
                <svg class="h-4 w-4 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                </svg>
            </a>
        </nav>
        <div class="flex">
            <div class="w-2/3 p-5">
                <a class="block mb-6 text-yellow-500 hover:text-yellow-400" href="{{ route('artworks.index') }}">
                    <svg class="h-3 w-3 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    {{ __('common.go_back') }}
                </a>
                <h1 class="text-3xl font-semibold my-6 pb-2 text-center text-primary">Checkout</h1>
                <h2 class="text-gray-500">{{ __('user.address') }}</h2>
                @forelse ($addresses as $address)
                    <ul>
                        <li class="bg-white w-full p-3 my-5">
                            <h2 class="text-primary text-lg">
                                {{ $address->street . ' ' . $address->number . '#' . $address->complement }}</h2>
                            <span
                                class="text-gray-400 text-sm">{{ $address->detail . ' - ' . $address->city . ', ' . $address->state }}
                            </span>
                            <a class="block text-linky" href="#">{{ __('common.modify') }}</a>
                        </li>
                    </ul>
                @empty
                    <p class="my-3">{{ __('user.no_address_found') }}.</p>
                    <form class="grid grid-cols-2 gap-4" method="POST" action="{{ route('addresses.store') }}">
                        @csrf
                        <div class="flex flex-col my-2">
                            <label class="block text-gray-700 text-lg font-medium ml-4 pl-2"
                                for="state">{{ __('common.state') }}:</label>
                            <input
                                class="block w-full mt-2 ml-2 p-2 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray @error('state') border border-red-900 @enderror"
                                type="text" name="state" id="state" value="{{ old('state') }}">
                            @error('state')
                                <small class="text-red-900">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="flex flex-col my-2">
                            <label class="block text-gray-700 text-lg font-medium ml-4 pl-2" for="city">{{ __('common.city') }}:</label>
                            <input
                                class="block w-full mt-2 ml-2 p-2 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray @error('city') border border-red-900 @enderror"
                                type="text" name="city" id="city" value="{{ old('city') }}">
                            @error('city')
                                <small class="text-red-900">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="flex flex-col my-2">
                            <label class="block text-gray-700 text-lg font-medium ml-4 pl-2" for="street">{{ __('common.street') }}:</label>
                            <input
                                class="block w-full mt-2 ml-2 p-2 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray @error('street') border border-red-900 @enderror"
                                type="text" name="street" id="street" value="{{ old('street') }}">
                            @error('street')
                                <small class="text-red-900">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="flex flex-col my-2">
                            <label class="block text-gray-700 text-lg font-medium ml-4 pl-2"
                                for="number">{{ __('common.number') }}:</label>
                            <div class="flex">
                                <div class="relative">
                                    <span class="absolute inset-y-2 left-0 pl-6 text-lg text-gray-300 pt-1 flex items-center">#</span>
                                    <input
                                        class="block w-full mt-2 ml-2 p-2 pl-7 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray @error('number') border border-red-900 @enderror"
                                        type="text" name="number" id="number" value="{{ old('number') }}">
                                </div>
                                <div class="relative ml-10">
                                    <span class="absolute inset-y-2 left-0 pl-6 text-lg text-gray-300 pt-1 flex items-center">-</span>
                                    <input
                                        class="block w-full mt-2 ml-2 p-2 pl-7 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray @error('complement') border border-red-900 @enderror"
                                        type="text" name="complement" id="complement"
                                        value="{{ old('complement') }}">
                                </div>
                            </div>
                            <div class="block">
                                @error('number')
                                    <small class="text-red-900">{{ $message }}</small>
                                @enderror
                                @error('complement')
                                    <small class="text-red-900">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-col my-2">
                            <label class="block text-gray-700 text-lg font-medium ml-4 pl-2" for="detail">{{ __('common.optional_data') }} ({{ str_to_lower(__('common.opcional')) }}):</label>
                            <input
                                class="block w-full mt-2 ml-2 p-2 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray @error('detail') border border-red-900 @enderror"
                                type="text" name="detail" id="detail" value="{{ old('detail') }}">
                            @error('detail')
                                <small class="text-red-900">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="flex flex-col-reverse items-end">
                            <button type="submit" class="block h-10 bg-orange-500 text-white py-2 px-6 flex-shrink w-1/3 hover:bg-orange-400 transition-colors" type="submit">{{ __('common.add') }}</button>
                        </div>
                    </form>
                @endforelse
                @if ($addresses->count() > 0)
                    <h2 class="text-gray-500">{{ __('commerce.pay_mode') }}</h2>
                    <form method="post" action="{{ env('PAYU_URL') }}">
                        @foreach ($order as $key => $value)
                        <input name="{{ $key }}" type="hidden" value="{{ $value }}">    
                        @endforeach
                        <input class="text-white font-semibold p-3 rounded-sm cursor-pointer" style="background-color: #A6C307" name="Submit" type="submit" value="PayU">
                    </form>
                @endif
            </div>
            <div class="w-1/3 bg-white h-full p-5 divide-y divide-gray-200">
                <form method="POST" action="">
                    @foreach ($items as $item)
                        <div class="grid grid-cols-2 p-5 my-2">
                            <img class="w-2/3" src="{{ asset($item->artwork->image->where('priority', '=', 0)->first()->image_source) }}"
                                alt="{{ $item->artwork->name }}">
                            <ul>
                                <li class="text-primary">{{ $item->artwork->name }}</li>
                                <li>
                                    <label for="quantity">{{ __('commerce.quantity') }}:</label>
                                    <input class="border" type="number" name="quantity" id="quantity"
                                        value="{{ $item->quantity }}" min="1" max="{{ $item->artwork->stock }}">
                                </li>
                                <li>€{{ $item->artwork->price }}</li>
                            </ul>
                        </div>
                    @endforeach
                    <label for="instructions">{{ __('commerce.delivery_instructions') }}:</label>
                    <textarea name="instructions" id="instructions">{{ old('instructions') }}</textarea>
                    <p>Subtotal: €<span>{{ $items->subtotal }}</span></p>
                </form>
            </div>
        </div>


    </div>
</body>

</html>
