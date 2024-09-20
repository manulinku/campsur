@extends('layouts.app')
@section('content')

<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em;">
    @foreach($facturasPorProveedor as $codigo => $facturas)
        <h1 class="h4">Facturas del Proveedor: {{ $facturas->first()->proveedor->NOMBRE }}</h1>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>TIPO</th>
                        <th>NÚMERO DE FACTURA</th>
                        <th>FECHA</th>
                        <th>Mostrar</th> <!-- Columna para las acciones -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($facturas as $factura)
                    <tr>
                        <td>{{ $factura->TIPO }}</td>
                        <td>{{ $factura->NUMERO }}</td> <!-- Columna de número de factura -->
                        <td>{{ $factura->FECHA }}</td>
                        <td>
                            <a href="{{ route('mostrarFactura', $factura->NUMERO) }}" class="btn btn-primary btn-sm">Ver Detalles</a>
                        </td>                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

@endsection
