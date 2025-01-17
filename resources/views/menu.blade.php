@extends('layouts.app')

@section('content')

@php
    $user = Auth::user();
@endphp

@section('styles')
<style>
    /* Estilo del circulito en la esquina superior derecha */
    .nav-item {
        position: relative; /* Esto asegura que el contenedor esté bien posicionado, sin afectar la alineación */
    }

</style>
@endsection

<nav class="navbar">
    <div class="container">
        <ul class="navbar-nav flex-column d-flex justify-content-center align-items-stretch w-100">
            <a class="navbar-item mb-3 text-center" style="font-size: 2em; color:white"><b>CampSur</b></a>
            @if ($user && $user->role === 'admin')
                {{-- Solo si se quiere poner algún día (Solo Administradores) --}}
                {{-- <li class="nav-item mb-3">
                    <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg w-100">Gestionar Clientes</a>
                </li> --}}
                <li class="nav-item mb-3">
                    <a href="{{ route('notificaciones.create') }}" class="btn btn-primary btn-lg w-100" style="color:rgb(4, 100, 51; background-color:white">Crear Notificaciones</a>
                </li>
                <li class="nav-item mb-3">
                    <a href="{{ route('comunicados.create') }}" class="btn btn-primary btn-lg w-100" style="color:rgb(4, 100, 51; background-color:white">Crear Comunicados</a>
                </li>
            @endif
            <li class="nav-item mb-3">
                <a href="{{ route('notificaciones.index') }}" class="btn btn-primary btn-lg w-100">
                    Notificaciones
                    @if($noLeidas > 0)
                        <span class="badge">
                            {{ $noLeidas }}
                        </span>
                    @endif
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('comunicados.index') }}" class="btn btn-primary btn-lg w-100">Comunicados</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('albaranes') }}" class="btn btn-primary btn-lg w-100">Albaranes</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('previsionesCorte') }}" class="btn btn-primary btn-lg w-100">Previsiones de Corte</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('movimientos.envase.palet', $user->CODIGO) }}" class="btn btn-primary btn-lg w-100">Estado de Envases</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('product.graph') }}" class="btn btn-primary btn-lg w-100">Gráficas</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('modelo-347') }}" class="btn btn-primary btn-lg w-100">Modelo 347 - {{ date('Y') - 1 }}</a>
            </li>
        </ul>
    </div>
</nav>

@endsection
