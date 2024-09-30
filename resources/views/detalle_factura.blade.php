@extends('layouts.app')
@section('content')

<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em;">
    @if ($user && ($user->role === 'admin' || $user->CODIGO === $factura->COD_PROV))
        <h1 class="h4">Detalles de la Factura: {{ $factura->SERIEFAC }} - {{ $factura->NUMFAC }}</h1>
        <h2 class="h6">Fecha de la Factura Asociada: {{$factura->FECHA}}</h2>
        <p>Proveedor: {{ $factura->proveedor ? $factura->proveedor->NOMBRE : 'Proveedor no disponible' }}
        
        <!-- Mostrar las líneas asociadas al albarán de esta factura -->
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
                        <th>NETO</th>
                        <th>PRECIO</th>
                        {{-- <th>TP</th> Es el tipo de peso en este caso k de KG --}}
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

                    @foreach($lineas as $linea)
                    <tr>
                        <td>{{ $linea->ARTICULO ? $linea->ARTICULO->DESCRIPCION : 'Descripción no disponible' }}</td>
                        <td>{{ $linea->CAT }}</td>
                        <td>{{ $linea->CAL }}</td>
                        <td>{{ $linea->ENVASE ? $linea->ENVASE->DESCRIPCION : 'Descripción no disponible' }}</td>
                        <td>{{ number_format($linea->PALETS, 2, ',', '.') }}</td>
                        <td>{{ $linea->BULTOS }}</td>
                        <td>{{ number_format($linea->CANTIDAD, 2, ',', '.') }}</td>
                        <td>{{ number_format($linea->PRECIO, 2, ',', '.') }}</td>
                        {{-- <td>{{ $linea->TP }}</td> --}}
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
                        {{-- <td></td> --}}
                        <td><b>{{ number_format($totalImporte, 2, ',', '.') }}</b></td>
                      
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- Fila separada para IVA, DTO y TOTAL -->
        <div class="mt-4 table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        
                        <th>BRUTO</th>
                        <th>% DTO</th>
                        <th>DTO</th>
                        <th>BASE IMPONIBLE</th>
                        <th>% I.R.P.F.</th>
                        <th>I.R.P.F.</th>
                        <th>IVA</th>
                        <th>TOTAL FACTURA (EUR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ number_format($bruto, 2, ',', '.') }}</td>
                        <td>{{ number_format($tasa_dto, 2, ',', '.') }}</td>
                        <td>{{ number_format($dto, 2, ',', '.') }}</td>
                        <td>{{ number_format($base, 2, ',', '.') }}</td>
                        <td>{{ number_format($tasa_irpf, 2, ',', '.') }}</td>
                        <td>{{ number_format($irpf, 2, ',', '.') }}</td>
                        <td>{{ number_format($iva, 2, ',', '.') }}</td>
                        <td style="color: #68BF11;"><b><u>{{ number_format($total, 2, ',', '.') }}</b></u></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <p>No tienes permiso para ver los detalles de esta factura.</p>
    @endif
</div>

@endsection
