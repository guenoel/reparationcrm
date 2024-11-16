<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use function Pest\Laravel\get;

class DeviceController extends Controller
{
    // public function index()
    // {
    //     $devices = Device::all();

    //     return view('devices.index', compact('devices'));
    // }

    public function index(Request $request)
    {
        try {
            $devices = Device::query();
            if($request->searchQuery != ''){
                $searchTerm = "%{$request->searchQuery}%";
            
            // Adding multiple fields for search
            $devices = $devices->where(function ($query) use ($searchTerm) {
                $query->where('brand', 'like', $searchTerm)
                        ->orWhere('model_name', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
            });
            }
            $devices = $devices->latest()->paginate(5);

            return response()->json([
                'devices' => $devices
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching devices: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching devices'], 500);
        }
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'=> 'required',
            'brand'=> 'required',
            'model_name'=> 'required',
            'description'=> 'required',
        ]);

        $device = new Device();

        $device->user_id = $request->user_id;
        if ($request->image != "") {
            $strpos = strpos($request->image, ';');
            $sub = substr($request->image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            // Resize and save the image using Intervention
            $img = Image::read($request->image)->resize(200, 200);
            $uploadPath = public_path() . "/upload/";
            $img->save($uploadPath . $name);
            $device->image = $name;
        } else {
            $device->image = "no-image.jpg";
        }
        $device->brand = $request->brand;
        $device->model_name = $request->model_name;
        $device->model_number = $request->model_number;
        $device->serial_number = $request->serial_number;
        $device->imei = $request->imei;
        $device->description = $request->description;
        $device->save();
    }

    public function edit($id)
    {
        $device = Device::find($id);
        return response()->json([
            'device' => $device
        ], 200);
    }

    public function update(Request $request, Device $id)
    {
        $request->validate([
            'user_id'=> 'required',
            'brand'=> 'required',
            'model_name'=> 'required',
            'description'=> 'required',
        ]);

        $device = Device::find($id);

        $device->user_id = $request->user_id;
        if ($request->image != $device->image) {
            $strpos = strpos($request->image, ';');
            $sub = substr($request->image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            // Resize and save the image using Intervention
            $img = Image::read($request->image)->resize(200, 200);
            $uploadPath = public_path() . "/upload/";
            $image = $upload_path = public_path() . "/upload/";
            if (file_exists($image)) {
                @unlink($image);
            }
            $img->save($uploadPath . $name);
            $device->image = $name;
        } else {
            $device->image = $device->image;
        }
        $device->brand = $request->brand;
        $device->model_name = $request->model_name;
        $device->model_number = $request->model_number;
        $device->serial_number = $request->serial_number;
        $device->imei = $request->imei;
        $device->description = $request->description;
        $device->save();
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        if ($device->image != "no-image.jpg") {
            $image_path = public_path() . "/upload/";
            $image = $image_path . $device->image;
            if (file_exists($image)) {
                @unlink($image);
            }
        }
        $device->delete();
    }
}
