@extends('layouts.admin')
@section('content')
    <h2 class="text-gray-500 my-5 block font-semibold">Obras</h2>
    <nav class="p-2 my-2 flex justify-end">
        <button class="bg-yellow-300 text-white py-2 px-4 mx-2 rounded-sm leading-3">Nuevo <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg></button>
    </nav>
    <div class="bg-white w-full">
        <table class="table-auto w-full border text-gray-600">
            <thead>
                <tr class="uppercase text-base">
                    <th class="px-3 py-4 cursor-pointer border-r">Artista</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Técnica</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Obra</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Stock</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse ($items as $item)
                    <tr class="border-solid border-2 bg-white">
                        <td class="border-r p-2">
                            @foreach ($item->autor as $autor)
                            {{ $autor->name }}    
                            @endforeach
                        </td>
                        <td class="border-r p-2">
                            @foreach ($item->technique as $technique)
                            {{ $technique->name }}    
                            @endforeach
                        </td>
                        <td class="border-r p-2">
                            {{ $item->name }}
                        </td>
                        <td class="border-r p-2">
                            {{ $item->stock }}
                        </td>
                    </tr>
                @empty
                <p class="text-center">No hay obras cargadas.</p>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $items->links() }}
@endsection