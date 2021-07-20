@extends('layouts.admin')
@section('content')
    @if ($message = Session::get('success'))
    <div class="bg-green-300 p-3 rounded-sm my-4">
        <strong>{{ $message }}</strong>
    </div>
    @endif
<div x-data="listedItems()" x-init="init()">
    <div class="bg-white w-10/12 border-2 border-green-500 mx-auto mb-4">
        <table class="table-auto w-full text-gray-600 bg-green-300 ">
            <thead>
                <tr class="uppercase text-base">
                    <th class="px-3 py-4 cursor-pointer border-r">Codigo</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Usuario cliente</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Dirección</th>
                    <th class="px-3 py-4 cursor-pointer border-r">E-mail</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Obra</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Formato</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Edición</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Precio</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Stock</th>
                    <th class="px-3 py-4 cursor-pointer border-r">Pública</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse ($items as $item)
                    <tr class="border-solid border-2 bg-white">
                        <td class="border-r p-2">
                            {{ $item->transaction->transaction_id }}    
                        </td>
                        <td class="border-r p-2">
                            {{ $item->user->name }}
                        </td>
                        <td class="border-r p-2">
                            @foreach ($item->user->address as $address)
                            {{ $address->street . '#' . $address->number . '-' . $address->complement . '. ' . $address->detail }}<br>
                            {{ $address->state . ' - ' . $address->city }}
                            @endforeach
                        </td>
                        <td class="border-r p-2">
                            {{ $item->user->email }}
                        </td>
                        <td class="border-r p-2">
                            {{ $item->artwork->name . '(' . $item->artwork->year . ')'}}
                        </td>
                        <td class="border-r p-2">
                            {{ $item->artwork->format }}
                        </td>
                        <td class="border-r p-2">
                            {{ $item->artwork->edition }}
                        </td>
                        <td class="border-r p-2">
                            {{ '' . $item->artwork->price }} 
                        </td>
                        <td class="border-r p-2">
                            {{ $item->artwork->stock }} 
                        </td>
                        <td class="border-r p-2">
                            {{ ($item->artwork->exposed == 1 ? 'Sí' : 'No') }} 
                        </td>
                    </tr>
                @empty
                <p class="text-center">No hay transferencias cargadas.</p>
                @endforelse
            </tbody>
        </table>
    </div>
    <form x-ref="destroyForm" action="{{ route('orders.destroy', 0) }}" method="post">
    @csrf
    @method('DELETE')
    </form>
</div>
<div class="flex justify-center my-5">
    {{ $items->links() }}
</div>
@endsection