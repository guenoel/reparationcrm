<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Device;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Inertia\Inertia;
use Log;
use function Pest\Laravel\get;

class ServiceController extends Controller
{
    // public function index()
    // {
    //     $services = Service::all();

    //     return view('services.index', compact('services'));
    // }

    public function index(Request $request)
    {
        try {
            $services = Service::query();
            if($request->searchQuery != ''){
                $searchTerm = "%{$request->searchQuery}%";
            
            // Adding multiple fields for search
            $services = $services->where(function ($query) use ($searchTerm) {
                $query->whereHas('device', function ($deviceQuery) use ($searchTerm) {
                    $deviceQuery->where('serial_number', 'like', $searchTerm) // Search by serial number
                                ->orWhere('imei', 'like', $searchTerm);
                })
                        ->orWhere('description', 'like', $searchTerm)
                        ->orWhere('price', 'like', $searchTerm);
            });
            }
            $services = $services->whereHas('device')->with(['device', 'device.user'])->latest()->paginate(5);

            return response()->json([
                'services' => $services
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching services: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching services'], 500);
        }
    }

    public function create()
    {
        $devices = Device::getDevicesForDropdown();
        //$devices = Device::all()->pluck('name', 'id');
        //Log::info('Devices:', Device::all()->toArray());
        //return Inertia::render('Services/Form', [
        return response()->json([
            'devices' => $devices,
            'route' => 'service.create'
        ]);
    }

    // public function create()
    // {
    //     $devices = Device::all()->pluck('name', 'id'); // Récupère les noms et IDs

    //     Log::info('Devices:', Device::all()->toArray());

    //     return Inertia::render('services/Form', [
    //         'devices' => $devices,
    //         'route' => 'services.create'
    //     ]);
    // }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'device_id' => 'required|exists:devices,id',
                'description' => 'required|string',
                'price' => 'nullable|numeric',
                'accepted' => 'nullable|boolean',
            ]);
        
            $service = new Service();
            $service->device_id = $validatedData['device_id'];
            $service->description = $validatedData['description'];
            $service->price = $validatedData['price'] ?? null;
            $service->accepted = $validatedData['accepted'] ?? false;
            $service->save();
        
            return response()->json(['message' => 'Service created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating service:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while creating the service'], 500);
        }
        // $request->validate([
        //     'device_id'=> 'required',
        //     'description'=> 'required',
        //     'price'=> 'nullable|numeric',
        //     'accepted'=> 'required|boolean',
        // ]);

        // $service = new Service();

        // $service->device_id = $request->device_id;
        // $service->description = $request->description;
        // $service->price = $request->price;
        // $service->accepted = $request->accepted ?? false;
        // $service->save();
    }

    public function edit($id)
    {
        $service = Service::find($id);
        $devices = Device::getDevicesForDropdown();
        return response()->json([
            'service' => $service,
            'devices' => $devices,
            'route' => 'services.edit',
        ], 200);
    }

    // public function edit($id)
    // {
    //     $service = Service::findOrFail($id);
    //     $devices = Device::all()->pluck('name', 'id'); // Récupère les utilisateurs pour la liste déroulante

    //     return Inertia::render('services/Form', [
    //         'service' => $service,
    //         'devices' => $devices,
    //         'route' => 'services.edit',
    //     ]);
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'device_id'=> 'required|exists:devices,id',
            'description'=> 'required|string',
            'price'=> 'nullable|numeric',
            'accepted'=> 'required|boolean',
        ]);

        $service = Service::findOrFail($id);

        $devices = Device::getDevicesForDropdown();
        Log::info("devices: $devices");
        $service->device_id = $request->device_id;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->accepted = $request->accepted;
        $service->save();

        return response()->json(['message' => 'Service updated successfully']);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if ($service->image != "no-image.jpg") {
            $image_path = public_path() . "/upload/";
            $image = $image_path . $service->image;
            // Vérifie si aucun autre service n'utilise la même image
            $isImageUsedElsewhere = Service::where('image', $service->image)->where('id', '!=', $id)->exists();
            if (!$isImageUsedElsewhere && file_exists($image)) {
                @unlink($image);
            }
        }
        $service->delete();
    }
}
