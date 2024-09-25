@extends('layouts.app')
@section('content')

<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em;">
    @if ($user && ($user->role === 'admin' || $user->CODIGO === $albaran->COD_PROV))
        <h1 class="h4">Detalles del Albarán: {{$albaran->TIPO}} - {{$albaran->NUMERO}}</h1>
        <h2 class="h6">Fecha: {{$albaran->FECHA}}</h2>
        <p>Proveedor: {{ $albaran->proveedor ? $albaran->proveedor->NOMBRE : 'Proveedor no disponible' }}</p>
        
        <!-- Mostrar las líneas del albarán -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>DESCRIPCIÓN</th>
                        <th>CAT</th>
                        <th>CAL</th>
                        <th>ENVASE</th>
                        <th>PALETS</th>
                        <th>BULTOS</th>
                        <th>PESO NETO (KG)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lineas as $linea)
                    <tr>
                        <td>{{ $linea->ARTICULO ? $linea->ARTICULO->DESCRIPCION : 'Descripción no disponible' }}</td>
                        <td>{{ $linea->CAT }}</td>
                        <td>{{ $linea->CAL }}</td>
                        <td>{{ $linea->ENVASE ? $linea->ENVASE->DESCRIPCION : 'Descripción no disponible' }}</td> 
                        <td>{{ number_format($linea->PALETS, 2, ',', '.') }}</td>
                        <td>{{ $linea->BULTOS }}</td>
                        <td>{{ number_format($linea->CANTIDAD, 2, ',', '.') }}</td> <!-- Cambié a PESO_NETO -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No tienes permiso para ver los detalles de este albarán.</p>
    @endif
</div>

@endsection
