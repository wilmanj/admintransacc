@extends('base')

@section('contenido')
<div class="form-floating mb-3">
    <div class="container border p-4 mt-4 w-25" style="min-width: 300px;">
        <h4>Registro de transacciones</h4>
        <form method="POST" action="{{route('transaccion-guardar')}}">
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
                    <select class="form-select" name="cbxtipo" placeholder="I" required>
                        <option selected disabled value="">Elija...</option>
                        <option value="I">Ingreso</option>
                        <option value="E">Egreso</option>
                    </select>
                    <label for="cbxtipo" class="form-label ml-lg-3">Tipo de transacción:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" name="txtfecha" placeholder="20-12-2000" required>
                    <label for="txtfecha" class="form-label">Fecha:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" name="txtvalor" placeholder="10000" required>
                    <label for="txtvalor" class="form-label">Valor:</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="txtobservacion" placeholder="Compra" required></textarea>
                    <label for="txtfecha" class="form-label">Observación</label>
                </div>
                <div class="mb-3 row mx-auto">
                    <button type="submit" class="btn btn-success">Guardar transacción</button>
                </div>
            </div>
            <div class="row mx-auto mt-3">
                <button type="button" class="btn btn-primary" onClick="location.href='{{route('transaccion-cargar-historial')}}'">Ver historial de transacciones</button>
            </div>
        </form>
    </div>

@endsection