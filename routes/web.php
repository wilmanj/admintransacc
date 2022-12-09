<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaccionControlador;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('base');
});

Route::get('/transaccion', function(){ return view('transaccion.index'); })->name('transaccion');

Route::post('/transaccion', [TransaccionControlador::class, 'guardar'])->name('transaccion-guardar');

Route::get('/historial', function(){ return view('transaccion.historial', ["transacciones"=>array(), "fecha"=>["fechaDesde"=>null, "fechaHasta"=>null]]); })->name('transaccion-cargar-historial');

Route::get('/historial/{id}', [TransaccionControlador::class, 'buscarUno'])->name('transaccion-modificar');

Route::post('/historial/{id}', [TransaccionControlador::class, 'actualizar'])->name('transaccion-actualizar');

Route::delete('/historial/{id}&{txtfechaDesde}&{txtfechaHasta}', [TransaccionControlador::class, 'eliminar'])->name('transaccion-eliminar');

Route::post('/historial', [TransaccionControlador::class, 'listarEspecifico'])->name('transaccion-lista-especifica');

Route::get('/resumen', function(){ return view('transaccion.resumen', ["transacciones"=>array(), "mes"=>"", "anio"=>""]); })->name('resumen');

Route::post('/resumen', [TransaccionControlador::class, 'listarResumen'])->name('resumen-periodo');