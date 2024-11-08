<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = User::factory()->create();

        user::create([
            'name' => $user->name,
            'email' => $request->email,
            'password' => $request->password,
            'remember_token' => $request->remember_token,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ]);

        return to_route('users.index');
    }

    public function edit(Request $request, User $user)
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'remember_token' => $request->remember_token,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ]);

        return to_route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('users.index');
    }
}
