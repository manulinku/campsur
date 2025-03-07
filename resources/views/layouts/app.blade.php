<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Start cookieyes banner --> <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/6d7dccda27faab05ad067ad6/script.js"></script> <!-- End cookieyes banner -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CampSur') }}</title>

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    

    <style>
        .navbar-brand {
            float: left;
            color: white !important;
        }
        .navbar-nav {
            float: right;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dropdown-item:hover {
            color: white !important; /* Color al pasar el ratón por encima */
            /* left: -20px !important */
        }
        @media (max-width: 576px) {
            .nav-item {
                left: -20px !important; /* Ajusta este valor según el desplazamiento necesario */
            }
            
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: white !important;">
            <div class="container">
                <a href="{{ url('/menu') }}" style="color:#046433">
                    <img src="{{ asset('/images/logo.png') }}" alt="Logo" style="width: 60px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-navbar-collapse" aria-controls="app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <!-- Left Side Of Navbar -->
                        &nbsp;
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <!-- Right Side Of Navbar -->
                        @guest
                            <li class="nav-item">
                                <span class="nav-link" style="color: #046433;">Inicie sesión para acceder a sus datos<br>Horario de Almacén: L-V: 9:30-19:30 &nbsp;&nbsp;Sábados: 9:30-13:00</span>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-primary" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white !important;">
                                    {{ Auth::user()->NOMBRE }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #046433 !important;">
                                    <a class="dropdown-item btn btn-primary" href="{{ route('menu') }}">Menu</a>
                                    <a class="dropdown-item btn btn-primary" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endguest
                        
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>