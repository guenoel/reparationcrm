<table>
@foreach ($devices as $device)
    <tr>
        <td>{{ $device->brand }}</td>
        <td>{{ $device->model }}</td>
        <td>{{ $device->model_number }}</td>
        <td>{{ $device->serial_number }}</td>
        <td>{{ $device->imei }}</td>
        <td>{{ $device->description }}</td>
        <td>{{ $device->created_at }}</td>
        <td>{{ $device->updated_at }}</td>
    </tr>
@endforeach
</table>