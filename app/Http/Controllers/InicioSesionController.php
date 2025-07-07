<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Asegúrate de importar Hash
use App\Models\User;

class InicioSesionController extends Controller
{
    // Método para mostrar el formulario de inicio de sesión
    public function mostrarFormulario()
    {
        return view('inicioSesion.InicioSesion');
    }

    // Método para procesar el inicio de sesión
    public function iniciarSesion(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Buscar usuario por username
        $user = User::where('username', $credentials['username'])->first();

        // Verificar si el usuario existe y si la contraseña coincide
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Iniciar sesión manualmente
            Auth::login($user);

            // Guardar datos en la sesión
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role
            ]);

            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors('Credenciales incorrectas');
    }

    public function cerrarSesion(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario

        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF

        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }

}
