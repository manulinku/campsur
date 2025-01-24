@extends('layouts.app')

@section('content')
<div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
    <h1>Crear Notificación</h1>
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

    <form action="{{ route('notificaciones.store') }}" method="POST" enctype="multipart/form-data" style="background-color: white; border-radius: 5px;">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="titulo">&nbsp;Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}">
        </div>

        <div class="form-group">
            <label for="mensaje">&nbsp;Mensaje</label>
            <textarea name="mensaje" class="form-control">{{ old('mensaje') }}</textarea>
        </div>

        <div class="form-group" style="position: relative;">
            <label for="user_id">&nbsp;Usuario</label>
            <input type="text" id="user_search" name="user_id" class="form-control" value="{{ old('user_id') }}" placeholder="Escribe para buscar cliente...">
            <div id="autocomplete-results" class="autocomplete-results"></div>
            <!-- Campo oculto para almacenar el ID del cliente seleccionado -->
            <input type="hidden" id="selected_user_id" name="user_id" value="{{ old('user_id') }}">
        </div>

        <!-- Campo para cargar imágenes -->
        <div class="form-group">
            <label for="imagenes">&nbsp;Imágenes</label>
            <input type="file" name="imagenes[]" class="form-control" multiple>
            <small class="form-text text-muted">(Imagen de máximo 2MB).</small>
        </div>

        <button type="submit" class="btn btn-primary">&nbsp;Crear Notificación</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#user_search").keyup(function () {
            var query = $(this).val();

            if (query.length > 2) {
                $.ajax({
                    url: "{{ route('clientes.autocomplete') }}",
                    data: { term: query },
                    success: function (data) {
                        $("#autocomplete-results").empty();
                        $("#autocomplete-results").append(data);
                    }
                });
            } else {
                $("#autocomplete-results").empty();
            }
        });

        $(document).on('click', '.autocomplete-item', function() {
            var clientName = $(this).text();
            var clientId = $(this).data('id');

            $("#user_search").val(clientName);
            $("#selected_user_id").val(clientId);
            $("#autocomplete-results").empty();
        });
    });
</script>
@endsection
