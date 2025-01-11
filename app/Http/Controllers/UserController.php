<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Inertia\Inertia;
use Log;
use function Pest\Laravel\get;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $users = User::query();
            if($request->searchQuery != ''){
                $searchTerm = "%{$request->searchQuery}%";
            
            // Adding multiple fields for search
            $users = $users->where(function ($query) use ($searchTerm) {
                $query  ->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm)
                        ->orWhere('role', 'like', $searchTerm);
            });
            }
            // Vérifier si le paramètre `all` est présent
            if ($request->has('all') && $request->all == true) {
                $users = $users->latest()->get(); // Récupérer tous les utilisateurs
            } else {
                $users = $users->latest()->paginate(5); // Pagination par défaut
            }

            return response()->json([
                'users' => $users
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching devices: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching devices'], 500);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'role'=> 'required',
        ]);

        $user = new User();

        if ($request->image != "") {
            $strpos = strpos($request->image, ';');
            $sub = substr($request->image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            // Resize and save the image using Intervention
            $img = Image::read($request->image)->resize(200, 200);
            $uploadPath = public_path() . "/upload/";
            $img->save($uploadPath . $name);
            $user->image = $name;
        } else {
            $user->image = "no-image.jpg";
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->save();
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json([
            'user' => $user,
            'route' => 'users.edit',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role'=> 'required',
        ]);

        $user = User::findOrFail($id);
        if ($request->image != $user->image) {
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
            $user->image = $name;
        } else {
            $user->image = $user->image;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

}
