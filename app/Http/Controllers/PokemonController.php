<?php

namespace App\Http\Controllers;

use App\Models\pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index()
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokedex/1/');
        $body = $response->json()['pokemon_entries'];

        // insert into db
        return view('welcome',compact('body'));
    }

    public function add ()
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokedex/1/');
        $body = $response->json()['pokemon_entries'];

        foreach ($body as $ele) {
            pokemon::create([
                'name' => $ele['pokemon_species']['name'],
                'url' => $ele['pokemon_species']['url'],
                'entry_number' => $ele['entry_number']
            ]);
        }

        return redirect('/');
    }

    public function pokemon()
    {
        return response()->json(pokemon::all());
    }
}
