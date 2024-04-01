<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function store(Request $request)
    {
        // Validar la solicitud de archivo
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Ejemplo de validación
        ]);

        // Guardar el archivo en el sistema de archivos
        $file = $request->file('file');
        $path = $file->store('public'); // Puedes definir tu propio directorio de almacenamiento

        // Crear un registro en la base de datos para el archivo
        $newFile = new File();
        $newFile->name = $file->getClientOriginalName();
        $newFile->path = $path;
        $newFile->type = $file->getMimeType();
        $newFile->size = $file->getSize();
        $newFile->task_id = $request->task_id;
        $newFile->save();

        // Responder con la URL del archivo o algún otro dato relevante
        return response()->json([
            'message' => 'Archivo subido exitosamente',
            'file' => $newFile,
        ], 201);
    }

    /**
     * Mostrar un archivo.
     */
    public function show($id)
    {
        // Encontrar el archivo en la base de datos

        // Devolver el archivo o redirigir si no se encuentra
    }

    /**
     * Descargar un archivo.
     */
    public function download($id)
    {
        // Encontrar el archivo en el sistema de archivos

        // Devolver el archivo para descargar o redirigir si no se encuentra
    }

    /**
     * Eliminar un archivo.
     */
    public function destroy($id)
    {
        // Encontrar el archivo en la base de datos

        // Eliminar el archivo del sistema de archivos

        // Eliminar el registro del archivo de la base de datos

        // Responder con un mensaje de éxito o redirigir
    }
}
