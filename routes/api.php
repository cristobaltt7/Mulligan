<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeckControllerAPI;
use App\Http\Controllers\UsuarioControllerAPI;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('user/{user_id}/decks', [DeckControllerAPI::class, 'listarMazos'])->whereNumber('user_id');

Route::get('decks/{id}', [DeckControllerAPI::class, 'mostrarMazo'])->whereNumber('id');

Route::post('/decks/add-card', [DeckControllerAPI::class, 'agregarCarta'])->name('add-card');

// Ruta para listar todos los usuarios
Route::get('/usuarios', [UsuarioControllerAPI::class, 'listarTodosUsuarios']);

// Ruta para obtener un usuario por su ID
Route::get('/usuarios/{id}', [UsuarioControllerAPI::class, 'obtenerUsuario']);