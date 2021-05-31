@extends('layouts.app')
@section('content')
    <div class= "container ml-32">

        <div class="grid grid-cols-4 gap-y-12 gap-x-4 row-span-6 grid-cols-1 md:grid-col-2">
            <div class="col-span-4 mb-14">
                <h2 class="text-3xl text-primary">Título: {{ $item->name }}</h2>
                <p class="font-medium">{{ $item->year }}</p>
                <p class="font-medium">Autor: {{ $item->autor->first()->name }}</p>
            </div>
            <div class="col-span-2 row-span-4 ">
                <div class="text-grey-600 bg-white flex items-center justify-center">Art</div>   
            </div>
            <div class="col-span-2 row-span-6 mx-10  ">
                    <h3 class="text-lg font-semibold text-gray-800 my-6 pb-2 ">Acerca de La Obra: </h3>
                    <div class="grid grid-cols-2 gap-y-2">
                        <span class="font-medium mb-12">Título:</span> <span class="text-primary mb-12">{{ $item->name }}</span>
                        <span class="font-medium mb-6">Año:</span> <span class="text-primary mb-4">{{ $item->year }}</span>
                        <span class="font-medium">Autor:</span> <span class="text-primary">{{ $item->autor->first()->name }}</span>
                        <span class="font-medium">Techinique:</span> <span class="text-primary">{{ $item->technique->first()->name }}</span>
                        <span class="font-medium">Edition:</span> <span class="text-primary">{{ $item->edition }}</span>
                        <span class="font-medium">Description:</span> <span class="text-primary">{{ $item->description }}</span>
                        <span class="font-medium">Price:</span> <span class="text-primary">{{ $item->price }}</span>
                    </div>
                
                </div>   
            </div>
            <div class= "col-start-1 col-end-3 row-span-2 flex ">
                @foreach ($item->image as $image)
                    <img src="{{ asset($image->image_source) }}" alt="{{ $item->name }}">    
                @endforeach
            </div>
            <div class="col-span-2 flex mt-6 gap-x-2 ">
                <p class="px-4 text-primary font-medium">Comparte</p>
                <a class="text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900 h-8 w-8 shadow-icon" href="#">
                    <svg class="h-6 w-6 mx-auto"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                </a>
                <a class="text-primary hover:text-secondary active:text-secondary focus:outline-none transition-all duration-150 border-2 border-green-900 h-8 w-8 shadow-icon" href="#">
                <svg class="h-6 w-6 mx-auto"  width="24" height="24"   viewBox="0 0 24 24"><path d="m12.326 0c-6.579.001-10.076 4.216-10.076 8.812 0 2.131 1.191 4.79 3.098 5.633.544.245.472-.054.94-1.844.037-.149.018-.278-.102-.417-2.726-3.153-.532-9.635 5.751-9.635 9.093 0 7.394 12.582 1.582 12.582-1.498 0-2.614-1.176-2.261-2.631.428-1.733 1.266-3.596 1.266-4.845 0-3.148-4.69-2.681-4.69 1.49 0 1.289.456 2.159.456 2.159s-1.509 6.096-1.789 7.235c-.474 1.928.064 5.049.111 5.318.029.148.195.195.288.073.149-.195 1.973-2.797 2.484-4.678.186-.685.949-3.465.949-3.465.503.908 1.953 1.668 3.498 1.668 4.596 0 7.918-4.04 7.918-9.053-.016-4.806-4.129-8.402-9.423-8.402z"/></svg>
                </a>
            </div>
        </div>
        
            
            
        </div>
    </div>
    
            
        
        
    
    
   
    
@endsection