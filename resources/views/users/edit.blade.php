@extends('layouts.bootstrap_minimal')

@section('content')
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $user->name }}">
        <input type="text" name="email" value="{{ $user->email }}">
        <input type="text" name="password" value="{{ $user->password }}">
        <input type="text" name="remember_token" value="{{ $user->remember_token }}">
        <input type="text" name="created_at" value="{{ $user->created_at }}">
        <input type="text" name="updated_at" value="{{ $user->updated_at }}">
        <button type="submit">Editer</button>
        <button type="submit">Supprimer</button>
    </form>
@endsection