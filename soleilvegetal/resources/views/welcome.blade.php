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
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .scroll-snap-x {
            scroll-snap-type: x mandatory;
        }

        .snap-center {
            scroll-snap-align: center;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <script>
        window.carousel = function () {
            return {
                container: null,
                prev: null,
                next: null,
                init() {
                    this.container = this.$refs.container;
                    this.update();
                    this.container.addEventListener('scroll', this.update.bind(this), {passive: true});
                },
                update() {
                    const rect = this.container.getBoundingClientRect();
                    const visibleElements = Array.from(this.container.children).filter((child) => {
                        const childRect = child.getBoundingClientRect();
                        return childRect.left >= rect.left && childRect.right <= rect.right;
                    });

                    if (visibleElements.length > 0) {
                        this.prev = this.getPrevElement(visibleElements);
                        this.next = this.getNextElement(visibleElements);
                    }
                },
                getPrevElement(list) {
                    const sibling = list[0].previousElementSibling;
                    if (sibling instanceof HTMLElement) {
                        return sibling;
                    }
                    return null;
                },
                getNextElement(list) {
                    const sibling = list[list.length - 1].nextElementSibling;
                    if (sibling instanceof HTMLElement) {
                        return sibling;
                    }
                    return null;
                },
                scrollTo(element) {
                    const current = this.container;
                    if (!current || !element) return;
                    const nextScrollPosition = element.offsetLeft +
                                                element.getBoundingClientRect().width / 2 -
                                                current.getBoundingClientRect().width / 2;
                    current.scroll({
                        left: nextScrollPosition,
                        behavior: 'smooth',
                    });
                }
            };
        };
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GD81Z8NCEG"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-GD81Z8NCEG');
    </script>
</head>

<body class="bg-gray-200">
    @include('widget.sidebar')
    @include('widget.shoppingcart')
    <div class="container mx-auto mt-5">
        <nav class="flex justify-evenly items-center">
            <img src="{{ asset('images/soleil-vegetal-logo.png') }}" alt="Soleil Vegetal">
            <ul class="flex-grow flex justify-evenly">
                <li
                    class="group uppercase text-primary font-semibold hover:text-secondary hover:bg-gray-200 px-5 relative">
                    <a href="">{{ __('common.artists') }}</a>
                    <ul class="absolute hidden group-hover:block bg-gray-200 z-10 left-0 overflow-y-scroll max-h-screen scrollbar scrollbar-thumb-yellow-500 scrollbar-track-gray-100 scrollbar-thin p-1">
                        @foreach ($autors as $autor)
                            <li
                                class="text-primary font-normal capitalize hover:text-secondary text-sm max-w-max p-3 text-center mx-auto">
                                <a href="{{ route('autors.show', $autor->id) }}">{{ $autor->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="group uppercase text-primary font-semibold hover:text-secondary">
                    <a href="{{ route('artworks.index') }}">{{ __('common.artworks') }}</a>
                </li>
                <li class="group uppercase text-primary font-semibold hover:text-secondary">
                    <a href="#contact">{{ __('common.contact') }}</a>
                </li>
                <li class="group text-gray-900 font-light">
                    <a href="{{ route('set.language', 'es') }}">Español</a> - <a href="{{ route('set.language', 'en') }}">English</a>
                </li>
            </ul>
        </nav>
        <nav class="flex justify-end space-x-4 mb-5"> <!-- Social icons -->
            <a class="p-1 text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900"
                href="#">
                <svg class="h-4 w-4 mx-auto" viewBox="0 0 24 24" stroke-width="2"
                    stroke="none" fill="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path  d="M0 0h24v24H0z" />
                    <path fill="white" d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                </svg>
            </a>
            <a class="p-1 text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900"
                href="#">
                <svg class="h-4 w-4 mx-auto" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="none" fill="currentColor" stroke-linecap="round" stroke-linejoin="round">
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
    </div>
    <div x-data="carousel()" x-init="init()" class="relative overflow-hidden group"> <!-- carousel -->
        <div x-ref="container" class="flex space-x-32 overflow-x-scroll scroll-snap-x no-scrollbar"> <!-- items container -->
            @foreach ($items as $item)
                <div class="bg-gray-100 overflow-hidden flex-auto flex-grow-0 flex-shrink-0 snap-center" style="max-width: 800px">
                    <div><img src="{{ asset($item->image_source) }}"></div>
                </div>
            @endforeach
        </div>
        <div @click="scrollTo(prev)" x-show="prev !== null" class="absolute top-1/2 left-1/4 cursor-pointer w-8 h-8 font-bold text-4xl">
            <!-- left navigation -->
            <div style="color:white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 bg-black bg-opacity-30 p-2 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
        </div>
        <div @click="scrollTo(next)" x-show="next !== null" class="absolute top-1/2 right-1/4 cursor-pointer w-8 h-8 font-bold text-4xl">
            <!-- right navigation -->
            <div style="color:white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 bg-black bg-opacity-30 p-2 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-72 mt-5">
        <p>{{ __('home.main') }}</p>
    </div>
    <footer class="">
        <ul class="flex flex-col items-end justify-items-center h-16 bg-white text-gray-500 my-5 p-3 shadow" id="contact">
            <li>Teléfono: 0000000</li>
            <li>email@soleilvegetal.com</li>
        </ul>
    </footer>
</body>

</html>
