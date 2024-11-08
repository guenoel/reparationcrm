@extends('layouts.bootstrap_minimal')

@section('content')
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label for="name">Nom:</label>
        <input type="text" name="name">
        <label for="name">Email:</label>
        <input type="text" name="email">
        <label for="name">Mot de passe:</label>
        <input type="text" name="password">
        <label for="name">Token (?):</label>
        <input type="text" name="remember_token">

        <button type="submit">Créer</button>
    </form>
    
@endsection