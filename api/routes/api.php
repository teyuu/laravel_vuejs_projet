<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    //Users
    Route::get('/users', [UserController::class, 'index']);
   
    //Tareas
    Route::resource('tasks', TaskController::class)->parameters([
        'tasks' => 'id'
    ]);
    Route::get('/tasks/user/{user_id}', [TaskController::class, 'getUserTasks']);
        

    

    //Files
    Route::resource('files', TaskController::class);

     //Files
     Route::resource('comments', CommentController::class);
});


