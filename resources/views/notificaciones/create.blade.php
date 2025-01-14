@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
        <h1>Crear Notificacion</h1>
        <!-- Botón para volver a todos los albaranes con icono -->
        <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 1rem; right: 1rem;">
            <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
            Volver
        </a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notificaciones.store') }}" method="POST" style="background-color: white; border-radius: 5px;">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="titulo">&nbsp;Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}">
            </div>

            <div class="form-group">
                <label for="mensaje">&nbsp;Mensaje</label>
                <textarea name="mensaje" class="form-control">{{ old('mensaje') }}</textarea>
            </div>

            <div class="form-group">
                <label for="user_id">&nbsp;Usuario</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">---- SELECCIONA UN CLIENTE ----</option>
                     <!-- Opción vacía por defecto -->
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->CODIGO }}" {{ old('user_id') == $cliente->CODIGO ? 'selected' : '' }}>
                            {{ $cliente->NOMBRE }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">&nbsp;Crear Notificación</button>
        </form>
    </div>
@endsection
