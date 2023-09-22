@extends('layouts.layout')

@section('title', "$user->name information")

@section('content')
    <div class="h-screen flex flex-col justify-center items-center">
        <div class="mb-5">
            <a class="py-2 px-4 bg-gray-400 hover:bg-gray-500 rounded-lg" href="{{route('users.index')}}">
                [Arrow left] Back
            </a>
        </div>
        <div class="max-w-sm bg-white shadow-lg rounded-lg overflow-hidden pb-3">
            <img class="w-full h-56 object-cover object-center" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" alt="avatar">
            <div class="flex items-center px-6 py-3 bg-gray-900">
                <svg class="h-6 w-6 text-white fill-current" viewBox="0 0 512 512">
                    <path d="M256 48C150 48 64 136.2 64 245.1v153.3c0 36.3 28.6 65.7 64 65.7h64V288h-85.3v-42.9c0-84.7 66.8-153.3 149.3-153.3s149.3 68.5 149.3 153.3V288H320v176h64c35.4 0 64-29.3 64-65.7V245.1C448 136.2 362 48 256 48z"/>
                </svg>
                <h1 class="mx-3 text-white font-semibold text-lg">{{$user->email}}</h1>
                <small class="bg-blue-500 text-slate-200 py-1 px-2 rounded-full" >{{$user->email_verified_at}}</small>
            </div>
            <div class="py-4 px-6">
                <h1 class="text-2xl font-semibold text-gray-800">{{$user->name}}</h1>
                <p class="py-2 text-lg text-gray-700 mb-4 border-b-4"></p>
                <form action="{{route('users.destroy', $user)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="p-2 bg-red-500 hover:bg-red-600 rounded text-white">[trash] Delete User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
