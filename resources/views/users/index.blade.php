@extends('layouts.layout')

@section('title', 'All Users')

@section('content')

    <section class="container mx-auto p-6">
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
            <div class="w-full overflow-x-auto">
                <div class="bg-gray-300 p-2 flex justify-end">
                    <a href="{{route('users.create')}}" class="bg-purple-400 p-2 rounded">
                        Create User
                    </a>
                </div>
                <table class="w-full">
                    <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Verified At</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                    </thead>
                        <tbody class="bg-white">
                   @foreach($users as $user)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border">{{$user->id}}</td>
                            <td class="px-4 py-3 border">
                                <div class="flex items-center text-sm">
                                    <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full" src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260" alt="" loading="lazy" />
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-black">{{$user->name}}</p>
                                        <p class="text-xs text-gray-600">{{$user->email}}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ms font-semibold border">{{$user->email}}</td>
                            <td class="px-4 py-3 text-xs border">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">{{$user->email_verified_at}} </span>
                            </td>
                            <td class="px-4 py-3 text-sm border flex flex-col gap-1">
                                <a href="{{route('users.show', $user)}}" class="p-2 bg-green-500 hover:bg-green-600 rounded text-white">[eye] Show User</a>
                                <a href="{{route('users.edit', $user)}}" class="p-2 bg-amber-500 hover:bg-amber-600 rounded text-white">[pen] Edit User</a>
                                <form action="{{route('users.destroy', $user)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="p-2 bg-red-500 hover:bg-red-600 rounded text-white">[trash] Delete User</button>
                                </form>
                            </td>
                        </tr>
                   @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
