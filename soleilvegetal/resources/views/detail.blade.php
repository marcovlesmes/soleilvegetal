@extends('layouts.app')
@section('content')
    <h2>{{ $item->name }}</h2>
    <p>{{ $item->year }}</p>
    <p>Autor: {{ $item->autor->first()->name }}</p>
    <div>
        <div>
            <div>
                @foreach ($item->image as $image)
                <img src="{{ asset($image->image_source) }}" alt="{{ $item->name }}">    
                @endforeach
            </div>
        </div>
    </div>
    {{ $item->name }}
    {{ $item->year }}
    {{ $item->autor->first()->name }}
    {{ $item->technique->first()->name }}
    {{ $item->edition }}
    {{ $item->description }}
    {{ $item->price }}
@endsection