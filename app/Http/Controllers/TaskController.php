<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Service;
use App\Models\Spare;
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
            $tasks = Task::query();
    
            $user_role = Auth::user()->role;
            $userId = Auth::id();
    
            // Filtrer pour les clients (role = 0)
            if ($user_role === 0) {
                $tasks->whereHas('service.device', function ($deviceQuery) use ($userId) {
                    $deviceQuery->where('user_id', $userId);
                });
            }
    
            // Recherche
            if ($request->searchQuery != '') {
                $searchTerm = "%{$request->searchQuery}%";
    
                $tasks->where(function ($query) use ($searchTerm) {
                    $query->whereHas('service.device.user', function ($userQuery) use ($searchTerm) {
                            $userQuery->where('name', 'like', $searchTerm); // Recherche par nom de client
                        })
                        ->orWhereHas('service', function ($serviceQuery) use ($searchTerm) {
                            $serviceQuery->where('description', 'like', $searchTerm); // Recherche par description de service
                        })
                        ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                            $userQuery->where('name', 'like', $searchTerm); // Recherche par nom du technicien
                        })
                        ->orWhereRaw('DATE_FORMAT(start, "%d/%m/%Y") like ?', ["%$searchTerm%"]) // Recherche par date (format d/m/Y)
                        ->orWhereRaw('TIME_FORMAT(start, "%H:%i:%s") like ?', ["%$searchTerm%"]) // Recherche par heure
                        ->orWhereRaw('DATE_FORMAT(end, "%d/%m/%Y") like ?', ["%$searchTerm%"]) // Recherche par date de fin
                        ->orWhereRaw('TIME_FORMAT(end, "%H:%i:%s") like ?', ["%$searchTerm%"]) // Recherche par heure de fin
                        ->orWhere('description', 'like', $searchTerm); // Recherche par description de tâche
                });
            }
    
            $perPage = $request->input('perPage', 10);
    
            // Pagination ou récupération complète
            if ($request->has('all') && $request->all == true) {
                $tasks = $tasks->whereHas('service')->with(['service', 'service.device', 'service.device.user'])->latest()->get();
            } else {
                $tasks = $tasks->whereHas('service')->with(['service', 'service.device', 'service.device.user', 'user'])->latest()->paginate($perPage);
            }
    
            // Ajout du formatage date et heure pour chaque tâche
            if ($tasks instanceof \Illuminate\Pagination\AbstractPaginator) {
                $tasks->getCollection()->transform(function ($task) {
                    $task->formatted_start_date = $task->start ? \Carbon\Carbon::parse($task->start)->format('d/m/Y') : null; // Format de la date de début
                    $task->formatted_start_time = $task->start ? \Carbon\Carbon::parse($task->start)->format('H:i:s') : null; // Format de l'heure de début
                    $task->formatted_end_date = $task->end ? \Carbon\Carbon::parse($task->end)->format('d/m/Y') : null; // Format de la date de fin
                    $task->formatted_end_time = $task->end ? \Carbon\Carbon::parse($task->end)->format('H:i:s') : null; // Format de l'heure de fin
                    return $task;
                });
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
            'service_id' => 'required|exists:services,id',
            'spare_ids' => 'array',
            'spare_ids.*' => 'exists:spares,id',
            'start' => 'required|date',
            'end' => 'required|date',
            'description' => 'required|string',
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

        // Vérifier que les spares appartiennent au service_id
        if ($request->has('spare_ids')) {
            Spare::whereIn('id', $request->spare_ids)
                ->where('service_id', $request->service_id)
                ->update(['task_id' => $task->id]);
        }

        return response()->json(['message' => 'Task created successfully'], 201);
    }

    public function edit($id)
    {
        $task = Task::with('spares')->findOrFail($id);
        $services = Service::getServicesForDropdown();
        $users = User::getUsersForDropdown();
        $spares = Spare::where('service_id', $task->service_id)->get();

        return response()->json([
            'task' => $task,
            'users' => $users,
            'spares' => $spares,
            'services' => $services,
            'spare_ids' => $task->spares->pluck('id'),
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
            'service_id' => 'required|exists:services,id',
            'spare_ids' => 'array',
            'spare_ids.*' => 'exists:spares,id',
            'start' => 'required|date',
            'end' => 'required|date',
            'description' => 'required|string',
        ]);

        $task = Task::findOrFail($id);

        $services = Service::getServicesForDropdown();
        $users = User::getUsersForDropdown();
        Log::info("services: $services");
        Log::info("users: $users");
        $task->service_id = $request->service_id;
        $task->user_id = $request->user_id;
        if ($request->has('image') && $request->image != "") {
            $strpos = strpos($request->image, ';'); // Chercher le caractère `;`
            if ($strpos !== false) {
                $sub = substr($request->image, 0, $strpos); // Extraire la partie avant le `;`
                $parts = explode('/', $sub); // Découper en utilisant `/` comme séparateur
                if (isset($parts[1])) {
                    $ex = $parts[1]; // Récupérer le deuxième élément (extension)
                    $name = time() . "." . $ex; // Générer le nom du fichier
                    // Redimensionner et enregistrer l'image
                    $img = Image::make($request->image)->resize(200, 200);
                    $uploadPath = public_path() . "/upload/";
        
                    // Supprimer l'ancienne image si elle existe
                    $currentImagePath = $uploadPath . $task->image;
                    if (file_exists($currentImagePath) && $task->image != "no-image.jpg") {
                        @unlink($currentImagePath);
                    }
        
                    $img->save($uploadPath . $name);
                    $task->image = $name; // Assigner la nouvelle image à la tâche
                } else {
                    Log::error("Invalid image format in request: $sub");
                    return response()->json(['error' => 'Invalid image format'], 422); // Erreur pour format non valide
                }
            } else {
                Log::error("Missing ';' in image string: {$request->image}");
                return response()->json(['error' => 'Invalid image format'], 422); // Erreur pour absence de `;`
            }
        } else {
            $task->image = $task->image; // Conserver l'image actuelle si aucune modification
        }
        $task->start = $request->start;
        $task->end = $request->end;
        $task->description = $request->description;
        $task->save();

        // Réassigner les spares uniquement s'ils appartiennent au service_id
        Spare::where('task_id', $task->id)->update(['task_id' => null]); // Supprime les anciennes associations
        if ($request->has('spare_ids')) {
            Spare::whereIn('id', $request->spare_ids)
                ->where('service_id', $request->service_id)
                ->update(['task_id' => $task->id]);
        }
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
