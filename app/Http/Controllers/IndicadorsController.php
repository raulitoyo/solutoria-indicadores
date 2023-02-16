<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use Illuminate\Http\Request;
use DataTables;

class IndicadorsController extends Controller
{
    public function index(Request $request)
    {
        $indicadors = Indicador::latest()->get();

        if ($request->ajax()) {
            $data = Indicador::latest()->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editIndicador">Editar</a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteIndicador">Eliminar</a>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('indicador',compact('indicadors'));
    }

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

        return response()->json(['satisfactorio'=>'Los indicadores han sido importados satisfactoriamente.']);
    }

    public function edit($id)
    {
        $indicador = Indicador::find($id);
        return response()->json($indicador);
    }

    public function store(Request $request)
    {
        $indicador = Indicador::updateOrCreate(
            ['id' => intval($request->idIndicador)], 
            [
                'nombreindicador' => $request->txtNombre, 
                'codigoindicador' => $request->txtCodigo, 
                'unidadmedidaindicador' => $request->selUnidad, 
                'valorindicador' => $request->txtValor, 
                'fechaindicador' => $request->txtFecha, 
                'tiempoindicador' => $request->txtTiempo, 
                'origenindicador' => $request->selOrigen
            ]
        );        

        return response()->json(['success'=>'Indicador guardado correctamente.']);
    }

    public function destroy($id)
    {
        Indicador::find($id)->delete();
     
        return response()->json(['success'=>'Indicador eliminado correctamte.']);
    }    
}
