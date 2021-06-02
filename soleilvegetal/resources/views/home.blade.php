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
                    @if ($autors->hasMorePages())
                    <li class="text-primary font-normal capitalize hover:text-secondary text-sm max-w-max p-0 py-3 text-center mx-auto"><a href="{{ route('autors.index') }}">Ver todos</a></li>
                    @endif
                </ul>
            </li>
            <li class="group uppercase text-primary text-sm font-semibold hover:text-secondary">
                <a href="#">Contacto</a>
            </li>
        </ul>
    </div>
    <div class="my-24 text-primary">
        <span class="text-secondary">Filtrar por:</span> <a href="#">Artista</a> <a href="#">Técnica</a>
    </div>
    <div class="grid grid-cols-gallery gap-4">
        @foreach ($items as $item)
            <div>
                <a class="text-linky font-semibold" href="{{ Route('artworks.show', $item->id) }}">
                    <img class="mx-auto" src="{{ asset($item->image->first()->image_source) }}" alt="{{ $item->name }}">
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
                        {{ $item->format }} - <span class="font-bold">${{ $item->price }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if (isset($items->links))
        {{ $items->links() }}
    @endif
@endsection
