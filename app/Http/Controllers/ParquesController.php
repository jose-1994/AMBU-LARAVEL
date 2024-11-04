<?php

namespace App\Http\Controllers;
use App\Models\Municipios;
use App\Models\Parques;
use Illuminate\Http\Request;

class ParquesController extends Controller
{
    //Obtener todos los parques
    public function getAllParques(){
        $parques = Parques::all();
        return response()->json($parques);
    }

    public function getAllMunicipios(){
        $municipios = Municipios::all();
        return response()->json($municipios);
    }
}

