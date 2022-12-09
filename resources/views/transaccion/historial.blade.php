@extends('base')

@section('contenido')
    <div class="container border w-50 p-4 mt-4" style="min-width: 300px;">
        @if (session('success'))
            <h6 class="alert alert-success">{{ session('success') }}</h6>
        @endif
        <div class="mx-auto">
            <h3 class="fw-bold">Historial de transacciones</h3>
        </div>
        <div class="mx-auto">
            <h5 class="fw-bold">Fecha</h5>
            <form id="formBuscarHistorial" method="POST" action="{{route('transaccion-lista-especifica')}}">
                @csrf

                @if ($fecha["fechaDesde"]==null)
                    <?php
                        $fechaDesde=date("Y-m-d");
                    ?>
                @else
                    <?php
                        $fechaDesde=$fecha["fechaDesde"];
                    ?>
                @endif

                @if ($fecha["fechaHasta"]==null)
                    <?php
                        $fechaHasta=date("Y-m-d");
                    ?>
                @else
                    <?php
                        $fechaHasta=$fecha["fechaHasta"];
                    ?>
                @endif

                <div class="d-md-flex">
                    <div class="form-floating m-2 d-inline-flex">
                        <input type="date" class="form-control" id="txtfechaDesde" name="txtfechaDesde" placeholder="20-12-2000" value="{{$fechaDesde}}" required>
                        <label for="txtfechaDesde" class="form-label">Desde:</label>
                    </div>
                    <div class="form-floating m-2 d-inline-flex">
                        <input type="date" class="form-control" id="txtfechaHasta" name="txtfechaHasta" placeholder="20-12-2000" value="{{$fechaHasta}}" required>
                        <label for="txtfechaHasta" class="form-label">Hasta:</label>
                    </div>
                    <div class="form-floating m-2 d-inline-block">
                        <input type="submit" class="btn btn-primary" value="Buscar">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container w-50 p-4 mt-4" style="min-width: 400px;">
        @foreach ( $transacciones as $transaccion)
            @if($transaccion->tipo == "I")
                <?php 
                    $tipo="Ingreso"; 
                    $colorTrans="bg-nb-lightgreen";
                ?>
            @else
                <?php
                    $tipo="Egreso"; 
                    $colorTrans="bg-nb-pink";
                ?>
            @endif
            <div class="p-3 mb-3 text-dark  mb-3 d-flex justify-content-between {{$colorTrans}}">
                <div class="d-flex">
                    <div>
                        <div class="fw-bold">{{$tipo}}</div>
                        <div>{{date("d/m/Y", strtotime($transaccion->fecha))}}</div>
                        <div>{{$transaccion->observacion}}</div>
                    </div>
                </div>
                <div class="d-flex fw-bold">
                    <div>
                        <div class="d-flex justify-content-end">
                            $ {{ number_format($transaccion->valor,0,",",".") }}
                        </div>
                        <div class="d-flex justify-content-end justify-content-md-between">
                            <input type="button" onClick="location.href='{{ route('transaccion-modificar', ['id'=>$transaccion->id]) }}'" class="btn btn-primary m-1" value="Modificar">
                            <input type="button" class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#modal-{{$transaccion->id}}" value="Eliminar">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-{{$transaccion->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmar eliminación</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro que desea eliminar la transacción de fecha {{$transaccion->fecha}} por un monto de {{ number_format($transaccion->valor,0,",",".") }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, quiero volver</button>
                        <form method="POST" action="{{route('transaccion-eliminar', ['id' => $transaccion->id, 'txtfechaDesde' => $fechaDesde, 'txtfechaHasta' => $fechaHasta])}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection