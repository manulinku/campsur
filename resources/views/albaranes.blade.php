@extends('layouts.app')
@section('content')

<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em;">
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
</div>

@endsection
