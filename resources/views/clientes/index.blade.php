@extends('layouts.app')

@section('content')
    <div class="container">
        
        <table class="table"  style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
            <h1 style="background-color: rgba(255, 255, 255, 0.9); border-radius: 5px;">Lista de Clientes</h1>
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
