<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function getUserTasks($userId)
    {
        $user = User::find($userId);
    
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    
        // Obtener las tareas asignadas al usuario
        $tasks = $user->tareasAsignadas()->with('user:id,name')->get();
    
        return response()->json([ 'tasks' => $tasks], 200);
    }
}
