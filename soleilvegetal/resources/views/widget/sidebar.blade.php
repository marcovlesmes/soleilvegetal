<nav
    class="group fixed left-0 top-0 bg-white h-full flex flex-col items-center justify-between hover:items-start hover:shadow-sm z-50 p-3">
    <svg class="group-hover:hidden w-7 h-7" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <svg class="hidden group-hover:block w-7 h-7" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
            d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
    </svg>
    <div x-data="sidebar()" x-init="init()" class="grid gap-y-2 group-hover:grid-cols-sidebar">
        <svg class="w-8 h-8 mx-auto" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <form x-ref="search_form" class="hidden group-hover:flex" action="{{ route('search', 'keywork') }}" method="GET">
            <input type="text" class="hidden group-hover:block w-max-32 mx-2 appearance-none border-2 border-orange200 leading-tight focus:outline-none focus:bg-white focus:border-orange500 hover:shadow transition duration-500 ease-in-out text-gray">
            <button @click="submit_form" type="submit">{{ __('common.search') }}</button>
        </form>
        @guest
            <svg class="w-8 h-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="hidden group-hover:flex">
                <a class="hidden group-hover:block flex-grow text-center"
                    href="{{ route('login') }}">{{ __('Login') }}</a>
                /
                <a class="hidden group-hover:block flex-grow text-center"
                    href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
        @else
            <svg class="h-7 w-7 text-black border-2 rounded-full p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <button @click="$dispatch('toggle')" class="hidden group-hover:flex focus:outline-none">{{ __('commerce.shopping_cart') }} @if (isset($cart) && $cart->count() > 0) <span class="text-xs p-1 mx-3 border border-orange200 text-gray-500 font-bold leading-3 w-5 h-5">{{ $cart->count() }}</span> @endif</button>
            <svg class="h-7 w-7 text-black border-2 rounded-full p-1" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <a class="hidden group-hover:flex" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                {{ __('common.logout') }}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>
        @endguest
    </div>
</nav>
