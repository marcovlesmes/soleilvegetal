@extends('layouts.app')

@section('content')
    <div class="flex w-3/4 mx-auto">
        <ul class="flex-grow flex items-center">
            <li><h1 class="text-primary text-3xl mr-24"><a href="{{ route('artworks.index') }}">{{ __('common.artworks') }}</a></h1></li>
            <li class="group uppercase text-primary font-semibold hover:text-secondary hover:bg-gray-200 px-5 text-sm relative"><a href="">{{ __('common.artists') }}</a>
                <ul class="absolute hidden group-hover:block bg-gray-200 left-0 overflow-y-scroll max-h-screen scrollbar scrollbar-thumb-yellow-500 scrollbar-track-gray-100 scrollbar-thin p-1">
                    @foreach ($autors as $autor)
                    <li class="text-primary font-normal capitalize hover:text-secondary text-sm max-w-max p-0 py-3 text-center mx-auto"><a href="{{ route('autors.show', $autor->id) }}">{{$autor->name}}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="group uppercase text-primary text-sm font-semibold hover:text-secondary">
                <a href="#contact">{{ __('common.contact') }}</a>
            </li>
        </ul>
    </div>
    <div x-data="filter()" x-init="init()" class="my-20 text-primary">
        <span class="text-secondary">{{ __('common.filter_by') }}:</span> <button @click="show_autor = true">{{ __('common.artist') }}</button> <button @click="show_technique = true">{{ __('common.technique') }}</button>
        <form class="divide-y divide-white" x-ref="filter_form" x-show="show_autor || show_technique" action="{{ route('filter', 'ids') }}">
            <div x-show="show_autor">
                <h2 class="font-semibold text-lg my-3">{{ __('common.artist') }}</h2>
                <ul x-ref="autors" class="grid grid-cols-7 pb-5">
                    @foreach ($autors as $autor)
                        <li>
                            <input id="autor_{{ $autor->id }}" x-on:change="checkSwap" type="checkbox" checked>
                            <label for="autor_{{ $autor->id }}">{{ $autor->name }}</label>
                        </li>
                    @endforeach
                    <li class="col-span-full"><button @click="toggleAutorCheckbox(event)" class="border border-gray-300 text-primary hover:bg-gray-50 px-2">Deseleccionar todos</button></li>
                </ul>
            </div>
            <div x-show="show_technique">
                <h2 class="font-semibold text-lg my-3">{{ __('common.technique') }}</h2>
                <ul x-ref="techniques" class="grid grid-cols-7 pb-5">
                    @foreach ($techniques as $technique)
                        <li>
                            <input id="technique_{{ $technique->id }}" x-on:change="checkSwap" type="checkbox" checked>
                            <label for="technique_{{ $technique->id }}">{{ $technique->name }}</label>
                        </li>
                    @endforeach
                    <li class="col-span-full"><button @click="toggleTechniqueCheckbox(event)" class="border border-gray-300 text-primary hover:bg-gray-50 px-2">Deseleccionar todos</button></li>
                </ul>
            </div>
            <button @click="filter" class="bg-yellow-300 text-white px-3 py-1">{{ __('common.apply') }}</button>
        </form>
    </div>
    <div class="grid grid-cols-gallery gap-4 gap-y-20 my-5">
        @forelse ($items as $item)
            <div>
                <a class="text-linky font-semibold" href="{{ Route('artworks.show', $item->id) }}">
                    @if ($item->image->isEmpty())
                    <img class="mx-auto" src="{{ asset('images/no-image.png') }}" alt="No image avalible">
                    @else
                    <img class="mx-auto max-h-52" src="{{ asset($item->image->sortBy('priority')->first()->image_source) }}" alt="{{ $item->name }}">
                    @endif
                </a>
                
                <div class="flex flex-col items-center text-primary">
                    <div>
                        <a class="text-linky font-semibold" href="{{ Route('artworks.show', $item->id) }}">{{ $item->name }}</a> - {{ $item->year }}
                    </div>
                    <div>
                        @foreach ($item->autor as $autor)
                        <a href="{{ Route('autors.show', $autor->id) }}">{{ $autor->name }}</a>
                        @endforeach
                    </div>
                    <div>
                        {{ $item->format }} - <span class="font-bold">€{{ $item->price }}</span>
                    </div>
                </div>
            </div>
        @empty
            <p>{{ __('common.not_found_artwork') }}</p>
        @endforelse
    </div>
    @if ($items->isNotEmpty() && method_exists($items, 'links'))
    <div class="flex justify-center my-5">
        {{ $items->links() }}
    </div>
    @endif
    
@endsection
