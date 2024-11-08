@extends('layouts.bootstrap_minimal')

@section('content')
    <form action="{{ route('devices.update', $device) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="brand" value="{{ $device->brand }}">
        <input type="text" name="model" value="{{ $device->model }}">
        <input type="text" name="model_number" value="{{ $device->model_number }}">
        <input type="text" name="serial_number" value="{{ $device->serial_number }}">
        <input type="text" name="imei" value="{{ $device->imei }}">
        <input type="text" name="description" value="{{ $device->description }}">
        <input type="text" name="created_at" value="{{ $device->created_at }}">
        <input type="text" name="updated_at" value="{{ $device->updated_at }}">
        <button type="submit">Editer</button>
        <button type="submit">Supprimer</button>
    </form>
@endsection