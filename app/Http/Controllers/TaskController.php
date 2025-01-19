<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Service;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Log;
use function Pest\Laravel\get;

class TaskController extends Controller
{
    // public function index()
    // {
    //     $tasks = Task::all();

    //     return view('tasks.index', compact('tasks'));
    // }

    
    public function index(Request $request)
    {
        try {
            $tasks = task::query();
            if($request->searchQuery != ''){
                $searchTerm = "%{$request->searchQuery}%";
            
            // Adding multiple fields for search
            $tasks = $tasks->where(function ($query) use ($searchTerm) {
                $query->whereHas('service', function ($serviceQuery) use ($searchTerm) {
                    $serviceQuery->where('description', 'like', $searchTerm) // Search by service description
                                ->orWhere('price', 'like', $searchTerm); // Search by service price
                })
                        ->orWhere('start', 'like', $searchTerm)
                        ->orWhere('end', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
            });
            }
            $perPage = $request->input('perPage', 10);
            if ($request->has('all') && $request->all == true) {
                $tasks = $tasks->whereHas('service')->with(['service', 'service.device', 'service.device.user'])->latest()->get();
            } else {
            // ... sinon c'est avec pagination pour l'index.
            $tasks = $tasks->whereHas('service')->with(['service', 'service.device', 'service.device.user', 'user'])->latest()->paginate($perPage);
            }

            return response()->json([
                'tasks' => $tasks
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching tasks: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching tasks'], 500);
        }
    }

    public function create()
    {
        $services = Service::getServicesForDropdown();
        return response()->json([
            'services' => $services,
            'route' => 'task.create'
        ]);
    }

    // public function create()
    // {
    //     $services = Service::all()->pluck('name', 'id'); // Récupère les noms et IDs

    //     Log::info('Services:', Service::all()->toArray());

    //     return Inertia::render('tasks/Form', [
    //         'services' => $services,
    //         'route' => 'tasks.create'
    //     ]);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'service_id'=> 'required',
            'start'=> 'required',
            'end'=> 'required',
            'description'=> 'required',
        ]);

        $task = new Task();

        $task->service_id = $request->service_id;
        $task->user_id = Auth::id();
        if ($request->image != "") {
            $strpos = strpos($request->image, ';');
            $sub = substr($request->image, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            // Resize and save the image using Intervention
            $img = Image::read($request->image)->resize(200, 200);
            $uploadPath = public_path() . "/upload/";
            $img->save($uploadPath . $name);
            $task->image = $name;
        } else {
            $task->image = "no-image.jpg";
        }
        $task->start = $request->start;
        $task->end = $request->end;
        $task->description = $request->description;
        $task->save();
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $services = Service::getServicesForDropdown();
        $users = User::getUsersForDropdown();
        return response()->json([
            'task' => $task,
            'users' => $users,
            'services' => $services,
            'route' => 'tasks.edit',
        ], 200);
    }

    // public function edit($id)
    // {
    //     $task = Task::findOrFail($id);
    //     $services = Service::all()->pluck('name', 'id'); // Récupère les utilisateurs pour la liste déroulante

    //     return Inertia::render('tasks/Form', [
    //         'task' => $task,
    //         'services' => $services,
    //         'route' => 'tasks.edit',
    //     ]);
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id'=> 'required|exists:services,id',
            'user_id'=> 'required|exists:users,id',
            'start'=> 'required|string',
            'end'=> 'required|string',
            'description'=> 'required|string',
        ]);

        $task = Task::findOrFail($id);

        $services = Service::getServicesForDropdown();
        $users = User::getUsersForDropdown();
        Log::info("services: $services");
        Log::info("users: $users");
        $task->service_id = $request->service_id;
        $task->user_id = $request->user_id;
        if ($request->image != $task->image) {
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
            $task->image = $name;
        } else {
            $task->image = $task->image;
        }
        $task->start = $request->start;
        $task->end = $request->end;
        $task->description = $request->description;
        $task->save();

        return response()->json(['message' => 'Task updated successfully']);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if ($task->image != "no-image.jpg") {
            $image_path = public_path() . "/upload/";
            $image = $image_path . $task->image;
            // Vérifie si aucun autre task n'utilise la même image
            $isImageUsedElsewhere = Task::where('image', $task->image)->where('id', '!=', $id)->exists();
            if (!$isImageUsedElsewhere && file_exists($image)) {
                @unlink($image);
            }
        }
        $task->delete();
    }
}
