<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;

class TransaccionControlador extends Controller
{

    public function listar()
    {
        $transacciones = Transaccion::all();
        return view('transaccion.historial', ['transacciones'=>$transacciones]);
    }

    public function listarEspecifico(Request $request)
    {
        $transacciones = Transaccion::where("fecha", ">=", $request->txtfechaDesde)->where("fecha", "<=", $request->txtfechaHasta)->get();
        return view('transaccion.historial', ['transacciones'=>$transacciones, "fecha"=>["fechaDesde"=>$request->txtfechaDesde, "fechaHasta"=>$request->txtfechaHasta]]);
    }

    public function listarResumen(Request $request)
    {
        $fecIni = $request->cbxanio."-".$request->cbxmes."-01";
        $fecFin = date('Y-m-d', strtotime(date('Y-m-d', strtotime("{$fecIni} + 1 month"))." - 1 day"));
        $transacciones = Transaccion::where("fecha", ">=", $fecIni)->where("fecha", "<=", $fecFin)->orderBy("fecha", "asc")->get();
        return view('transaccion.resumen', ['transacciones'=>$transacciones, "mes"=>$request->cbxmes, "anio"=>$request->cbxanio]);
    }

    public function buscarUno($id)
    {
        $transaccion = Transaccion::find($id);

        return view('transaccion.modificar', ['transaccion'=>$transaccion]);
    }

    public function actualizar(Request $request, $id)
    {
        $transaccion = Transaccion::find($id);
        $transaccion->tipo = $request->cbxtipo;
        $transaccion->fecha = $request->txtfecha;
        $transaccion->valor = $request->txtvalor;
        $transaccion->observacion = $request->txtobservacion;
        $transaccion->save();

        return redirect()->route('transaccion-cargar-historial')->with('success', 'Transacción modificada');
    }

    public function guardar(Request $request){
        $request->validate([
            'cbxtipo' => 'required',
            'txtfecha' => 'required|min:10|max:10',
            'txtvalor' => 'required',
            'txtobservacion' => 'max:150'
        ]);

        $transaccion = new Transaccion;

        $transaccion->tipo = $request->cbxtipo;
        $transaccion->fecha = $request->txtfecha;
        $transaccion->valor = $request->txtvalor;
        $transaccion->observacion = $request->txtobservacion;

        $transaccion->save();

        return redirect()->route('transaccion')->with('success', 'Transacción registrada correctamente');
    }

    public function eliminar($id, $txtfechaDesde, $txtfechaHasta)
    {
        $transaccion = Transaccion::find($id);
        if($transaccion!=null)
        {
            $transaccion->delete();
        }

        $transacciones = Transaccion::where("fecha", ">=", $txtfechaDesde)->where("fecha", "<=", $txtfechaHasta)->get();

        return view('transaccion.historial', ['transacciones'=>$transacciones, "fecha"=>["fechaDesde"=>$txtfechaDesde, "fechaHasta"=>$txtfechaHasta]])->with('success', 'Transacción eliminada');;
    }
}
