<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class ImportsController extends Controller
{
    public function import(Request $request)
    {
        //$json = file_get_contents($request->file('file')->store('temp'));
        $json = file_get_contents('indicadores.json');

        $data = json_decode($json, true);

        foreach ($data as $row) {
            $id = $row['id'];
            $nombreindicador = $row['nombreIndicador'];
            $codigoindicador = $row['codigoIndicador'];
            $unidadmedidaindicador = $row['unidadMedidaIndicador'];
            $valorindicador = $row['valorIndicador'];
            $fechaindicador = $row['fechaIndicador'];
            $tiempoindicador = $row['tiempoIndicador'];
            $origenindicador = $row['origenIndicador'];

            $indicador = Indicador::where('id', $id)->first();
            if(is_null($indicador)) {
                Indicador::create([
                    'nombreindicador' => $nombreindicador, 
                    'codigoindicador' => $codigoindicador, 
                    'unidadmedidaindicador' => $unidadmedidaindicador, 
                    'valorindicador' => $valorindicador, 
                    'fechaindicador' => $fechaindicador, 
                    'tiempoindicador' => $tiempoindicador, 
                    'origenindicador' => $origenindicador    
                ]);
            }  else {
                $indicador->update([
                    'nombreindicador' => $nombreindicador, 
                    'codigoindicador' => $codigoindicador, 
                    'unidadmedidaindicador' => $unidadmedidaindicador, 
                    'valorindicador' => $valorindicador, 
                    'fechaindicador' => $fechaindicador, 
                    'tiempoindicador' => $tiempoindicador, 
                    'origenindicador' => $origenindicador    
                ]);
            }
        }

        //return response()->json(['satisfactorio'=>'Los indicadores han sido importados satisfactoriamente.']);
        return view('indicador');
    }
}
