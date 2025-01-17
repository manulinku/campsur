@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
    <h1>Comunicados</h1>
    <!-- Botón para volver al menú principal con icono -->
    <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 1rem; right: 1rem;">
        <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
        Volver
    </a>

    @if ($comunicados->isEmpty())
        <p>No hay comunicados disponibles.</p>
    @else
        <ul class="list-group">
            @foreach ($comunicados as $comunicado)
    <li class="list-group-item d-flex justify-content-between align-items-center mb-3">
        <div>
            <strong>{{ $comunicado->titulo }}</strong>
            <p>{{ $comunicado->contenido }}</p>
        
            <!-- Mostrar las imágenes si existen -->
            @if ($comunicado->imagenes)
                @php
                    $imagenes = json_decode($comunicado->imagenes); // Decodificar JSON
                @endphp
                <div class="mt-2">
                    @foreach ($imagenes as $imagen)
                        <!-- Enlace para abrir la imagen en nueva pestaña -->
                        <a href="{{ asset('storage/' . $imagen) }}" target="_blank">
                            <img src="{{ asset('storage/' . $imagen) }}" alt="Imagen del comunicado" class="img-fluid mb-2" style="max-height: 200px; object-fit: cover;">
                        </a>
                    @endforeach
                </div>
            @endif

            <small class="text-muted">
                Publicado el {{ \Carbon\Carbon::parse($comunicado->fecha_publicacion)->setTimezone('Europe/Madrid')->format('d/m/Y H:i') }}
            </small>
        </div>

        <!-- Solo mostrar el botón de eliminación si el usuario es admin -->
        @if(auth()->user()->role === 'admin')
            <form action="{{ url('comunicados/'.$comunicado->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este comunicado?')">
                <!-- Campo csrf -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- Método DELETE -->
                <input type="hidden" name="_method" value="DELETE">

                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
        @endif
    </li>
@endforeach

        </ul>
    @endif
</div>
@endsection
