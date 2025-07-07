<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioControllerAPI extends Controller
{
    // Método para listar todos los usuarios de la aplicación
    public function listarTodosUsuarios()
    {
        // Obtener todos los usuarios de la base de datos
        $usuarios = User::all();

        // Retornar una respuesta JSON con la lista de usuarios
        return view('usuarios.usuarios', ['usuarios' => $usuarios]);    }

    // Método para obtener un usuario específico por su ID
    public function obtenerUsuario($id)
    {
        // Buscar al usuario por su ID
        $usuario = User::find($id);

        // Si el usuario no existe, retornar un error 404 con un mensaje
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Retornar una respuesta JSON con los datos del usuario
        return view('usuarios.detalleUsuario', ['usuario' => $usuario]); // Pasar el usuario a la vista
    }
}