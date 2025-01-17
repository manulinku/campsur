@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
    <h1>Mis Notificaciones</h1>
    <!-- Botón para volver a todos los albaranes con icono -->
    <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 1rem; right: 1rem;">
        <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
        Volver
    </a>

    @if ($notificaciones->isEmpty())
        <p>No tienes notificaciones.</p>
    @else
        <ul class="list-group">
            @foreach ($notificaciones as $notificacion)
                <li class="list-group-item d-flex justify-content-between align-items-center mb-3 {{ $notificacion->visto ? 'bg-light' : '' }}">
                    <div>
                        <strong>{{ $notificacion->titulo }}</strong>
                        <p>{{ $notificacion->mensaje }}</p>
                        <small class="text-muted">
                            Recibida el {{ \Carbon\Carbon::parse($notificacion->created_at)->setTimezone('Europe/Madrid')->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    @if (!$notificacion->visto)
                        <form action="{{ route('notificaciones.read', $notificacion->id) }}" method="POST">
                            {{ csrf_field() }} <!-- Usando csrf_field() en lugar de @csrf -->
                            {{ method_field('PATCH') }} <!-- Usando method_field() en lugar de @method -->
                            <button type="submit" class="btn btn-sm btn-success">Marcar como leída</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
