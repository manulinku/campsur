@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Tabla para Envases --}}
<h2>Movimientos de Envases</h2>
@foreach($movimientosEnvases as $movimiento)
    <h3>{{ $movimiento->DESCRIPCION }}</h3>
    <table>
        <tr>
            <th>Total Entregas</th>
            <th>Total Retiros</th>
        </tr>
        <tr>
            <td>{{ $movimiento->TOTAL_ENTREGA }}</td>
            <td>{{ $movimiento->TOTAL_RETIRA }}</td>
        </tr>
    </table>
@endforeach

{{-- Tabla para Palets --}}
<h2>Movimientos de Palets</h2>
@foreach($movimientosPalets as $movimiento)
    <h3>{{ $movimiento->DESCRIPCION }}</h3>
    <table>
        <tr>
            <th>Total Entregas</th>
            <th>Total Retiros</th>
        </tr>
        <tr>
            <td>{{ $movimiento->TOTAL_ENTREGA }}</td>
            <td>{{ $movimiento->TOTAL_RETIRA }}</td>
        </tr>
    </table>
@endforeach

</div>
@endsection
