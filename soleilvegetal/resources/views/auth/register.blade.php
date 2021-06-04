@extends('layouts.app')

@section('content')
    <div class="w-2/3 justify-center items-center flex bg-white shadow-md mx-auto rounded mb-12">
        <!--Col-->
        <div class="col w-3/5 bg-white rounded">
            <h4 class="text-3xl font-semibold text-gray-600 my-6 pb-2 text-center text-primary ">{{ __('Register') }}</h4>
            <form class="bg-white mx-2 " method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-name">
                    <div class="w-full">
                        <label for="name" class="block text-gray-700 text-lg font-medium ml-4 pl-2 ">{{ __('Name') }}</label>
                        <div class="mb-5  relative rounded-md ml-4">
                            <div class="absolute inset-y-0 right-0 pr-2  pt-1 flex items-center">
                            <svg class="h-6 w-6 text-gray-300"  fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            
                            <input class="block w-full mt-2 ml-2 py-2   appearance-none border-2  border-orange200  leading-tight rounded focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <small class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror

                        </div>
                    </div>

                </div>

                <div class="input-email">
                    <label for="email" class="block text-gray-700 text-lg font-medium ml-4 pl-2 ">{{ __('E-Mail Address') }}</label>

                    
                        <div  class="absolute inset-y-0 right-0 pr-2  pt-1 flex items-center">
                            <svg class="h-6 w-6 text-gray-300"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="3" y="5" width="18" height="14" rx="2" />  <polyline points="3 7 12 13 21 7" /></svg>
                            </div>
                        <input class="block w-full mt-2 ml-2 py-2   appearance-none border-2  border-orange200  leading-tight rounded focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray hover:shadow @error('email') border-red-900 @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <small class="text-red-900" role="alert">
                            <strong>{{ $message }}</strong>
                        </small>
                        @enderror
                    </div>
                </div>

                <div class="input-password">
                    <label for="password" class="block text-gray-700 text-lg font-medium ml-4 pl-2">{{ __('Password') }}</label>
                    <div class="mb-5  relative rounded-md ml-4 ">
                        <div class="absolute inset-y-0 right-0 pr-2  pt-1 flex items-center">
                            <svg class="h-6 w-6 text-gray-300"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="5" y="11" width="14" height="10" rx="2" />  <circle cx="12" cy="16" r="1" />  <path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                        </div>
                         <input class="block w-full mt-2 ml-2 py-2 appearance-none border-2 border-orange200  leading-tight rounded focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray hover:shadow @error('password') border-red-900 @enderror" id="password" type="password"  name="password" required autocomplete="new-password">

                        @error('password')
                        <small class="text-red-900 " role="alert">
                            <strong>{{ $message }}</strong>
                        </small>
                        @enderror
                    </div>
                </div>
                <div class="form-confirm">
                    <label for="password-confirm" class="block text-gray-700 text-lg font-medium ml-4 pl-2">{{ __('Confirm Password') }}</label>
                    <div class="mb-5  relative rounded-md ml-4">
                        <div class="absolute inset-y-0 right-0 pr-2  pt-1 flex items-center">
                            <svg class="h-6 w-6 text-gray-300"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="5" y="11" width="14" height="10" rx="2" />  <circle cx="12" cy="16" r="1" />  <path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                        </div>
                        
                        <input class="block w-full mt-2 ml-2 py-2   appearance-none border-2  border-orange200  leading-tight rounded focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray hover:shadow" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    
                    <div class="flex mx-3">
                        <div class="w-full px-3 mb-5">
                            <button class="block w-full mx-auto mt-8 bg-verde100 text-gray-100  font-bold uppercase text-base rounded shadow-sm  hover:shadow-lg active:bg-verde300 hover:bg-shadow-lg px-2 py-3 border focus:outline-none" type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                            </button>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
        <!--Col-->
        <div class="col w-2/5 h-auto ml-20 w-full">
            <img src="{{ asset('images/register_screen.jpg') }}" >
        </div>
    </div>

@endsection