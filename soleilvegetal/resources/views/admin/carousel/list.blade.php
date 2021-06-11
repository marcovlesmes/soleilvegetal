@extends('layouts.admin')
@section('content')
    <h2 class="text-gray-500 my-5 block font-semibold">Carousel</h2>
    <div class="flex">
        @forelse ($items->where('active', true) as $item)
            <div class="flex-shrink flex-grow bg-white p-2">
                <img class="w-full" src="{{ asset($item->image_source) }}" alt="{{ $item->name }}">
            </div>        
        @empty
        <p class="text-center">No hay imagenes cargadas.</p>
        @endforelse
    </div>
    <div x-data="listedItems()" x-init="init()">
        <nav class="p-2 my-2 flex justify-end">
            <a href="{{ route('carousel.create') }}" class="bg-yellow-300 text-white py-2 px-4 mx-2 rounded-sm leading-3">Nuevo <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg></a>
            <button x-ref="saveListBtn" @click="setCarousel()" class="bg-blue-600 text-white py-2 px-4 mx-2 rounded-sm leading-3 disabled:bg-blue-200 disabled:cursor-not-allowed">Guardar <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
              </svg></button>
        </nav>
        <div x-ref="itemsContainer" class="flex">
            @forelse ($items as $item)
            <div class="flex flex-col p-2 bg-white m-5">
                <img class="w-auto h-32" src="{{ asset($item->image_source) }}" alt="{{ $item->name }}">
                <div>
                    <label for="checkbox-{{ $item->id }}">Visible</label>
                    <input @click="checkChanges()" type="checkbox" name="active" id="checkbox-{{ $item->id }}" @if ($item->active) checked @endif>
                    <button @click="destroy({{ $item->id }})">
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
            </div>
            @empty
            <p class="text-center">No hay imagenes cargadas.</p>
            @endforelse
            <form x-ref="setForm" action="{{ route('carousel.set') }}" method="POST">
                @csrf
                <input type="hidden" id="setter" name="status">
            </form>
            <form x-ref="destroyForm" action="{{ route('carousel.destroy', 0) }}" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection