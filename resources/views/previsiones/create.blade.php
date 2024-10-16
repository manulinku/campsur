@extends('layouts.app')

@section('content')
    <div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em;">
        <h1>Añadir Previsión de Corte</h1>

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario para crear una previsión -->
        <form action="{{ route('previsionesGuardar') }}" method="POST">
            {{ csrf_field() }}

            <!-- Campo para seleccionar la fecha -->
            <div class="form-group">
                <label for="FECHA">Fecha de Corte:</label>
                <input type="date" id="FECHA" name="FECHA" class="form-control" value="{{ old('FECHA') }}" required>
            </div>

            <!-- Desplegable para seleccionar el artículo -->
            <div class="form-group">
                <label for="COD_ART">Artículo:</label>
                <select id="COD_ART" name="COD_ART" class="form-control" required>
                    <option value="">Seleccione un artículo</option>
                    @foreach($articulos as $codigo => $descripcion)
                        <option value="{{ $codigo }}" {{ old('COD_ART') == $codigo ? 'selected' : '' }}>
                            {{ $descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo para ingresar la cantidad en kg -->
            <div class="form-group">
                <label for="CANTIDAD">Cantidad (Kg):</label>
                <input type="number" id="CANTIDAD" name="CANTIDAD" class="form-control" value="{{ old('CANTIDAD') }}" required min="1">
            </div>

            <!-- Botón para guardar la previsión -->
            <button type="submit" class="btn btn-success">Guardar Previsión</button>
        </form>
    </div>
@endsection
