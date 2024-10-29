@extends('layouts.app')

@section('content')
    <div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em;">
        <h1>Mis Previsiones de Corte</h1>

        <!-- Botón para añadir nueva previsión -->
        <a href="{{ route('previsionesCrear') }}" class="btn btn-primary mb-3">Añadir Previsión de Corte</a>

        @if(auth()->user()->role === 'admin')
            @foreach($previsiones as $codProv => $prev)
                <h3>Proveedor: {{ $prev->first()->proveedor->nombre }} (Código: {{ $codProv }})</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Artículo</th>
                                <th>Cantidad (Kg)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prev as $prevision)
                                <tr>
                                    <td>{{ $prevision->FECHA }}</td> <!-- Accediendo a FECHA de cada prevision -->
                                    <td>{{ $prevision->articulo->DESCRIPCION }}</td>
                                    <td>{{ number_format($prevision->CANTIDAD, 2, ',', '.') }}</td>
                                    <td>
                                        <!-- Botón para eliminar la previsión con confirmación -->
                                        <a href="{{ route('previsionesEliminar', $prevision->LINEA) }}" 
                                           class="btn btn-danger" 
                                           onclick="return confirmDelete()">Borrar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <!-- Si no es usuario, mostrar sus previsiones como antes -->
            @if ($previsiones->isEmpty())
                <p>No tienes previsiones de corte registradas.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Artículo</th>
                                <th>Cantidad (Kg)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($previsiones as $prevision)
                                <tr>
                                    <td>{{ $prevision->FECHA }}</td>
                                    <td>{{ $prevision->articulo->DESCRIPCION }}</td>
                                    <td>{{ number_format($prevision->CANTIDAD, 2, ',', '.') }}</td>
                                    <td>
                                        <!-- Botón para eliminar la previsión con confirmación -->
                                        <a href="{{ route('previsionesEliminar', $prevision->LINEA) }}" 
                                           class="btn btn-danger" 
                                           onclick="return confirmDelete()">Borrar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>

    <script>
        function confirmDelete() {
            return confirm("¿Estás seguro de que deseas borrar esta previsión?");
        }
    </script>
@endsection
