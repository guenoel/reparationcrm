<?php

namespace App\Http\Controllers;

use App\Models\SpareType;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Inertia\Inertia;
use Log;
use function Pest\Laravel\get;

class SparetypeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $spare_types = SpareType::query();
            if($request->searchQuery != ''){
                $searchTerm = "%{$request->searchQuery}%";
            
            // Adding multiple fields for search
            $spare_types = $spare_types->where(function ($query) use ($searchTerm) {
                $query  ->where('dealer', 'like', $searchTerm)
                        ->orWhere('type', 'like', $searchTerm)
                        ->orWhere('brand', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm)
                        ->orWhere('buy_price', 'like', $searchTerm)
                        ->orWhere('sell_price', 'like', $searchTerm);
            });
            }
            $spare_types = $spare_types->latest()->paginate(5);

            return response()->json([
                'spare_types' => $spare_types
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching devices: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching devices'], 500);
        }
    }

    public function create()
    {
        return response()->json([
            'route' => 'spare_type.create'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'type'=> 'required|string',
            'description'=> 'required',
        ]);

        $spare_type = new Sparetype();

        if ($request->image != "") {
            $strpos = strpos($request->image, ';');
            $sub = substr($request->image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            // Resize and save the image using Intervention
            $img = Image::read($request->image)->resize(200, 200);
            $uploadPath = public_path() . "/upload/";
            $img->save($uploadPath . $name);
            $spare_type->image = $name;
        } else {
            $spare_type->image = "no-image.jpg";
        }
        $spare_type->dealer = $request->dealer;
        $spare_type->type = $request->type;
        $spare_type->brand = $request->brand;
        $spare_type->description = $request->description;
        $spare_type->buy_price = $request->buy_price;
        $spare_type->sell_price = $request->sell_price;
        $spare_type->save();
    }

    public function edit($id)
    {
        $spare_type = Sparetype::find($id);
        return response()->json([
            'spare_type' => $spare_type,
            'route' => 'spare_types.edit',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type'=> 'required|string',
            'description'=> 'required|string',
        ]);

        $spare_type = Sparetype::findOrFail($id);
        if ($request->image != $spare_type->image) {
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
            $spare_type->image = $name;
        } else {
            $spare_type->image = $spare_type->image;
        }
        $spare_type->dealer = $request->dealer;
        $spare_type->type = $request->type;
        $spare_type->brand = $request->brand;
        $spare_type->description = $request->description;
        $spare_type->buy_price = $request->buy_price;
        $spare_type->sell_price = $request->sell_price;
        $spare_type->save();

        return response()->json(['message' => 'Sparetype updated successfully']);
    }

    public function destroy($id)
    {
        $spare_type = Sparetype::findOrFail($id);
        if ($spare_type->image != "no-image.jpg") {
            $image_path = public_path() . "/upload/";
            $image = $image_path . $spare_type->image;
            // Vérifie si aucun autre spare_type n'utilise la même image
            $isImageUsedElsewhere = Sparetype::where('image', $spare_type->image)->where('id', '!=', $id)->exists();
            if (!$isImageUsedElsewhere && file_exists($image)) {
                @unlink($image);
            }
        }
        $spare_type->delete();
    }
}
