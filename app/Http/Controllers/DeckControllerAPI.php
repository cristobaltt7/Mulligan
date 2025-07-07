<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;

class DeckControllerAPI extends Controller
{
    // Devuelve todos los mazos de la aplicacion
    public function listarTodosMazos()
    {
        $decks = Deck::all()->get();

        foreach ($decks as $deck) {
            $deck->decklist = json_decode($deck->decklist);
        }
        return response()->json($decks);
    }

    // Devuelve todos los mazos de un usuario en concreto
    public function listarMazos(int $user_id)
    {
        $decks = Deck::where("owner_id", $user_id)->get();

        foreach ($decks as $deck) {
            $deck->decklist = json_decode($deck->decklist);
        }
        return response()->json($decks);
    }

    // Devuelve un mazo con un ID especifico
    public function mostrarMazo(int $id)
    {
        $deck = Deck::where('id', $id)->get()[0];
        str_replace("\r", "n", $deck->decklist);
        $deck->decklist = json_decode($deck->decklist);
        return response()->json($deck);
    }

    // Funcion para agregar una carta a un mazo
    public function agregarCarta(Request $request)
    {
        try {
            $deck = Deck::where('id', $request->input('deck_id'))->get()[0];

            // Decodificar el decklist (asumiendo que es un JSON almacenado como string)
            $decklist = json_decode($deck->decklist, true) ?? [];

            // Buscar si la carta ya está en el mazo
            $encontrada = false;

            for ($i=0; $i < count($decklist); $i++) { 
                $nombre = explode(' ', $decklist[$i]);
                $numero_copias = array_shift($nombre);
                $nombre = implode(' ', $nombre);
                if ($nombre == $request->input('card_name')) {
                    $numero_copias = intval($numero_copias) + 1;
                    $encontrada = true;
                    $decklist[$i] = $numero_copias . " " . $nombre;
                    break;
                }
            }

            // Agregar la nueva carta al decklist si no esta repetida
            if (!$encontrada){
                $decklist[] = "1 " . $request->input('card_name');
            }

            // Guardar de nuevo como JSON
            $deck->decklist = json_encode($decklist);
            $deck->save();

            return redirect("/decks/$deck->id/view");
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

}
