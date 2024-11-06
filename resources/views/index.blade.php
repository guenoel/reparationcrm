@extends('app')

@section('content')
    <h1>Accueil</h1>
    <a href="{{ route('devices.create') }}">Nouvel Appareil</a>
@endsection

