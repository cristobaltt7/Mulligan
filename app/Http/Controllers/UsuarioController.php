<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Deck;
use GuzzleHttp\Client;

class UsuarioController extends Controller
{
    // Método para mostrar el formulario de creación de usuarios
    public function crear()
    {
        return view('usuarios.crear'); // Retorna la vista 'usuarios.crear'
    }

    // Método para guardar un nuevo usuario en la base de datos
    public function guardar(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'username' => 'required|string|max:255', // Nombre de usuario obligatorio
            'email' => 'required|email', // Correo electrónico obligatorio y válido
            'password' => 'required|string|min:6|confirmed', // Contraseña obligatoria y confirmada
        ]);

        // Verificar si el nombre de usuario ya existe en la base de datos
        if (User::where('username', $request->username)->exists()) {
            return redirect()->back()->withErrors(['username' => 'El usuario ya existe.'])->withInput();
        }

        // Verificar si el correo electrónico ya está registrado
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'El correo electrónico ya está registrado.'])->withInput();
        }

        // Crear el usuario con los datos validados
        $user = User::create([
            'username' => $request->username, // Nombre de usuario
            'email' => $request->email, // Correo electrónico
            'password' => bcrypt($request->password), // Contraseña encriptada
            'role' => 'user', // Rol por defecto (usuario normal)
        ]);

        // Autenticar al usuario recién registrado
        Auth::login($user);

        // Redirigir a la página de inicio con un mensaje de éxito
        return redirect('/')->with('success', '¡Registro exitoso! Bienvenido a Mulligan.gg');
    }

    // Método para mostrar el formulario de edición de un usuario
    public function editar($username)
    {
        // Buscar al usuario por su nombre de usuario
        $usuario = User::where('username', $username)->first();

        // Verificar si el usuario autenticado es un administrador o el dueño del perfil
        if (Auth::user()->role !== 'admin' && Auth::id() !== $usuario->id) {
            return redirect()->route('ver.perfil', ['username' => $username])->with('error', 'No tienes permisos para editar este perfil.');
        }

        // Retornar la vista de edición con los datos del usuario
        return view('usuarios.editar', compact('usuario'));
    }

   // Método para actualizar los datos del perfil de un usuario
   public function actualizar(Request $request, $username)
   {
       // Buscar al usuario por su nombre de usuario
       $usuario = User::where('username', $username)->first();
   
       // Verificar si el usuario existe
       if (!$usuario) {
           return redirect()->route('inicio')->with('error', 'Usuario no encontrado.');
       }
   
       // Verificar si el usuario autenticado es un administrador o el dueño del perfil
       if (Auth::user()->role !== 'admin' && Auth::id() !== $usuario->id) {
           return redirect()->route('ver.perfil', ['username' => $username])->with('error', 'No tienes permisos para editar este perfil.');
       }
   
       // Validar los datos del formulario
       $request->validate([
           'username' => 'required|string|max:255|unique:users,username,' . $usuario->id,
           'email' => 'required|email|unique:users,email,' . $usuario->id,
           'password_nueva' => 'nullable|string|min:6|confirmed',
       ]);
   
       // Preparar los datos nuevos para actualizar
       $datosNuevos = [
           'username' => $request->username,
           'email' => $request->email,
       ];
   
       // Si se proporciona una nueva contraseña, encriptarla y agregarla a los datos nuevos
       if ($request->filled('password_nueva')) {
           $datosNuevos['password'] = bcrypt($request->password_nueva);
       }
   
       // Actualizar los datos del usuario
       $usuario->update($datosNuevos);
   
       // Redirigir al perfil con un mensaje de éxito
       return redirect()->route('ver.perfil.publico', ['username' => $usuario->username])->with('success', 'Perfil actualizado correctamente.');   }
    
       // Método para ver el perfil de un usuario y sus mazos
    public function ver($username)
    {
        // Buscar al usuario por su nombre de usuario
        $usuario = User::where('username', $username)->first();

        // Si el usuario no existe, redirigir con un mensaje de error
        if (!$usuario) {
            return redirect()->route('inicio')->with('error', 'Usuario no encontrado.');
        }

        // Obtener los mazos del usuario
        $mazos = Deck::where('owner_id', $usuario->id)->get();

        // Obtener la imagen del comandante para cada mazo
        foreach ($mazos as $mazo) {
            $comandante = $mazo->commander; // Nombre del comandante
            $mazo->imagen_comandante = $this->obtenerImagenComandante($comandante); // Obtener imagen desde la API
        }

        // Retornar la vista con los datos del usuario y sus mazos
        return view('usuarios.ver', compact('usuario', 'mazos'));
    }

    // Método para confirmar la eliminación de un perfil
    public function confirmarEliminar($username)
    {
        // Buscar al usuario por su nombre de usuario
        $usuario = User::where('username', $username)->first();

        // Verificar si el usuario existe
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Usuario no encontrado.');
        }

        // Verificar si el usuario autenticado es un administrador o el dueño del perfil
        if (Auth::user()->role !== 'admin' && Auth::id() !== $usuario->id) {
            return redirect()->route('ver.perfil', ['username' => $username])->with('error', 'No tienes permisos para eliminar este perfil.');
        }

        // Retornar la vista de confirmación de eliminación
        return view('usuarios.eliminar', compact('usuario'));
    }

  // Método para eliminar un perfil de usuario
  public function eliminar($username)
  {
      // Buscar al usuario por su nombre de usuario
      $usuario = User::where('username', $username)->first();
  
      // Verificar si el usuario existe
      if (!$usuario) {
          return redirect()->route('inicio')->with('error', 'Usuario no encontrado.');
      }
  
      // Verificar si el usuario autenticado es un administrador o el dueño del perfil
      if (Auth::user()->role !== 'admin' && Auth::id() !== $usuario->id) {
          return redirect()->route('ver.perfil', ['username' => $username])->with('error', 'No tienes permisos para eliminar este perfil.');
      }
  
      // Eliminar todos los mazos asociados al usuario
      Deck::where('owner_id', $usuario->id)->delete();
  
      // Eliminar el usuario
      $usuario->delete();
  
      // Si el usuario eliminado es el administrador, cerrar sesión
      if (Auth::id() === $usuario->id) {
          Auth::logout();
      }
  
      // Redirigir a la página de inicio con un mensaje de éxito
      return redirect()->route('login')->with('success', 'Perfil eliminado correctamente.');
  }
    // Método privado para obtener la imagen de un comandante desde la API de Scryfall
    private function obtenerImagenComandante($nombreComandante)
    {
        $client = new Client(); // Crear una instancia de Guzzle
        $url = "https://api.scryfall.com/cards/named?exact=" . urlencode($nombreComandante); // URL de la API

        try {
            $response = $client->get($url); // Hacer la solicitud HTTP
            $data = json_decode($response->getBody(), true); // Decodificar la respuesta JSON

            // Retornar la URL de la imagen del comandante (formato art_crop)
            return $data['image_uris']['art_crop'] ?? null;
        } catch (\Exception $e) {
            // Si hay un error, retornar null
            return null;
        }
    }

    // Método para ver el perfil de un usuario (propio o de otro usuario)
    public function verPerfil($username = null)
    {
        // Si no se proporciona un nombre de usuario, se asume que es el perfil del usuario autenticado
        if ($username === null) {
            $usuario = Auth::user();
            $esMiPerfil = true; // Bandera para indicar que es el perfil propio
        } else {
            // Buscar al usuario por su nombre de usuario
            $usuario = User::where('username', $username)->first();

            // Si el usuario no existe, redirigir con un mensaje de error
            if (!$usuario) {
                return redirect()->route('inicio')->with('error', 'Usuario no encontrado.');
            }

            // Verificar si el perfil que se está viendo es del usuario autenticado
            $esMiPerfil = Auth::check() && Auth::user()->id === $usuario->id;
        }

        // Obtener los mazos del usuario
        $mazos = Deck::where('owner_id', $usuario->id)->get();

        // Obtener la imagen del comandante para cada mazo
        foreach ($mazos as $mazo) {
            $comandante = $mazo->commander; // Nombre del comandante
            $mazo->imagen_comandante = $this->obtenerImagenComandante($comandante); // Obtener imagen desde la API
        }

        // Verificar si el usuario autenticado es un administrador
        $esAdmin = Auth::check() && Auth::user()->role === 'admin';

        // Retornar la vista con los datos del usuario, sus mazos y las banderas
        return view('usuarios.ver', compact('usuario', 'mazos', 'esMiPerfil', 'esAdmin'));
    }

    // Método para listar todos los usuarios de la aplicación
    public function listUsers()
    {
        $usuarios = User::all(); // Obtener todos los usuarios
        return view('usuarios.listar', ['usuarios' => $usuarios]); // Retornar la vista con los usuarios
    }

    // Método para gestionar usuarios (solo para administradores)
    public function gestionarUsuarios()
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
        }
        // Verificar si el usuario autenticado es un administrador
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        $usuarios = User::all(); // Obtener todos los usuarios

        // Retornar la vista con los usuarios
        return view('usuarios.listar', compact('usuarios'));
    }
}