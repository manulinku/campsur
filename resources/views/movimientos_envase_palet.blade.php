@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
    {{-- Verificar si hay un mensaje de error --}}
    @if(isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @else
        {{-- Tabla para Movimientos de Envases y Palets --}}
        <h2 style="margin-top: 3rem;">Movimientos de Envases y Palets</h2>
        <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 1rem; right: 1rem;">
            <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
            Volver
        </a>
        @if(count($movimientos) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Total Entregas</th>
                            <th>Total Retiros</th>
                            <th>Saldo</th> {{-- Nueva columna Saldo --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $movimiento)
                            <tr>
                                <td>{{ $movimiento->DESCRIPCION_PADRE }}</td>
                                <td>{{ number_format($movimiento->TOTAL_ENTREGA, 0, ',', '.') }}</td>
                                <td>{{ number_format($movimiento->TOTAL_RETIRA, 0, ',', '.') }}</td>
                                <td>{{ number_format($movimiento->TOTAL_ENTREGA - $movimiento->TOTAL_RETIRA, 0, ',', '.') }}</td> {{-- Cálculo del Saldo --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> {{-- Cierre de table-responsive --}}
        @else
            <p>No se encontraron movimientos para este proveedor.</p>
        @endif
    @endif
</div>
@endsection
