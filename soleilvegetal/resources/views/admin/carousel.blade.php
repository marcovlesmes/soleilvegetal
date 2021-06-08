@extends('layouts.admin')
@section('content')
    <h2 class="text-gray-500 my-5 block font-semibold">Carousel</h2>
    <div class="flex">
        @forelse ($items->where('active', true) as $item)
            <div class="flex-shrink flex-grow bg-white p-2">
                <img class="w-full" src="{{ $item->image_source }}" alt="{{ $item->name }}">
            </div>        
        @empty
        <p class="text-center">No hay imagenes cargadas.</p>
        @endforelse
    </div>
    <nav class="p-2 my-2 flex justify-end">
        <button class="bg-yellow-300 text-white py-2 px-4 mx-2 rounded-sm leading-3">Nuevo <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg></button>
        <button class="bg-blue-600 text-white py-2 px-4 mx-2 rounded-sm leading-3">Guardar <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
          </svg></button>
    </nav>
    <div class="bg-white w-full">
        @forelse ($items as $item)
        <div class="flex p-2">
            <img class="w-auto h-32" src="{{ $item->image_source }}" alt="{{ $item->name }}">
            <label for="checkbox-{{ $item->id }}">Visible</label>
            <input type="checkbox" name="active" id="checkbox-{{ $item->id }}" @if ($item->active) checked @endif>
        </div>
        @empty
        <p class="text-center">No hay imagenes cargadas.</p>
        @endforelse
    </div>
@endsection