<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();

        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $user = User::factory()->create();

        device::create([
            'user_id' => $user->id,
            'brand' => $request->brand,
            'model' => $request->model,
            'model_number' => $request->model_number,
            'serial_number' => $request->serial_number,
            'imei' => $request->imei,
            'description' => $request->description,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ]);

        return to_route('devices.index');
    }

    public function edit(Request $request, Device $device)
    {
        return view('devices.edit', [
            'device' => $device,
        ]);
    }

    public function update(Request $request, Device $device)
    {
        $device->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'model_number' => $request->model_number,
            'serial_number' => $request->serial_number,
            'imei' => $request->imei,
            'description' => $request->description,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ]);

        return to_route('devices.index');
    }

    public function destroy(Device $device)
    {
        $device->delete();

        return to_route('devices.index');
    }
}
