<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    
    public function index()
    {
        // Obtener todos los comentarios
        $comentarios = Comment::all();

        // Retornar los comentarios en formato JSON
        return response()->json($comentarios);
    }

    public function store(Request $request)
    {
        // Crear el comentario
        $comentario = Comment::create($request->all());

        // Retornar el comentario creado
        return response()->json($comentario, 201);
    }

    public function show(string $id)
    {

        $comentarios = Comment::where('task_id', $id)
            ->with('user')
            ->with('task')
            ->get();

   
        $comentariosConNombreUsuario = $comentarios->map(function ($comentario) {
            return [
                'id' => $comentario->id,
                'comment' => $comentario->comment,
                'user_name' => $comentario->user->name, 
                'user_id'=> $comentario->user->id, 
                'task_id'=>$comentario->task->id, 
            ];
        });

        // Retornar los comentarios con el nombre del usuario
        return response()->json($comentariosConNombreUsuario);
    }

    public function update(Request $request, string $id)
    {
        //
        // Buscar la tarea por su ID
        $comentario = Comment::find($id);

        // Verificar si la tarea existe
        if (!$comentario) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        // Actualizar los campos de la tarea con los datos de la solicitud
        $comentario->update($request->all());

        // Responder con la tarea actualizada
        return response()->json(['message' => 'Tarea actualizada correctamente', 'task' => $comentario], 200);
    }

    public function destroy(string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        try {
            $comment->delete();
            return response()->json(['message' => 'Tarea eliminada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la tarea'], 500);
        }
    }
    
}
