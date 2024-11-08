@extends('layouts.bootstrap_minimal')

@section('content')
    <form action="{{ route('devices.store') }}" method="POST">
        @csrf
        <label for="name">User id:</label>
        <input type="text" name="user_id">
        <label for="name">Marque:</label>
        <input type="text" name="brand">
        <label for="name">Modèle:</label>
        <input type="text" name="model">
        <label for="name">No de Modèle:</label>
        <input type="text" name="model_number">
        <label for="name">No de série:</label>
        <input type="text" name="serial_number">
        <label for="name">imei:</label>
        <input type="text" name="imei">
        <label for="name">Description:</label>
        <input type="text" name="description">
        <label for="name">créé le:</label>
        <input type="text" name="created_at">
        <label for="name">modifié le:</label>
        <input type="text" name="updated_at">
        <button type="submit">Créer</button>
    </form>
    
@endsection