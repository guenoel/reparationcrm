<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Log;
use function Pest\Laravel\get;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $users = User::query();

            $user_role = Auth::user()->role;
            $userId = Auth::id();

            if ($user_role === 1 && $request->has('all') && $request->all == true) {
                // Restrict devices to the logged-in user's own devices if they are a customer
                $users->where('id', $userId);
            }
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
            // Vérifier si le paramètre `all` est présent pour la création
            if ($request->has('all') && $request->all == true) {
                $users = $users->latest()->get(); // Récupérer tous les utilisateurs
            } else {
            // ... sinon c'est avec pagination pour l'index.
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

    public function new_form(Request $request)
    {
        try {
            $user_role = Auth::user()->role;
            $userId = Auth::id();

            if ($user_role === 0) {
                // Restrict users to the logged-in user's if they are a customer
                $users = User::where('id', $userId)->get();
                Log::info('User debug:', ['user' => Auth::user()]);
            } else if ($user_role === 1) {
                if ($request->has('task_form') && $request->task_form == true){
                    $users = User::where('role', '>', 0)->get();
                } else {
                    $users = User::query();
                    $users = $users->latest()->get();
                }
            } else {
                $users = User::query();
                $users = $users->latest()->get();
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
