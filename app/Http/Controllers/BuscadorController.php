<?php

namespace App\Http\Controllers;

use Dom\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BuscadorController extends Controller
{
    // Te lleva a la pagina de busqueda
    public function searchForm()
    {
        return view('buscar.buscar');
    }

    
    //Hace la busqueda a la api
    public function search(Request $request)
    {
        $query = $request->input('q');

        // Si la busqueda esta vacia salta error
        if (!$query) {
            return redirect()->route('buscar')->with('error', 'Debes ingresar un término de búsqueda');
        }

        //Busqueda en la api
        $response = Http::get("https://api.scryfall.com/cards/search", [
            'q' => $query
        ]);

        //Si no se encuentra respuesta laza error, si no, recoge los datos en forma de json
        if ($response->failed()) {
            $data = "Error";
        }else{
            $data = $response->json();
        }

        return view('buscar.resultado', ['resultados' => $data['data'] ?? []]);
    }

    // Funcion para poder ver los detalles de las cartas 
    public function verCarta($nombre)
    {
        // Llamar a la API para obtener detalles de la carta por nombre
        $response = Http::get("https://api.scryfall.com/cards/named", [
            'fuzzy' => $nombre // 'fuzzy' permite buscar aunque haya pequeñas diferencias en el nombre
        ]);

        // Si falla te reembia a al buscador
        if ($response->failed()) {
            return redirect()->route('buscar')->with('error', 'No se encontró la carta.');
        }

        $carta = $response->json();

        // Te envia a cartaEspecifica con los datos de la carta
        return view('buscar.cartaEspecifica', compact('carta'));
    }

    //funcion que te saca una carta aleatoria con el uso de api
    public function cartaAleatoria()
    {
        $response = Http::get("https://api.scryfall.com/cards/random");

        if ($response->failed()) {
            return redirect()->route('buscar')->with('error', 'No se pudo obtener una carta aleatoria.');
        }

        $carta = $response->json();

        return view('buscar.cartaEspecifica', ['carta' => $carta]);
    }


}
