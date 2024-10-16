@extends('layouts.app')

@section('content')
    <div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em;">
        <h1>Editar Previsión de Corte</h1>

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

        <!-- Formulario para editar una previsión -->
        <form action="{{ route('previsionesActualizar', $prevision->LINEA) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
        
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" value="{{ $prevision->FECHA }}">
        
            <label for="articulo">Artículo:</label>
            <select name="cod_art">
                @foreach($articulos as $articulo)
                    <option value="{{ $articulo->CODIGO }}" {{ $articulo->CODIGO == $prevision->COD_ART ? 'selected' : '' }}>
                        {{ $articulo->DESCRIPCION }}
                    </option>
                @endforeach
            </select>
        
            <label for="cantidad">Cantidad (kg):</label>
            <input type="number" name="cantidad" step="0.01" value="{{ number_format($prevision->CANTIDAD, 2) }}">
        
            <button type="submit" class="btn btn-success">Actualizar Previsión</button>
        </form>        
    </div>
@endsection
