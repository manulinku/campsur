@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
    <h1>Notificaciones</h1>
    <!-- Botón para volver al menú principal con icono -->
    <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 1rem; right: 1rem;">
        <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
        Volver
    </a>

    @if ($notificaciones->isEmpty())
        <p>No hay notificaciones disponibles.</p>
    @else
        <ul class="list-group">
            @foreach ($notificaciones as $notificacion)
            <li class="list-group-item d-flex justify-content-between align-items-center mb-3">
                <div>
                    <strong>{{ $notificacion->titulo }}</strong>
                    <p>{{ $notificacion->mensaje }}</p>

                    <!-- Mostrar las imágenes si existen -->
                    @if ($notificacion->imagenes)
                        @php
                            $imagenes = json_decode($notificacion->imagenes); // Decodificar el JSON
                        @endphp
                        <div class="mt-2">
                            @foreach ($imagenes as $imagen)
                                <a href="{{ asset('storage/' . $imagen) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $imagen) }}" alt="Imagen de la notificación" class="img-fluid mb-2" style="max-height: 200px; object-fit: cover;">
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <small class="text-muted">
                        Enviado el {{ \Carbon\Carbon::parse($notificacion->created_at)->setTimezone('Europe/Madrid')->format('d/m/Y H:i') }}
                        
                        @if(auth()->user()->role === 'admin')
                            a {{ optional($notificacion->user)->NOMBRE ?? 'Desconocido' }}
                        @endif
                    </small>
                </div>

                @if(auth()->user()->role === 'admin')
                    <form action="{{ url('notificaciones/'.$notificacion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta notificación?')">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
