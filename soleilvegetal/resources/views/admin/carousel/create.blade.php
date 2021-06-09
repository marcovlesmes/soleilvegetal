@extends('layouts.admin')
@section('content')
<nav class="p-2 my-2 flex justify-start">
    <a class="bg-yellow-300 text-white py-2 px-4 mx-2 rounded-sm leading-3" href="{{ url()->previous() }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
      </svg> Regresar</a>
</nav>
<form action="{{ route('carousel.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="photo">Selecione la imagen (800x600)</label>
    @error('photo')
        <small class="text-red-600">{{ $message }}</small>
    @enderror
    <input type="file" name="photo" id="photo" accept="image/png, image/jpeg">
    <label for="active">Publicar imagen</label>
    <input type="checkbox" name="active" id="active">
    <button class="px-4 py-2 bg-green-400 text-white" type="submit">Subir</button>
</form>
@endsection