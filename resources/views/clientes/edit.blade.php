@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="background-color: rgba(255, 255, 255, 0.9); border-radius: 5px;">Editar Cliente</h1>

        @if(session('success'))
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

        <form action="{{ route('clientes.update', $cliente->CODIGO) }}" method="POST"  style="background-color: rgba(255, 255, 255, 0.9); border-radius: 5px;">
            {{ csrf_field() }}
            
            <div class="form-group">
                <label for="NOMBRE">&nbsp;Nombre</label>
                <input type="text" name="NOMBRE" class="form-control" value="{{ $cliente->NOMBRE }}">
            </div>

            <div class="form-group">
                <label for="PAIS">&nbsp;País</label>
                <input type="text" name="PAIS" class="form-control" value="{{ $cliente->PAIS }}">
            </div>

            <div class="form-group">
                <label for="TIPOCLI">&nbsp;Tipo de Poveedor</label>
                <input type="text" name="TIPOCLI" class="form-control" value="{{ $cliente->TIPOPROV }}">
            </div>

            <div class="form-group">
                <label for="PUNTOVENTA">&nbsp;Punto de Venta</label>
                <input type="text" name="PUNTOVENTA" class="form-control" value="{{ $cliente->PUNTOVENTA }}">
            </div>

            <div class="form-group">
                <label for="COD_UN">&nbsp;Código UN</label>
                <input type="text" name="COD_UN" class="form-control" value="{{ $cliente->COD_UN }}">
            </div>

            <div class="form-group">
                <label for="CIF">&nbsp;CIF</label>
                <input type="text" name="CIF" class="form-control" value="{{ $cliente->CIF }}">
            </div>

            <div class="form-group">
                <label for="COD_UN2">&nbsp;Código UN2</label>
                <input type="text" name="COD_UN" class="form-control" value="{{ $cliente->COD_UN2 }}">
            </div>
             
            <div class="form-group">
                <label for="KMTOTAL">&nbsp;KM Total</label>
                <input type="text" name="KMTOTAL" class="form-control" value="{{ $cliente->KMTOTAL }}">
            </div>

            <div class="form-group">
                <label for="KMFRONTERA">&nbsp;KM Frontera</label>
                <input type="text" name="KMFRONTERA" class="form-control" value="{{ $cliente->KMFRONTERA }}">
            </div>

            <div class="form-group">
                <label for="PRKMINT">&nbsp;PR KMINT</label>
                <input type="text" name="PRKMINT" class="form-control" value="{{ $cliente->PRKMINT }}">
            </div>

            <div class="form-group">
                <label for="PASSWORD">&nbsp;Nueva Contraseña</label>
                <input type="password" name="PASSWORD" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">&nbsp;Guardar cambios</button>
        </form>
    </div>
@endsection
