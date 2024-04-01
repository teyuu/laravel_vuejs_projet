<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // ID del usuario que hizo el comentario
        'task_id', // ID de la tarea asociada al comentario
        'comment', // Contenido del comentario
    ];


    // Relación con el modelo de Tarea (tarea asociada al comentario)
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
