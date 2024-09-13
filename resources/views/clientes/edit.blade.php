@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Cliente</h1>

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

        <form action="{{ route('clientes.update', $cliente->CODIGO) }}" method="POST">
            {{ csrf_field() }}
            
            <div class="form-group">
                <label for="NOMBRE">Nombre</label>
                <input type="text" name="NOMBRE" class="form-control" value="{{ $cliente->NOMBRE }}">
            </div>

            <div class="form-group">
                <label for="PAIS">País</label>
                <input type="text" name="PAIS" class="form-control" value="{{ $cliente->PAIS }}">
            </div>

            <div class="form-group">
                <label for="TIPOCLI">Tipo de Cliente</label>
                <input type="text" name="TIPOCLI" class="form-control" value="{{ $cliente->TIPOCLI }}">
            </div>

            <div class="form-group">
                <label for="PUNTOVENTA">Punto de Venta</label>
                <input type="text" name="PUNTOVENTA" class="form-control" value="{{ $cliente->PUNTOVENTA }}">
            </div>

            <div class="form-group">
                <label for="AGENTE">Agente</label>
                <input type="text" name="AGENTE" class="form-control" value="{{ $cliente->AGENTE }}">
            </div>

            <div class="form-group">
                <label for="CODSEGURO">Código de Seguro</label>
                <input type="text" name="CODSEGURO" class="form-control" value="{{ $cliente->CODSEGURO }}">
            </div>

            <div class="form-group">
                <label for="SOLVENCIA">Solvencia</label>
                <input type="text" name="SOLVENCIA" class="form-control" value="{{ $cliente->SOLVENCIA }}">
            </div>

            <div class="form-group">
                <label for="RSOLICITADO">R Solicitado</label>
                <input type="text" name="RSOLICITADO" class="form-control" value="{{ $cliente->RSOLICITADO }}">
            </div>

            <div class="form-group">
                <label for="RCONCEDIDO">R Concedido</label>
                <input type="text" name="RCONCEDIDO" class="form-control" value="{{ $cliente->RCONCEDIDO }}">
            </div>

            <div class="form-group">
                <label for="COD_UN">Código UN</label>
                <input type="text" name="COD_UN" class="form-control" value="{{ $cliente->COD_UN }}">
            </div>

            <div class="form-group">
                <label for="CIF">CIF</label>
                <input type="text" name="CIF" class="form-control" value="{{ $cliente->CIF }}">
            </div>

            <div class="form-group">
                <label for="KMTOTAL">KM Total</label>
                <input type="text" name="KMTOTAL" class="form-control" value="{{ $cliente->KMTOTAL }}">
            </div>

            <div class="form-group">
                <label for="KMFRONTERA">KM Frontera</label>
                <input type="text" name="KMFRONTERA" class="form-control" value="{{ $cliente->KMFRONTERA }}">
            </div>

            <div class="form-group">
                <label for="PRKMINT">PR KMINT</label>
                <input type="text" name="PRKMINT" class="form-control" value="{{ $cliente->PRKMINT }}">
            </div>

            <div class="form-group">
                <label for="PASSWORD">Nueva Contraseña</label>
                <input type="password" name="PASSWORD" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Guardar cambios</button>
        </form>
    </div>
@endsection
