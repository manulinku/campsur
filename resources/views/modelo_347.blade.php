@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container my-4 p-4" style="color:black; background-color: white; border-radius: 1em; position:relative;">
        <h2>Modelo 347</h2>
        <a href="{{ route('menu') }}" class="btn btn-primary" style="position: absolute; top: 1rem; right: 1rem;">
            <i class="fa-solid fa-arrow-rotate-left" style="margin-right: 0.5rem;"></i>
            Volver
        </a>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tipo IVA</th>
                    <th>Título</th>
                    <th>CP</th>
                    <th>Provincia</th>
                    <th>Importe</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datos as $dato)
                    <tr>
                        <td>{{ $dato['tipoiva'] }}</td>
                        <td>{{ $dato['titulo'] }}</td>
                        <td>{{ $dato['cpcli'] }}</td>
                        <td>{{ $dato['provincia'] }}</td>
                        <td>{{ $dato['importe'] }}</td>
                        <td>{{ $dato['q1'] }}</td>
                        <td>{{ $dato['q2'] }}</td>
                        <td>{{ $dato['q3'] }}</td>
                        <td>{{ $dato['q4'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No hay datos disponibles para tu NIF.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
