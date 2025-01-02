@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
        <h2>Selecciona un Producto para Mostrar el Gráfico</h2>
        <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 0.5rem; right: 1rem;">
            <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
            Volver
        </a>
        <!-- Formulario para seleccionar el producto -->
        <form method="GET" class="mb-">
            <div class="form-group">
                <label for="producto">Producto:</label>
                <select name="producto" id="producto" class="form-control">
                    <option value="">-- Selecciona un producto --</option>
                    @foreach($productos as $codigo => $descripcion)
                        <option value="{{ $codigo }}" {{ $productoSeleccionado == $codigo ? 'selected' : '' }}>
                            {{ $descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mostrar Gráfico</button>
        </form>

        <!-- Mostrar gráficos -->
        @if($productoSeleccionado && $data->isNotEmpty())
            <h3>Gráfico para {{ $productos[$productoSeleccionado] }}</h3>

            @foreach($data as $año => $meses)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Año: {{ $año }}</h5>
                        <canvas id="chart-{{ $año }}" width="400" height="200"></canvas>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var ctx = document.getElementById('chart-{{ $año }}').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                datasets: [{
                                    label: 'Kilogramo por Mes',
                                    data: [
                                        @foreach(range(1, 12) as $mes)
                                            {{ $meses[$mes] ?? 0 }},
                                        @endforeach
                                    ],
                                    borderColor: '#FF5733',
                                    borderWidth: 2,
                                    fill: false
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Kilogramos'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Meses'
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
            @endforeach
        @elseif($productoSeleccionado)
            <p>No hay datos disponibles para el producto seleccionado.</p>
        @endif
    </div>
@endsection