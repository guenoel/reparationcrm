@extends('layouts.bootstrap_minimal')

@section('content')
<table>
@foreach ($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->password }}</td>
        <td>{{ $user->remember_token }}</td>
        <td>{{ $user->created_at }}</td>
        <td>{{ $user->updated_at }}</td>
        <td><form action="{{ route('users.edit', $user) }}">
                <button type="submit">Editer</button>
            </form>
        </td>
        <td><form action="{{ route('users.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </td>
    </tr>
@endforeach
</table>
@endsection