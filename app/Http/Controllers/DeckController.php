<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client; // Importar Guzzle para hacer solicitudes HTTP

class DeckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener los mazos
        $decks = Deck::all();

        // Obtener la imagen del comandante para cada mazo
        foreach ($decks as $deck) {
            $comandante = $deck->commander; // Nombre del comandante
            $deck->imagen_comandante = $this->obtenerImagenComandante($comandante);
        }
        return view('decks.list', ['decks' => $decks]);
    }

    // Método para obtener la imagen del comandante desde la API de Scryfall
    private function obtenerImagenComandante($nombreComandante)
    {
        $client = new Client();
        $url = "https://api.scryfall.com/cards/named?exact=" . urlencode($nombreComandante);

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            // Retornar la URL de la imagen pequeña (small) del comandante
            return $data['image_uris']['art_crop'] ?? null;
        } catch (\Exception $e) {
            // Si hay un error (por ejemplo, la carta no existe), retornar null
            return null;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('decks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Comprobamos los datos antes de hacer la insercion
        $datosvalidados = $request->validate([
            'nombre' => 'required|min:2|max:30',
            'comandante' => 'required|min:2|max:50',
            'descripcion' => 'max:300',
        ]);

        // Si los datos son validos realizamos la insercion
        if ($datosvalidados) {
            $listaMazo = ["1 " . $datosvalidados['comandante']];
            $nombreUsuario = User::where('id', auth()->id())->first();
            $deck = new Deck();
            $deck->name = $datosvalidados['nombre'];
            $deck->commander = $datosvalidados['comandante'];
            $deck->description = $datosvalidados['descripcion'];
            $deck->decklist = json_encode($listaMazo);
            $deck->owner_id = auth()->id(); // Asignar el ID del usuario autenticado
            $deck->owner_name = $nombreUsuario->username; // Asignar el nombre del usuario autenticado
            $deck->save();
        }

        return redirect()->route('ver.perfil')->with('success', 'Mazo creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deck $deck)
    {
        return view('decks.view', ['deck' => $deck]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deck $deck)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $deck->owner_id) {
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
        }
        return view('decks.edit', ['deck' => $deck]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deck $deck)
{
    // Comprobamos los datos antes de hacer la insercion
    $datosvalidados = $request->validate([
        'nombre' => 'required|min:3|max:30',
        'comandante' => 'required|min:4|max:50',
        'descripcion' => 'max:300',
    ]);

    // Si los datos son validos realizamos la insercion
    if ($datosvalidados) {
        $listaMazo = explode("\n", $request->input('listaMazo'));

        $deck = Deck::find($deck->id);

        $deck->name = $datosvalidados['nombre'];
        $deck->commander = $datosvalidados['comandante'];
        $deck->description = $datosvalidados['descripcion'];
        $deck->decklist = json_encode($listaMazo);

        $deck->save();
    }

    // Obtener el nombre de usuario del dueño del mazo
    $usuario = User::find($deck->owner_id);

    // Redirigir al perfil del dueño del mazo
    return redirect()->route('ver.perfil.publico', ['username' => $usuario->username])
                    ->with('success', 'Mazo actualizado correctamente.');
}

public function destroyConfirm(Request $request, $id)
{
    $mazo = Deck::findOrFail($id); // Obtén el mazo que se va a eliminar

    // Verifica la opción seleccionada
    if ($request->input('confirmacion') === 'true') {
        // Si el usuario selecciona "Sí", elimina el mazo
        $mazo->delete();
        return redirect()->route('ver.perfil')->with('success', 'Mazo eliminado correctamente.');
    } else {
        // Si el usuario selecciona "No", redirige al perfil sin eliminar
        return redirect()->route('ver.perfil')->with('info', 'Eliminación cancelada.');
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deck $deck)
    {
        // Obtener el nombre de usuario del dueño del mazo antes de eliminarlo
        $usuario = User::find($deck->owner_id);
    
        // Eliminar el mazo
        $deck->delete();
    
        // Redirigir al perfil del dueño del mazo
        return redirect()->route('ver.perfil.publico', ['username' => $usuario->username])
                         ->with('success', 'Mazo eliminado correctamente.');
    }
    public function showDeleteConfirmation($id)
    {
        $mazo = Deck::findOrFail($id); // Obtén el mazo que se va a eliminar
        return view('decks.delete', ['deck' => $mazo]); // Pasa el mazo a la vista decks/delete.blade.php
    }
}