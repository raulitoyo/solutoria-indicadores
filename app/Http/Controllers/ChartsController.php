<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use Illuminate\Http\Request;
Use DB;

class ChartsController extends Controller
{
    public function index(Request $request)
    {
        $sql = "SELECT fechaindicador, SUM(valorindicador) AS valor FROM indicadors WHERE fechaindicador BETWEEN '" . $request->inicio  . "' AND '" . $request->final  . "' GROUP BY fechaindicador";
        $indicadores = DB::select($sql);

        return response()->json($indicadores);
    }
}





