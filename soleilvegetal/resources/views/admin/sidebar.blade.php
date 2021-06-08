<nav
    class="bg-white h-full flex flex-col items-start shadow-sm z-50 p-3">
    <a class="block ml-20 my-5" href="{{ url('/') }}">
        <img class="h-12 w-auto" src="{{ asset('images/soleil-vegetal-logo.png') }}" alt="Soleil Vegetal">
    </a>
    <div class="grid gap-y-2 grid-cols-sidebar w-full mt-5">
        <svg class="w-8 h-8 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <a class="block ml-5"
                href="{{ route('dashboard') }}">Home Page</a>
        <svg class="w-8 h-8 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
        </svg>
        <a class="block ml-5"
                href="{{ route('artworks.list') }}">Artwork</a>
        <svg class="w-8 h-8 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
        </svg>
        <a class="block ml-5"
                href="{{ route('orders.index') }}">Transferencias</a>
    </div>
</nav>