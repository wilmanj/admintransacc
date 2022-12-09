@extends('base')

@section('contenido')
    <div class="container border w-50 p-4 mt-4">
        @if (session('success'))
            <h6 class="alert alert-success">{{ session('success') }}</h6>
        @endif
        <div class="mx-auto">
            <h3 class="fw-bold">Resumen del mes</h3>
        </div>
        <div class="mx-auto">
            <h5 class="fw-bold">Periodo</h5>
            <form id="formBuscarHistorial" method="POST" action="{{route('resumen-periodo')}}">
                @csrf

                <div class="d-md-flex">
                    <div class="form-floating m-2 d-inline-flex">
                        <select class="form-select" name="cbxmes" placeholder="M" required>
                            <option selected disabled value="">Elija...</option>
                            <?php $seleccion = ($mes=="01") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="01">Enero</option>
                            
                            <?php $seleccion = ($mes=="02") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="02">Febrero</option>

                            <?php $seleccion = ($mes=="03") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="03">Marzo</option>
                            
                            <?php $seleccion = ($mes=="04") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="04">Abril</option>

                            <?php $seleccion = ($mes=="05") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="05">Mayo</option>

                            <?php $seleccion = ($mes=="06") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="06">Junio</option>

                            <?php $seleccion = ($mes=="07") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="07">Julio</option>

                            <?php $seleccion = ($mes=="08") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="08">Agosto</option>

                            <?php $seleccion = ($mes=="09") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="09">Septiembre</option>

                            <?php $seleccion = ($mes=="10") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="10">Octubre</option>

                            <?php $seleccion = ($mes=="11") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="11">Noviembre</option>

                            <?php $seleccion = ($mes=="12") ? "selected" : ""; ?>
                            <option {{$seleccion}} value="12">Diciembre</option>
                        </select>
                        <label for="cbxmes" class="form-label">Mes:</label>
                    </div>
                    <div class="form-floating m-2 d-inline-flex">
                        <select class="form-select" name="cbxanio" placeholder="M" required>
                            <option selected disabled value="">Elija...</option>
                            @for ($i = (int)date("Y-m-d"); $i >= 2020; $i--)
                                @if($anio==$i)
                                    <?php
                                        $seleccion="selected";
                                    ?>
                                @else
                                    <?php
                                        $seleccion="";
                                    ?>
                                @endif
                                <option {{$seleccion}} value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <label for="cbxanio" class="form-label">Año:</label>
                    </div>
                    <div class="form-floating m-2 d-inline-block">
                        <input type="submit" class="btn btn-primary" value="Buscar">
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="container w-50 p-4 mt-4 mx-auto" style="min-width: 400px;">
    @if(count($transacciones)>0)    
        <table class="table table-bordered">
            <thead class="thead-dark bg-light">
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Observación</th>
                    <th scope="col">Ingreso</th>
                    <th scope="col">Egreso</th>
                </tr>
            </thead>
            <tbody>

            <?php
                $totalIngreso=0;
                $totalEgreso=0;
            ?>

                @foreach ( $transacciones as $transaccion)
                    @if($transaccion->tipo == "I")
                        <?php 
                            $ingreso=number_format($transaccion->valor,0,",",".");
                            $egreso="";
                            $colorTrans="bg-nb-lightgreen";

                            $totalIngreso+=$transaccion->valor;
                        ?>
                    @else
                        <?php
                            $ingreso="";
                            $egreso=number_format($transaccion->valor,0,",",".");
                            $colorTrans="bg-nb-pink";
                            $totalEgreso+=$transaccion->valor;
                        ?>
                    @endif
                    <tr class="{{$colorTrans}}">
                        <th scope="row">{{date("d/m/Y", strtotime($transaccion->fecha))}}</th>
                        <td>{{$transaccion->observacion}}</td>
                        <th scope="row" style="text-align: right">{{$ingreso}}</th>
                        <th scope="row" style="text-align: right">{{$egreso}}</th>
                    </tr>
                @endforeach
                <tr class="bg-primary text-white">
                    <th scope="row" colspan="2">Totales</th>
                    <th scope="row" style="text-align: right">{{number_format($totalIngreso,0,",",".")}}</th>
                    <th scope="row" style="text-align: right">{{number_format($totalEgreso,0,",",".")}}</th>
                </tr>
                <?php
                    $ganancia=$totalIngreso-$totalEgreso;

                    if($ganancia>=0)
                    {
                        $colorTrans="bg-success";
                        $ingreso=number_format($ganancia,0,",",".");
                        $egreso="";
                    }
                    else{
                        $colorTrans="bg-danger";
                        $ingreso="";
                        $egreso=number_format($ganancia,0,",",".");
                    }
                ?>
                <tr class="{{$colorTrans}}">
                    <th scope="row" class="text-white" colspan="2">Ganancia</th>
                    <th scope="row" class="text-white" style="text-align: right">{{$ingreso}}</th>
                    <th scope="row" class="text-white" style="text-align: right">{{$egreso}}</th>
                </tr>
            </tbody>
        </table>
    @else
        <h4>No hay datos del mes</h4>
    @endif
    </div>
@endsection