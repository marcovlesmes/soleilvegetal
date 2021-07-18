@extends('layouts.app')

@section('content')
    <div class="flex w-3/4 mx-auto">
        <ul class="flex-grow flex items-center">
            <li><h1 class="text-primary text-3xl mr-24"><a href="{{ route('artworks.index') }}">Obras</a></h1></li>
            <li class="group uppercase text-primary font-semibold hover:text-secondary hover:bg-gray-200 px-5 text-sm relative"><a href="">Artistas</a>
                <ul class="absolute hidden group-hover:block bg-gray-200  left-0">
                    @foreach ($autors as $autor)
                    <li class="text-primary font-normal capitalize hover:text-secondary text-sm max-w-max p-0 py-3 text-center mx-auto"><a href="{{ route('autors.show', $autor->id) }}">{{$autor->name}}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="group uppercase text-primary text-sm font-semibold hover:text-secondary">
                <a href="#">Contacto</a>
            </li>
        </ul>
    </div>
    <div x-data="filter()" x-init="init()" class="my-20 text-primary">
        <span class="text-secondary">Filtrar por:</span> <button @click="show_autor = true">Autor</button> <button @click="show_technique = true">Técnica</button>
        <form class="divide-y divide-white" x-ref="filter_form" x-show="show_autor || show_technique" action="{{ route('filter', 'ids') }}">
            <ul x-ref="autors" x-show="show_autor" class="grid grid-cols-7 py-5">
                <h2 class="col-span-7 font-semibold text-lg">Autor</h2>
                @foreach ($autors as $autor)
                    <li>
                        <input id="autor_{{ $autor->id }}" x-on:change="checkSwap" type="checkbox" checked>
                        <label for="autor_{{ $autor->id }}">{{ $autor->name }}</label>
                    </li>
                @endforeach
            </ul>
            <ul x-ref="techniques" x-show="show_technique" class="grid grid-cols-7 py-5">
                <h2 class="col-span-7 font-semibold text-lg">Técnica</h2>
                @foreach ($techniques as $technique)
                    <li>
                        <input id="technique_{{ $technique->id }}" x-on:change="checkSwap" type="checkbox" checked>
                        <label for="technique_{{ $technique->id }}">{{ $technique->name }}</label>
                    </li>
                @endforeach
            </ul>
            <button @click="filter" class="bg-yellow-300 text-white px-3 py-1">Aceptar</button>
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
            <p>No se encontraron obras.</p>
        @endforelse
    </div>
    <div class="flex justify-center my-5">
        {{ $items->links() }}
    </div>
@endsection
