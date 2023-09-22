@extends('layouts.layout')

@section('title', 'Products')

@section('content')

    <div class="h-screen flex justify-between flex-wrap mx-10 gap-2">
        @foreach($products as $product)
            <div class="w-72 bg-white shadow-lg rounded-lg overflow-hidden pb-3">
                <img class="w-full h-56 object-cover object-center" src="{{$product->image_url}}" alt="{{$product->name}}">
                <div class="flex items-center px-6 py-3 bg-gray-900">
                    <svg class="h-6 w-6 text-white fill-current" viewBox="0 0 512 512">
                        <path d="M256 48C150 48 64 136.2 64 245.1v153.3c0 36.3 28.6 65.7 64 65.7h64V288h-85.3v-42.9c0-84.7 66.8-153.3 149.3-153.3s149.3 68.5 149.3 153.3V288H320v176h64c35.4 0 64-29.3 64-65.7V245.1C448 136.2 362 48 256 48z"/>
                    </svg>
                    <h1 class="mx-3 text-white font-semibold text-lg">{{$product->name}}</h1>
                </div>
                <div class="py-4 px-6">
                    <h1 class="text-2xl font-semibold text-sky-800 mb-2">{{$product->price}} sum</h1>
                    <a href="{{route('products.show', $product)}}" class="p-2 bg-green-500 hover:bg-green-600 rounded text-white">Перейти к товару</a>
                </div>
            </div>
        @endforeach
    </div>

@endsection
