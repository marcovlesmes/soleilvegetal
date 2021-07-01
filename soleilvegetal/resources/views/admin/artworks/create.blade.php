@extends('layouts.admin')
@section('content')
    <div x-data="modelManager()" x-init="init()">
        <nav class="p-2 my-2 flex justify-between">
            <a class="bg-yellow-300 text-white py-2 px-4 mx-2 rounded-sm leading-3" href="{{ url()->previous() }}"><svg
                    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg> Regresar</a>
            <button @click="save"
                class="bg-blue-600 text-white py-2 px-4 mx-2 rounded-sm leading-3 disabled:bg-blue-200 disabled:cursor-not-allowed">Guardar
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg></button>
        </nav>
        <form x-ref="dataForm" class="grid grid-cols-3 gap-4 my-5" action="{{ $next->get('action') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method($next->get('method'))
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="autor">Autor</label>
                <select x-on:change="checkOption" class="p-2" name="autor" id="autor">
                    <option value="new">[ Nuevo autor ]</option>
                    @forelse ($artists as $artist)
                        <option value="{{ $artist->id }}" @if (!$item->autor->isEmpty() && $item->autor->first()->name == $artist->name) selected @endif>{{ $artist->name }}</option>
                    @empty
                        <option value="null">No hay autores creados.</option>
                    @endforelse
                </select>
                <div class="py-3 flex flex-col">
                    <label class="pl-3 pb-1 font-semibold" for="new_autor">Nuevo Autor</label>
                    <input class="p-2" type="text" name="new_autor" id="new_autor">
                </div>
                @error('new_autor')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="name">Titulo</label>
                <input class="p-2" type="text" name="name" id="name" value="{{ $item->name }}">
                @error('name')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="year">Año</label>
                <input class="p-2" type="text" name="year" id="year" value="{{ $item->year }}">
                @error('year')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="format">Formato</label>
                <input class="p-2" type="text" name="format" id="format" value="{{ $item->format }}">
                @error('format')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="technique">Técnica</label>
                <select x-on:change="checkOption" class="p-2" name="technique" id="technique">
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
                @error('new_technique')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="edition">Edición</label>
                <input class="p-2" type="text" name="edition" id="edition" value="{{ $item->edition }}">
                @error('edition')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="description">Descripción</label>
                <textarea class="p-2" type="text" name="description" id="description">{{ $item->description }}</textarea>
                @error('description')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="price">Precio (€)</label>
                <input class="p-2" type="text" name="price" id="price" value="{{ $item->price }}">
                @error('price')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="stock">Stock</label>
                <input class="p-2" type="number" name="stock" id="stock" min="0" value="{{ $item->stock }}">
                @error('stock')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="exposed">Público</label>
                <input class="p-2 m-1 ml-3" type="checkbox" name="exposed" id="exposed" @if ($item->exposed) checked @endif>
                @error('exposed')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col border border-white p-2 rounded-sm">
                <label class="pl-3 pb-1 font-semibold" for="images">Imágenes</label>
                <input type="file" name="imageFile[]" class="" id="images" multiple="multiple" accept="image/png, image/jpeg">
            </div>
            <input x-ref="deleteImagesInput" type="hidden" name="deleteImages">
        </form>
        <div x-ref="picturesContainer" class="flex my-5">
            @forelse ($item->image as $image)
                <div id="picture-{{$image->id}}" class="flex-shrink relative">
                    <div class="absolute right-0 top-0 m-2">
                        <button @click="deletePicture({{ $image->id }})">
                            <svg class="h-6 w-6 text-gray-500 hover:text-red-600 transform  hover:scale-110  cursor-pointer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" />
                              <line x1="4" y1="7" x2="20" y2="7" />
                              <line x1="10" y1="11" x2="10" y2="17" />
                              <line x1="14" y1="11" x2="14" y2="17" />
                              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </button>
                    </div>
                    <img src="{{ asset($image->image_source) }}" alt="{{ $image->name }}">
                </div>
            @empty
                <p>Sin imágenes.</p>
            @endforelse
        </div>
    </div>
@endsection
