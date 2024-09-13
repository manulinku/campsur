@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Clientes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->CODIGO }}</td>
                        <td>{{ $cliente->NOMBRE }}</td>
                        <td>
                            <a href="{{ route('clientes.edit', $cliente->CODIGO) }}" class="btn btn-primary">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
