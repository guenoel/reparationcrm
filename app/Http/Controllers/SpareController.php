<?php

namespace App\Http\Controllers;

use \App\Models\SpareType;
use App\Models\Spare;
use App\Models\Service;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Inertia\Inertia;
use Log;
use function Pest\Laravel\get;

class SpareController extends Controller
{
    // public function index()
    // {
    //     $spares = Spare::all();

    //     return view('spares.index', compact('spares'));
    // }

    public function index(Request $request)
    {
        try {
            $spares = Spare::query();
            if($request->searchQuery != ''){
                $searchTerm = "%{$request->searchQuery}%";
            
            // Adding multiple fields for search
            $spares = $spares->where(function ($query) use ($searchTerm) {
                $query  ->WhereHas('service', function ($serviceQuery) use ($searchTerm) {
                    $serviceQuery->where('name', 'like', $searchTerm); // Recherche sur le nom de l'utilisateur
                })
                        ->orwhere('purchase_date', 'like', $searchTerm)
                        ->orWhere('reception_date', 'like', $searchTerm)
                        ->orWhere('return_date', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
            });
            }
            // Vérifier si le paramètre `all` est présent
            if ($request->has('all') && $request->all == true) {
                $spares = $spares->whereHas('service')->with('service')->latest()->get();
            } else {
            $spares = $spares->whereHas('service')->with('service')->latest()->paginate(5);
            }

            return response()->json([
                'spares' => $spares
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching spares: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching spares'], 500);
        }
    }

    public function create()
    {
        $services = Service::getServicesForDropdown();
        $spare_types = SpareType::getSparetypesForDropdown();
        //$services = Service::all()->pluck('name', 'id');
        //Log::info('Services:', Service::all()->toArray());
        //return Inertia::render('Spares/Form', [
        return response()->json([
            'spare_types' => $spare_types,
            'services' => $services,
            'route' => 'spare.create'
        ]);
    }

    // public function create()
    // {
    //     $services = Service::all()->pluck('name', 'id'); // Récupère les noms et IDs

    //     Log::info('Services:', Service::all()->toArray());

    //     return Inertia::render('spares/Form', [
    //         'services' => $services,
    //         'route' => 'spares.create'
    //     ]);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'service_id'=> 'required',
            'spare_type_id'=> 'required',
            'description'=> 'required',
        ]);

        $spare = new Spare();

        $spare->service_id = $request->service_id;
        $spare->spare_type_id = $request->spare_type_id;
        if ($request->image != "") {
            $strpos = strpos($request->image, ';');
            $sub = substr($request->image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            // Resize and save the image using Intervention
            $img = Image::read($request->image)->resize(200, 200);
            $uploadPath = public_path() . "/upload/";
            $img->save($uploadPath . $name);
            $spare->image = $name;
        } else {
            $spare->image = "no-image.jpg";
        }
        $spare->description = $request->description;
        $spare->purchase_date = $request->purchase_date;
        $spare->reception_date = $request->reception_date;
        $spare->return_date = $request->return_date;
        $spare->save();
    }

    public function edit($id)
    {
        $spare = Spare::find($id);
        $services = Service::getServicesForDropdown();
        $spare_types = SpareType::getSparetypesForDropdown();
        return response()->json([
            'spare' => $spare,
            'spare_types' => $spare_types,
            'services' => $services,
            'route' => 'spares.edit',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id'=> 'required|exists:services,id',
            'spare_type_id'=> 'required|exists:spare_types,id',
            'description'=> 'required|string',
        ]);

        $spare = Spare::findOrFail($id);

        $services = Service::getServicesForDropdown();
        $spare_types = SpareType::getSparetypesForDropdown();
        Log::info("services: $services");
        Log::info("spare_types: $spare_types");

        $spare->service_id = $request->service_id;
        $spare->spare_type_id = $request->spare_type_id;
        if ($request->image != $spare->image) {
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
            $spare->image = $name;
        } else {
            $spare->image = $spare->image;
        }
        $spare->purchase_date = $request->purchase_date;
        $spare->reception_date = $request->reception_date;
        $spare->return_date = $request->return_date;
        $spare->description = $request->description;
        $spare->save();

        return response()->json(['message' => 'Spare updated successfully']);
    }

    public function destroy($id)
    {
        $spare = Spare::findOrFail($id);
        if ($spare->image != "no-image.jpg") {
            $image_path = public_path() . "/upload/";
            $image = $image_path . $spare->image;
            // Vérifie si aucun autre spare n'utilise la même image
            $isImageUsedElsewhere = Spare::where('image', $spare->image)->where('id', '!=', $id)->exists();
            if (!$isImageUsedElsewhere && file_exists($image)) {
                @unlink($image);
            }
        }
        $spare->delete();
    }
}
