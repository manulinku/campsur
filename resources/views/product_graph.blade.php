@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
    <h2>Selecciona un Producto para Mostrar el Gráfico</h2>
    <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 0.5rem; right: 1rem;">
        <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
        Volver
    </a>
    <!-- Formulario para seleccionar el producto -->
    <form method="GET" class="mb-4">
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
        <p></p>
    </form>

    <!-- Mostrar gráficos -->
    @if($productoSeleccionado && $data->isNotEmpty())
        <!-- Gráfico de cantidad -->
        @foreach($data as $año => $meses)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $productos[$productoSeleccionado] }}</h5>
                    <canvas id="chart-{{ $año }}-cantidad" style="width: 100%; height: 300px;"></canvas>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ctx = document.getElementById('chart-{{ $año }}-cantidad').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            datasets: [{
                                label: 'Kilogramos por Mes',
                                data: [
                                    @foreach(range(1, 12) as $mes)
                                        {{ $meses[$mes] ?? 0 }},
                                    @endforeach
                                ],
                                backgroundColor: 'rgba(52, 181, 114, 0.3)',  // Color de fondo más claro y translúcido
                                borderColor: '#34b572',  // Color del borde igual al color de la barra
                                borderWidth: 2  // Grosor del borde
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Kilos/Mes',
                                    align: 'start', // Alinear a la izquierda
                                    padding: {top: 10, left: 10},
                                    font: {
                                        size: 15,
                                        weight: 'bold'
                                    },
                                    color: '#000'
                                },
                                subtitle: {
                                    display: true,
                                    text: 'Cantidad - Año: {{ $año }}',
                                    align: 'end', // Alinear a la derecha
                                    padding: {right: 10},
                                    font: {
                                        size: 12,
                                        style: 'italic'
                                    },
                                    color: '#555'
                                }
                            },
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
                                    },
                                    ticks: {
                                        autoSkip: true,
                                        maxTicksLimit: 6  // Limita el número de etiquetas visibles
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endforeach

        <!-- Gráfico de precio medio -->
        @foreach($dataPrecioMedio as $año => $meses)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $productos[$productoSeleccionado] }}</h5>
                    <canvas id="chart-{{ $año }}-precio" style="width: 100%; height: 300px;"></canvas>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ctx = document.getElementById('chart-{{ $año }}-precio').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            datasets: [{
                                label: 'Precio Medio (€) por Mes',
                                data: [
                                    @foreach(range(1, 12) as $mes)
                                        {{ $meses[$mes] ?? 0 }},
                                    @endforeach
                                ],
                                backgroundColor: 'rgba(52, 181, 114, 0.3)',  // Color de fondo más claro y translúcido
                                borderColor: '#34b572',  // Color del borde igual al color de la barra
                                borderWidth: 2  // Grosor del borde
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Precio medio/Mes',
                                    align: 'start', // Alinear a la izquierda
                                    padding: {top: 10, left: 10},
                                    font: {
                                        size: 15,
                                        weight: 'bold'
                                    },
                                    color: '#000'
                                },
                                subtitle: {
                                    display: true,
                                    text: 'Precio Medio - Año: {{ $año }}',
                                    align: 'end', // Alinear a la derecha
                                    padding: {right: 10},
                                    font: {
                                        size: 12,
                                        style: 'italic'
                                    },
                                    color: '#555'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Precio Medio (€)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Meses'
                                    },
                                    ticks: {
                                        autoSkip: true,
                                        maxTicksLimit: 6  // Limita el número de etiquetas visibles
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endforeach

        <!-- Totales en formato tabla -->
            


        <div class="estadisticas" style="font-family: Arial, sans-serif;">
            <div class="fila-1" style="background-color: white; padding: 10px; text-align: center;">
                <h2 style="color: #000000;">Estadísticas por productos</h2>
            </div>
        
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: gray; color: white;">
                    <tr>
                        <th style="padding: 10px; text-align: center;">Producto</th>
                        <th style="padding: 10px; text-align: center;">Precio Medio</th>
                        <th style="padding: 10px; text-align: center;">Kg Totales</th>
                        <th style="padding: 10px; text-align: center;">Importe Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color: transparent; text-align: center;">
                        <td style="padding: 10px; color: #34b572;"><strong>{{ $productos[$productoSeleccionado] }}</strong></td>
                        <td style="padding: 10px; color: #34b572;">{{ number_format($totales['precio_medio'], 2) }} €</td>
                        <td style="padding: 10px; color: #34b572;">{{ number_format($totales['kg'], 2) }} kg</td>
                        <td style="padding: 10px; color: #34b572;">{{ number_format($totales['importe'], 2) }} €</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        






    @elseif($productoSeleccionado)
        <p>No hay datos disponibles para el producto seleccionado.</p>
    @endif
</div>
@endsection
