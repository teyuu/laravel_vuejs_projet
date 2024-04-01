<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;
use App\Models\User;
use App\Models\Comment;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id'
    ];


    // Relación con la tabla usuarios (Tarea pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fileAsignado()
    {
        return $this->hasMany(File::class, 'task_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comment::class, 'task_id');
    }
}
