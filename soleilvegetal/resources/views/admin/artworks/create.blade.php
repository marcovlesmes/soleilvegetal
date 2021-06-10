@extends('layouts.admin')
@section('content')
    <div>
        <nav class="p-2 my-2 flex justify-between">
            <a class="bg-yellow-300 text-white py-2 px-4 mx-2 rounded-sm leading-3" href="{{ url()->previous() }}"><svg
                    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg> Regresar</a>
            <button
                class="bg-blue-600 text-white py-2 px-4 mx-2 rounded-sm leading-3 disabled:bg-blue-200 disabled:cursor-not-allowed">Guardar
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg></button>
        </nav>
        <form class="grid grid-cols-3 gap-4 my-5" action="{{ $next->get('action') }}" method="POST">
            @csrf
            @method($next->get('method'))
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="artist">Autor</label>
                <select class="p-2" name="artist" id="artist">
                    <option value="new">[ Nuevo autor ]</option>
                    @forelse ($artists as $artist)
                        <option value="{{ $artist->id }}" @if (!$item->autor->isEmpty() && $item->autor->first()->name == $artist->name) selected @endif>{{ $artist->name }}</option>
                    @empty
                        <option value="null">No hay autores creados.</option>
                    @endforelse
                </select>
                <div class="py-3 flex flex-col">
                    <label class="pl-3 pb-1 font-semibold" for="new_artist">Nuevo Autor</label>
                    <input class="p-2" type="text" name="new_artist" id="new_artist">
                </div>
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="name">Titulo</label>
                <input class="p-2" type="text" name="name" id="name" value="{{ $item->name }}">
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="year">Año</label>
                <input class="p-2" type="text" name="year" id="year" value="{{ $item->year }}">
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="format">Formato</label>
                <input class="p-2" type="text" name="format" id="format" value="{{ $item->format }}">
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="technique">Técnica</label>
                <select class="p-2" name="technique" id="technique">
                    <option value="new">[ Nueva técnica ]</option>
                    @forelse ($techniques as $technique)
                        <option value="{{ $technique->id }}" @if (!$item->technique->isEmpty() && $item->technique->first()->name == $technique->name) selected @endif>{{ $technique->name }}</option>
                    @empty
                        <option value="null">No hay técnicas creadas</option>
                    @endforelse
                </select>
                <div class="py-3 flex flex-col">
                    <label class="pl-3 pb-1 font-semibold" for="new_technique">Nueva Técnica</label>
                    <input class="p-2" type="text" name="new_technique" id="new_technique">
                </div>
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="edition">Edición</label>
                <input class="p-2" type="text" name="edition" id="edition" value="{{ $item->edition }}">
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="description">Descripción</label>
                <textarea class="p-2" type="text" name="description" id="description">{{ $item->description }}</textarea>
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="price">Precio</label>
                <input class="p-2" type="text" name="price" id="price" value="{{ $item->price }}">
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="stock">Stock</label>
                <input class="p-2" type="number" name="stock" id="stock" min="0" value="{{ $item->stock }}">
            </div>
            <div class="flex border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="exposed">Público</label>
                <input class="p-2 m-1 ml-3" type="checkbox" name="exposed" id="exposed" @if ($item->exposed) checked @endif>
            </div>
        </form>
        <div class="flex">
            @forelse ($item->image as $image)
                <div class="flex-shrink">
                    <img src="{{ asset($image->image_source) }}" alt="{{ $image->name }}">
                </div>
            @empty
                <p>Sin imágenes.</p>
            @endforelse
        </div>
    </div>
@endsection
