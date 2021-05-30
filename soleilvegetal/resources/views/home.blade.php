@extends('layouts.app')

@section('content')
<div>
    <h1>Obras</h1>
    <a href="#">Contacto</a>
</div>
<div>
    Filtrar por: <a href="#">Artista</a> <a href="#">Técnica</a>
</div>
<div>
    @foreach ($items as $item)
        <div>
            <img src="{{ asset($item->image->first()->image_source) }}" alt="{{ $item->name }}">
            {{ $item->name }} - {{ $item->year }}
            @foreach ($item->autor as $autor)
            {{ $autor->name }}
            @endforeach
            {{ $item->format }} - ${{ $item->price }}
        </div>
    @endforeach
</div>
@endsection
