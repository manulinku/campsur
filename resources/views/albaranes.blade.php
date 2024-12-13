@extends('layouts.app')
@section('content')

<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
    <h2>Albaranes</h2>
     <!-- Botón para volver a todos los albaranes con icono -->
    <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 1rem; right: 1rem;">
        <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
        Volver
    </a>
    @if($albaranesPorProveedor->isEmpty())
        <h1 class="h4">Todavía no tiene albaranes</h1>
    @else
        @foreach($albaranesPorProveedor as $codigo => $albaranes)
            <h1 class="h4">Albaranes del Proveedor: {{ $albaranes->first()->proveedor ? $albaranes->first()->proveedor->NOMBRE : 'Proveedor no disponible' }}</h1>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>TIPO</th>
                            <th>NÚMERO DE ALBARÁN</th>
                            <th>FECHA</th>
                            <th>Mostrar</th> <!-- Columna para las acciones -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($albaranes as $albaran)
                            <tr>
                                <td>{{ $albaran->TIPO }}</td>
                                <td>{{ $albaran->NUMERO }}</td>
                                <td>{{ $albaran->FECHA }}</td>
                                <td>
                                    <a href="{{ route('mostrarAlbaran', $albaran->NUMERO) }}" class="btn btn-primary btn-sm">Ver Detalles</a>
                                </td> <!-- Botón para ver detalles -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif
</div>

@endsection
