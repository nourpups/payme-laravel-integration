<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());

        return to_route('users.index')->with('flash', [
            'class' => 'green-300',
            'message' => "User $user[name] created successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
//        $user = Cache::get("posts:$user->id");
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user->update($data);

        return to_route('users.index')->with('flash', [
           'class' => 'green-300',
           'message' => "$user->name updated succesfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('users.index')->with('flash', [
            'class' => 'amber-300',
            'message' => "$user->name deleted"
        ]);
    }
}
