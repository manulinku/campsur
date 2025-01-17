@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
    <h1>Crear Comunicado</h1>
    <!-- Botón para volver al menú principal con icono -->
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

    <!-- Formulario para crear el comunicado -->
    <form action="{{ route('comunicados.store') }}" method="POST" enctype="multipart/form-data" style="background-color: white; border-radius: 5px;">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="titulo">&nbsp;Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}">
        </div>

        <div class="form-group">
            <label for="contenido">&nbsp;Contenido</label>
            <textarea name="contenido" class="form-control">{{ old('contenido') }}</textarea>
        </div>

        <div class="form-group">
            <label for="imagenes">&nbsp;Imágenes</label>
            <input type="file" name="imagenes[]" class="form-control" multiple>
            <small class="form-text text-muted">(Imagen de máximo 2MB).</small>
        </div>

        <button type="submit" class="btn btn-primary">&nbsp;Crear Comunicado</button>
    </form>
</div>
@endsection
