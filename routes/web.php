<?php

use App\Http\Controllers\DeckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\InicioSesionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;


// Listar los mazos del usuario
Route::get('decks', [DeckController::class, 'index'])->name('decks.all');

// Ver un mazo
Route::get('decks/{deck}/view', [DeckController::class, 'show'])->name('viewDeck')->whereNumber('deck');

// Listar mazos de un usuario
Route::get('user/{deck}/decks', [DeckController::class, 'indexUser'])->name('decksUser')->whereNumber('deck');

// Ver un mazo
Route::get('decks/{deck}/view', [DeckController::class, 'show'])->name('decks.show')->whereNumber('deck');

// Crear nuevo mazo
Route::get('decks/create', [DeckController::class, 'create'])->name('decks.create');
Route::post('decks/store', [DeckController::class, 'store'])->name('storeDeck');

// Editar un mazo
Route::get('decks/{deck}/edit', [DeckController::class, 'edit'])->name('decks.edit')->whereNumber('deck');
Route::post('decks/{deck}/update', [DeckController::class, 'update'])->name('decks.update')->whereNumber('deck');

// Eliminar un mazo
Route::delete('decks/{deck}/destroyconfirm', [DeckController::class, 'destroyconfirm'])->name('decks.destroy')->whereNumber('deck');
Route::post('decks/{deck}/destroy', [DeckController::class, 'destroy'])->whereNumber('deck');

Route::get('/', [BuscadorController::class, 'searchForm'])->name('buscar');
Route::get('/buscar/resultados', [BuscadorController::class, 'search'])->name('buscarResultados');
Route::get('/carta/{nombre}', [BuscadorController::class, 'verCarta'])->name('verCarta');
Route::get('/carta-aleatoria', [BuscadorController::class, 'cartaAleatoria'])->name('cartaAleatoria');

// --------------------------
// Rutas de autenticación
// --------------------------

Route::get('/login', [InicioSesionController::class, 'mostrarFormulario'])->name('login');
Route::post('/login', [InicioSesionController::class, 'iniciarSesion'])->name('iniciarSesion');
Route::post('/logout', [InicioSesionController::class, 'cerrarSesion'])->name('logout');

// --------------------------
// Rutas de perfil de usuario
// --------------------------

// Crear y guardar perfil de usuario
Route::get('/crear-perfil', [UsuarioController::class, 'crear'])->name('crear.perfil');
Route::post('/guardar-usuario', [UsuarioController::class, 'guardar'])->name('guardar.usuario');

// Editar perfil de usuario
Route::get('/editar-perfil', [UsuarioController::class, 'editar'])->name('editar.perfil');
Route::post('/editar-perfil', [UsuarioController::class, 'actualizar']);

// Ver el perfil del usuario autenticado
Route::get('/ver-perfil', [UsuarioController::class, 'verPerfil'])->name('ver.perfil')->middleware('auth');

// Confirmar eliminación del perfil
Route::get('/eliminar-perfil', [UsuarioController::class, 'confirmarEliminar'])->name('confirmar.eliminar.perfil');
Route::delete('/eliminar-perfil', [UsuarioController::class, 'eliminar'])->name('eliminar.perfil');

// Ver el perfil de otro usuario
Route::get('/ver-perfil/{username}', [UsuarioController::class, 'verPerfil'])->name('ver.perfil.publico');

// Ruta para editar el perfil de un usuario
Route::get('/editar-perfil/{username}', [UsuarioController::class, 'editar'])->name('editar.perfil');

// Ruta para procesar la actualización del perfil (PUT)
Route::put('/editar-perfil/{username}', [UsuarioController::class, 'actualizar'])->name('actualizar.perfil');
// Ruta para eliminar el perfil de un usuario
Route::delete('/eliminar-perfil/{username}', [UsuarioController::class, 'eliminar'])->name('eliminar.perfil');

// Ruta para actualizar un mazo
Route::put('/decks/{deck}/update', [DeckController::class, 'update'])->name('decks.update');

// Ruta para eliminar un mazo
Route::delete('/decks/{deck}/destroy', [DeckController::class, 'destroy'])->name('decks.destroy');

// Ruta para procesar la eliminación (DELETE)
Route::get('/eliminar-perfil/{username}', [UsuarioController::class, 'confirmarEliminar'])->name('confirmar.eliminar.perfil');
Route::delete('/eliminar-perfil/{username}', [UsuarioController::class, 'eliminar'])->name('eliminar.perfil');

// Mostrar la vista de confirmación antes de eliminar un mazo
Route::get('decks/{deck}/delete/confirm', [DeckController::class, 'destroyConfirm'])->name('decks.delete.confirm')->whereNumber('deck');

// Mostrar la vista de confirmación antes de eliminar un mazo
Route::get('decks/{deck}/delete/confirm', [DeckController::class, 'showDeleteConfirmation'])->name('decks.delete.confirm')->whereNumber('deck');

// Ruta para manejar la confirmación de eliminación
Route::post('decks/{deck}/destroy/confirm', [DeckController::class, 'destroyConfirm'])->name('decks.destroy.confirm')->whereNumber('deck');

// Ruta para eliminar el mazo (DELETE)
Route::delete('decks/{deck}/destroy', [DeckController::class, 'destroy'])->name('decks.destroy')->whereNumber('deck');

// Mostrar la lista de usuarios para su gestion
Route::get('usuarios/gestionar', [UsuarioController::class, 'listUsers'])->name('mostrarUsuarios');

// Ruta para gestionar usuarios (solo para administradores)
Route::get('/usuarios/gestionar', [UsuarioController::class, 'gestionarUsuarios'])->name('gestionar.usuarios');

// Ruta para procesar la actualización del perfil (PUT)
Route::put('/editar-perfil/{username}', [UsuarioController::class, 'actualizar'])->name('actualizar.perfil');

// Ruta para eliminar el perfil de un usuario
Route::delete('/eliminar-perfil/{username}', [UsuarioController::class, 'eliminar'])->name('eliminar.perfil');

// Ruta pública para ver perfiles de otros usuarios
Route::get('/ver-perfil/{username}', [UsuarioController::class, 'verPerfil'])->name('ver.perfil.publico');