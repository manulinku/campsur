@extends('layouts.app')

@section('content')

@php
    $user = Auth::user();
@endphp

<nav class="navbar">
    <div class="container">
        {{-- <a class="navbar-brand" href="#">Campsur</a> --}}
        <ul class="navbar-nav flex-column d-flex justify-content-center align-items-stretch w-100">
            <a class="navbar-item mb-3 text-center" style="font-size: 2em; color:white"><b>CampSur</b></a>
            @if ($user && $user->role === 'admin')
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg w-100">Gestionar Clientes</a>
            </li>
            @endif
            <li class="nav-item mb-3">
                <a href="{{ route('albaranes') }}" class="btn btn-primary btn-lg w-100">Albaranes</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('facturas') }}" class="btn btn-primary btn-lg w-100">Facturas</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg w-100">Facturas Cargo</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg w-100">Pagos</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg w-100">Estadísticas</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg w-100">Comunicaciones</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg w-100">Notificaciones</a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-lg w-100">Previsiones de Corte</a>
            </li>
        </ul>
    </div>
</nav>
@endsection