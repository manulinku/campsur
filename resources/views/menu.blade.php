@extends('layouts.app')

@section('content')

@php
    $user = Auth::user();
@endphp

<nav class="navbar" >
    <div class="container">
        {{-- <a class="navbar-brand" href="#">NATURVEGA</a> --}}
        <ul class="navbar-nav flex-column d-flex justify-content-center align-items-center">
            <a class="navbar-item mb-3" style="font-size: 2em; color:white"><b>Camp Sur</b></a>
            @if ($user && $user->role === 'admin')
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Gestionar Clientes</a>
            </li>
            @endif
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Albaranes</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Facturas</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Facturas Cargo</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Pagos</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Estadísticas</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Comunicaciones</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Notificaciones</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Cajas y Palets</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg">Previsiones de Corte</a>
            </li>
            
        </ul>
    </div>
</nav>
@endsection
