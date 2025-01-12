<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Inertia\Inertia;
use Log;
use function Pest\Laravel\get;
use Illuminate\Support\Facades\Auth;

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

            Log::info('User debug:', ['user' => Auth::user()]);

            $user_role = Auth::user()->role;
            $userId = Auth::id();

            if ($user_role === 0) {
                // Restrict devices to the logged-in user's own devices if they are a customer
                $devices->where('user_id', $userId);
            }
            if($request->searchQuery != ''){
                $searchTerm = "%{$request->searchQuery}%";
            $devices = $devices->where(function ($query) use ($searchTerm) {
                $query->whereHas('user', function ($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', $searchTerm) // Search by name
                                ->orWhere('phone', 'like', $searchTerm);
                })
                        ->orWhere('brand', 'like', $searchTerm)
                        ->orWhere('model_name', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
            });
            }
            // Vérifier si le paramètre `all` est présent
            if ($request->has('all') && $request->all == true) {
                $devices = $devices->with('user')->latest()->get();
            } else {
            $devices = $devices->with('user')->latest()->paginate(5);
            }
            return response()->json([
                'devices' => $devices
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching devices: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching devices'], 500);
        }
    }

    public function create()
    {
        $users = User::getUsersForDropdown();
        //$users = User::all()->pluck('name', 'id');
        //Log::info('Users:', User::all()->toArray());
        //return Inertia::render('Devices/Form', [
        return response()->json([
            'users' => $users,
            'route' => 'device.create'
        ]);
    }

    // public function create()
    // {
    //     $users = User::all()->pluck('name', 'id'); // Récupère les noms et IDs

    //     Log::info('Users:', User::all()->toArray());

    //     return Inertia::render('devices/Form', [
    //         'users' => $users,
    //         'route' => 'devices.create'
    //     ]);
    // }

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
        $users = User::getUsersForDropdown();
        return response()->json([
            'device' => $device,
            'users' => $users,
            'route' => 'devices.edit',
        ], 200);
    }

    // public function edit($id)
    // {
    //     $device = Device::findOrFail($id);
    //     $users = User::all()->pluck('name', 'id'); // Récupère les utilisateurs pour la liste déroulante

    //     return Inertia::render('devices/Form', [
    //         'device' => $device,
    //         'users' => $users,
    //         'route' => 'devices.edit',
    //     ]);
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'brand'=> 'required|string',
            'model_name'=> 'required|string',
            'description'=> 'required|string',
        ]);

        $device = Device::findOrFail($id);

        $users = User::getUsersForDropdown();
        $device->user_id = $request->user_id;
        if ($request->image != $device->image) {
            $strpos = strpos($request->image, ';');
            $sub = substr($request->image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            // Resize and save the image using Intervention
            $img = Image::read($request->image)->resize(200, 200);
            $uploadPath = public_path() . "/upload/";
            if (file_exists($uploadPath)) {
                @unlink($uploadPath);
            }
            $img->save("$uploadPath$name");
            $device->image = $name;
        }
        $device->brand = $request->brand;
        $device->model_name = $request->model_name;
        $device->model_number = $request->model_number;
        $device->serial_number = $request->serial_number;
        $device->imei = $request->imei;
        $device->description = $request->description;
        $device->save();

        return response()->json(['message' => 'Device updated successfully']);
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        if ($device->image != "no-image.jpg") {
            $image_path = public_path() . "/upload/";
            $image = $image_path . $device->image;
            // Vérifie si aucun autre device n'utilise la même image
            $isImageUsedElsewhere = Device::where('image', $device->image)->where('id', '!=', $id)->exists();
            if (!$isImageUsedElsewhere && file_exists($image)) {
                @unlink($image);
            }
        }
        $device->delete();
    }
}
