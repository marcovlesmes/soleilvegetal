@extends('layouts.app')

@section('content')
    <div class="w-2/3 justify-center items-center flex bg-white shadow-md mx-auto mb-12">
        <!--COL-->
        <div class="w-3/5 bg-white">
            <h4 class="text-3xl font-semibold my-6 pb-2 text-center text-primary">{{ __('Login') }}</h4>
            <form class="bg-white mx-2" method="POST" action="{{ route('login') }}">
            @csrf
                <div class="w-full">
                    <label for="email" class="block text-gray-700 text-lg font-medium ml-4 pl-2">{{ __('E-Mail Address') }}</label>
                    <div class="mb-5 relative ml-4">
                        <div class="absolute inset-y-0 right-0 pr-2 pt-1 flex items-center">
                            <svg class="h-6 w-6 text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <polyline points="3 7 12 13 21 7" />
                            </svg>
                        </div>
                        <input id="email" type="email" class="block w-full mt-2 ml-2 p-2 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray @error('email') border-red-900 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <small class="text-red-900" role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                    <label for="password" class="block text-gray-700 text-lg font-medium ml-4 pl-2">{{ __('Password') }}</label>
                    <div class="group mb-5 relative ml-4">
                        <div class="absolute inset-y-0 right-0 pr-2 pt-1 flex items-center group-hover:right-5 transition-all">
                            <svg class="h-6 w-6 text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <rect x="5" y="11" width="14" height="10" rx="2" />
                                <circle cx="12" cy="16" r="1" />
                                <path d="M8 11v-4a4 4 0 0 1 8 0v4" />
                            </svg>
                        </div>
                        <input class="block w-full mt-2 ml-2 p-2 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray @error('password') border-red-900 @enderror" id="password" type="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <small class="text-red-900" role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-5 ml-4">
                        <label class="inline-flex items-center cursor-pointer">
                            <input class="form-checkbox border-0 text-gray-800 ml-1 w-5 h-5" style="transition: all 0.15s ease 0s;" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2 text-md font-semibold text-gray-700" for="remember">{{ __('Remember Me') }}</span>
                        </label>
                    </div>
                    <div class="m-5 flex flex-row-reverse justify-between items-center">
                        <button type="submit" class="block bg-orange-500 text-white py-2 px-6 flex-shrink w-1/3 hover:bg-orange-400 transition-colors">{{ __('Login') }}</button>
                        @if (Route::has('password.request'))
                            <a class="text-linky" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <!--COL-->
        <div class="h-auto ml-20 w-full">
            <img src="{{ asset('images/register_screen.jpg') }}">
        </div>
    </div>
@endsection
