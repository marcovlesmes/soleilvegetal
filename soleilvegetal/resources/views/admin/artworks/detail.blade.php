@extends('layouts.admin')
@section('content')
    <nav class="p-2 my-2 flex justify-start">
        <a class="bg-yellow-300 text-white py-2 px-4 mx-2 rounded-sm leading-3" href="{{ url()->previous() }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
          </svg> Regresar</a>
    </nav>
    <form class="flex flex-col" action="{{ route('artworks.store') }}" method="POST">
    @csrf
    <select name="artist" id="artist">
        @forelse ($artists as $artist)
            <option value="{{ $artist->id }}">{{ $artist->name }}</option>
        @empty
            <option value="null">No hay autores creados.</option>
        @endforelse
        <option value="new">Nuevo autor</option>
    </select>
    <label for="name">Titulo</label>
    <input type="text" name="name" id="name">
    <label for="year">Año</label>
    <input type="text" name="year" id="year">
    <label for="format">Formato</label>
    <input type="text" name="format" id="format">
    <label for="technique">Técnica</label>
    <select name="technique" id="technique">
        @forelse ($techniques as $technique)
            <option value="{{ $technique->id }}">{{ $technique->name }}</option>
        @empty
            <option value="null">No hay técnicas creadas</option>
        @endforelse
        <option value="new">Nueva técnica</option>
    </select>
    <!-- input type="text" name="technique" id="technique"-->
    <label for="edition">Edición</label>
    <input type="text" name="edition" id="edition">
    <label for="description">Descripción</label>
    <input type="text" name="description" id="description">
    <label for="price">Precio</label>
    <input type="text" name="price" id="price">
    <label for="stock">Stock</label>
    <input type="text" name="stock" id="stock">
    <label for="exposed">Público</label>
    <input type="checkbox" name="exposed" id="exposed">
    <p>Cargar imagenes</p>    
</form>

@endsection