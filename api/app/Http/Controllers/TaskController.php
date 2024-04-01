<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        //
        $tasks = Task::select('tasks.*', 'users.name as user_name')
            ->leftJoin('users', 'tasks.user_id', '=', 'users.id')
            ->get();
        return $tasks;
    }

    public function getUserTasks($userId)
    {
        // Obtener las tareas del usuario con el  ID proporcionado
        $tasks = Task::where('user_id', $userId)
                 ->with('user:id,name') // Cargar ansiosamente el usuario con solo el nombre
                 ->get();

        return response()->json($tasks); 
    }


    public function store(Request $request)
    {
        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

     public function show($id)
    {
        $task = Task::with('user:id,name')->find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        
        return $task;
    }

    public function update(Request $request, string $id)
    {
        //
        // Buscar la tarea por su ID
        $task = Task::find($id);

        // Verificar si la tarea existe
        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        // Actualizar los campos de la tarea con los datos de la solicitud
        $task->update($request->all());

        // Responder con la tarea actualizada
        return response()->json(['message' => 'Tarea actualizada correctamente', 'task' => $task], 200);
    }

  
    public function destroy(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        try {
            $task->delete();
            return response()->json(['message' => 'Tarea eliminada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la tarea'], 500);
        }
    }
}
