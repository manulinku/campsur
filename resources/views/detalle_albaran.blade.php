@extends('layouts.app')
@section('content')
    


    <div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position: relative;">
        @if ($user && ($user->role === 'admin' || $user->CODIGO === $albaran->COD_PROV))
            <h1 class="h4">Detalles del Albarán: {{ $albaran->TIPO }} - {{ $albaran->NUMERO }}</h1>
            <h2 class="h6">Fecha: {{ $albaran->FECHA }}</h2>
            <p>Proveedor: {{ $albaran->proveedor ? $albaran->proveedor->NOMBRE : 'Proveedor no disponible' }}</p>

            <!-- Botón para volver a todos los albaranes con icono -->
            <a href="{{ route('albaranes') }}" class="btn btn-primary" style="position: absolute; top: 1rem; right: 1rem;">
                <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
                Volver
            </a>
           


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
                            <th>PRECIO</th>
                            <th>IMPORTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalPalets = 0;
                            $totalBultos = 0;
                            $totalNeto = 0;
                            $totalImporte = 0;
                        @endphp

                        @foreach ($lineas as $linea)
                            <tr>
                                <td>{{ $linea->ARTICULO ? $linea->ARTICULO->DESCRIPCION : 'Descripción no disponible' }}
                                </td>
                                <td>{{ $linea->CAT }}</td>
                                <td>{{ $linea->CAL }}</td>
                                <td>{{ $linea->ENVASE ? $linea->ENVASE->DESCRIPCION : 'Descripción no disponible' }}</td>
                                <td>{{ number_format($linea->PALETS, 2, ',', '.') }}</td>
                                <td>{{ $linea->BULTOS }}</td>
                                <td>{{ number_format($linea->CANTIDAD, 2, ',', '.') }}</td> <!-- Cambié a PESO_NETO -->
                                <td>{{ number_format($linea->PRECIO, 2, ',', '.') }}</td>
                                <td>{{ number_format($linea->IMPORTEEUR, 2, ',', '.') }}</td>
                            </tr>

                            @php
                                // Sumar los valores
                                $totalPalets += $linea->PALETS;
                                $totalBultos += $linea->BULTOS;
                                $totalNeto += $linea->CANTIDAD;
                                $totalImporte += $linea->IMPORTEEUR;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold"><b>SUMA:</b></td>
                            <td><b>{{ number_format($totalPalets, 2, ',', '.') }}</b></td>
                            <td><b>{{ number_format($totalBultos, 0, ',', '.') }}</b></td>
                            <td><b>{{ number_format($totalNeto, 2, ',', '.') }}</b></td>
                            <td></td>
                            <td style="color: #046433;"><b><u>{{ number_format($totalImporte, 2, ',', '.') }}</u></b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <p>No tienes permiso para ver los detalles de este albarán.</p>
        @endif
    </div>

@endsection
