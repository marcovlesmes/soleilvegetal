@extends('layouts.app')
@section('content')
    <h2>{{ $item->name }}</h2>
    <p>{{ $item->year }}</p>
    <p>Autor: {{ $item->autor }}</p>
    <div>
        <div>
            <div>
                <img src="{{ $item->source_image }}" alt="{{ $item->name }}">
            </div>
        </div>
    </div>
@endsection