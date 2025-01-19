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
            $perPage = $request->input('perPage', 10);
            if ($request->has('all') && $request->all == true) {
                $services = $services->whereHas('device')->with(['device', 'device.user'])->latest()->get();
            } else {
            // ... sinon c'est avec pagination pour l'index.
            $services = $services->whereHas('device')->with(['device', 'device.user'])->latest()->paginate($perPage);
            }
            return response()->json([
                'services' => $services
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching services: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching services'], 500);
        }
    }

    // TODO: vérifier cette fonction - le user name et brand, model du device
    public function create(Request $request)
    {
        try {
            $device_id = $request->query('device_id');
    
            if ($device_id) {
                // Charger les informations du device spécifique
                $device = Device::with('user') // Charger l'utilisateur associé
                    ->select('id', 'brand', 'model_name', 'user_id') // Limiter les colonnes chargées
                    ->where('id', $device_id)
                    ->first();
    
                if (!$device) {
                    return response()->json([
                        'error' => 'Device not found'
                    ], 404);
                }
    
                return response()->json([
                    'device' => $device, // Device spécifique
                    'devices' => null, // Pas de liste dropdown nécessaire
                    'route' => 'service.create'
                ], 200);
            }
    
            // Si aucun device_id, retourner tous les appareils pour une liste déroulante
            $devices = Device::getDevicesForDropdown();
    
            return response()->json([
                'device' => null, // Pas de device spécifique
                'devices' => $devices, // Liste des appareils
                'route' => 'service.create'
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('Error in service creation:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'An error occurred while preparing the service creation'
            ], 500);
        }
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
                'accepted' => 'nullable|boolean',
                'deposit' => 'nullable|numeric',
                'deposit_paid' => 'nullable|boolean',
                'price' => 'nullable|numeric',
                'price_paid' => 'nullable|boolean',
                'done' => 'nullable|boolean',
            ]);
        
            $service = new Service();
            $service->device_id = $validatedData['device_id'];
            $service->description = $validatedData['description'];
            $service->accepted = $validatedData['accepted'] ?? false;
            $service->deposit = $validatedData['deposit'] ?? null;
            $service->deposit_paid = $validatedData['deposit_paid'] ?? false;
            $service->price = $validatedData['price'] ?? null;
            $service->price_paid = $validatedData['price_paid'] ?? false;
            $service->done = $validatedData['done'] ?? false;
            $service->save();

            $device = $service->device; // Relation entre Service et Device
            if ($device) {
                $device->returned = $service->done; // Mettre à jour en fonction de la valeur de "done"
                $device->save();
            }
        
            return response()->json(['message' => 'Service created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating service:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while creating the service'], 500);
        }
    }

    public function edit($id)
    {
        // $service = Service::find($id);
        $service = Service::with('device.user')->findOrFail($id);
        //TODO: pour l edition pas besoin de charger tous les devices
        //$devices = Device::getDevicesForDropdown();
        return response()->json([
            'service' => $service,
            'returned' => $service->device ? $service->device->returned : null, // Inclure "returned" si le device existe
            //'devices' => $devices,
            'route' => 'services.edit',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'device_id'=> 'required|exists:devices,id',
            'description'=> 'required|string',
            'accepted'=> 'required|boolean',
            'deposit'=> 'nullable|numeric',
            'deposit_paid'=> 'required|boolean',
            'price'=> 'nullable|numeric',
            'price_paid'=> 'required|boolean',
            'done'=> 'required|boolean',
        ]);

        $service = Service::findOrFail($id);

        $devices = Device::getDevicesForDropdown();
        Log::info("devices: $devices");
        $service->device_id = $request->device_id;
        $service->description = $request->description;
        $service->accepted = $request->accepted;
        $service->deposit = $request->deposit;
        $service->deposit_paid = $request->deposit_paid;
        $service->price = $request->price;
        $service->price_paid = $request->price_paid;
        $service->done = $request->done;
        $service->save();

        // Mise à jour de la valeur "returned" du device associé
        $device = $service->device; // Relation entre Service et Device
        if ($device) {
            $device->returned = $request->done; // "returned" est mis à jour avec la valeur de "done"
            $device->save(); // Enregistrer les modifications sur le device
        }

        return response()->json(['message' => 'Service updated successfully']);
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            // if ($service->image != "no-image.jpg") {
            //     $image_path = public_path() . "/upload/";
            //     $image = $image_path . $service->image;
            //     // Vérifie si aucun autre service n'utilise la même image
            //     $isImageUsedElsewhere = Service::where('image', $service->image)->where('id', '!=', $id)->exists();
            //     if (!$isImageUsedElsewhere && file_exists($image)) {
            //         @unlink($image);
            //     }
            // }

            // Supprimer les dépendances éventuelles si elles n'ont pas déjà été supprimées
            // $service->spares()->delete(); // Exemple pour supprimer les spares liés
            // $service->tasks()->delete();  // Exemple pour supprimer les tasks liés
            $service->delete();
            return response()->json(['message' => 'Service deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting service:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while deleting the service'], 500);
        }
    }
}
