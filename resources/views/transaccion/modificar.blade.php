@extends('base')

@section('contenido')
<div class="form-floating mb-3">
    <div class="container border w-25 p-4 mt-4" style="min-width: 300px;">
        <h4>Modificacón de transacción</h4>
        <form method="POST"  action="{{route('transaccion-actualizar', ['id'=>$transaccion->id])}}">
            @csrf
            @if (session('success'))
                <h6 class="alert alert-success">{{ session('success') }}</h6>
            @endif

            @error('txtcodigo')
                <h6 class="alert alert-danger">{{ $message }}</h6>
            @enderror

            @error('txtfecha')
                <h6 class="alert alert-danger">{{ $message }}</h6>
            @enderror

            @error('txtvalor')
                <h6 class="alert alert-danger">{{ $message }}</h6>
            @enderror
            
            <div class="mx-auto">    
                <div class="form-floating mb-3">
                    <select class="form-select" name="cbxtipo" placeholder="I">
                        @if ($transaccion->tipo=="I")
                            <option value="I" selected="true">Ingreso</option>
                            <option value="E">Egreso</option>
                        @else
                            <option value="I">Ingreso</option>
                            <option value="E" selected="true">Egreso</option>
                        @endif
                    </select>
                    <label for="cbxtipo" class="form-label ml-lg-3">Tipo de transacción:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" name="txtfecha" placeholder="20-12-2000" value="{{$transaccion->fecha}}" required>
                    <label for="txtfecha" class="form-label">Fecha:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="txtvalor" placeholder="10000" value="{{$transaccion->valor}}" required>
                    <label for="txtvalor" class="form-label">Valor:</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="txtobservacion" placeholder="Compra" required> {{$transaccion->observacion}}</textarea>
                    <label for="txtfecha" class="form-label">Observación</label>
                </div>
                <div class="mb-3 row mx-auto">
                    <button type="submit" class="btn btn-success">Modificar transacción</button>
                </div>
                <div class="row mx-auto mt-3">
                    <button type="button" class="btn btn-danger" onClick="location.href='{{route('transaccion-cargar-historial')}}'">Cancelar modificación</button>
                </div>
            </div>
        </form>
    </div>

@endsection