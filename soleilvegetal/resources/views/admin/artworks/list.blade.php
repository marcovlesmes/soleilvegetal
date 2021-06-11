@extends('layouts.admin')
@section('content')
    @if ($message = Session::get('success'))
    <div class="bg-green-300 p-3 rounded-sm my-4">
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <nav class="p-2 my-2  flex justify-end mr-28">
        <a class="bg-yellow-300 text-white py-2 px-4 mx-2 rounded-sm leading-3 " href="{{ route('artworks.create') }}">Nuevo <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg></a>
    </nav>
    <div class="bg-white w-10/12 border-2 border-green-500 mx-auto mb-4">
        <table class="table-auto w-full  text-gray-600 bg-green-300 ">
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
                        <td class="border-r p-2 text-center">
                            {{ $item->stock }}
                        </td>
                        <td>
                            <div class="flex justify-around">
                                <a href="{{ route('artworks.destroy', $item->id) }}">
                                    <svg class="h-6 w-6 text-gray-500 hover:text-red-600 transform  hover:scale-110  cursor-pointer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" />
                                      <line x1="4" y1="7" x2="20" y2="7" />
                                      <line x1="10" y1="11" x2="10" y2="17" />
                                      <line x1="14" y1="11" x2="14" y2="17" />
                                      <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                      <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </a>
                                <a href="{{ route('artworks.edit', $item->id) }}">
                                    <svg class="h-6 w-6 text-gray-500  hover:text-blue-600 transform  hover:scale-110  cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <a target="_blank" href="{{ route('artworks.show', $item->id) }}">
                                    <svg class="h-6 w-6 text-gray-500  hover:text-green-600 transform  hover:scale-110  cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                              </div>
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