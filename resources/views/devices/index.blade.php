@extends('layouts.bootstrap_minimal')

@section('content')
<p>
    <form action="{{ route('users.create') }}">
        <button type="submit">Nouvel Utilisateur</button>
    </form>
</p>
<p>
    <form action="{{ route('devices.create') }}">
        <button type="submit">Nouvel Appareil</button>
    </form>
</p>
<table>
@foreach ($devices as $device)
    <tr>
        <td>{{ $device->user_id }}</td>
        <td>{{ $device->brand }}</td>
        <td>{{ $device->model }}</td>
        <td>{{ $device->model_number }}</td>
        <td>{{ $device->serial_number }}</td>
        <td>{{ $device->imei }}</td>
        <td>{{ $device->description }}</td>
        <td>{{ $device->created_at }}</td>
        <td>{{ $device->updated_at }}</td>
        <td><form action="{{ route('devices.edit', $device) }}">
                <button type="submit">Editer</button>
            </form>
        </td>
        <td><form action="{{ route('devices.destroy', $device) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </td>
    </tr>
@endforeach
</table>
@endsection