<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampSur</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0; /* Elimina márgenes del body */
            padding: 0; /* Elimina relleno del body */
        }
        .logo-container {
            text-align: center;
            margin: 20px 0;
        }
        .logo {
            max-width: 100%; /* Para que se ajuste al ancho de la pantalla */
            height: auto; /* Mantiene la proporción */
        }
        /* Estilos para el div de desarrollo */
        .development-message {
            background-color: #f8d7da; /* Color de fondo ligero */
            color: #721c24; /* Color de texto */
            padding: 15px;
            text-align: center;
            margin: 20px 0;
            border: 1px solid #f5c6cb; /* Borde con color más oscuro */
            border-radius: 5px; /* Esquinas redondeadas */
            font-size: 1.2em; /* Tamaño de fuente */
        }
    </style>
</head>
<body>
    <div class="container-fluid"> <!-- Cambié 'container' a 'container-fluid' -->
        <!-- Logo de la empresa -->
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo de la Empresa" class="img-fluid logo">
        </div>

        <!-- Tarjetas de los comerciales -->
        <div class="row">
            <div class="col-12 col-md-4 mb-4"> <!-- Cada tarjeta ocupará 12 columnas en móviles y 4 en pantallas medianas -->
                <div class="card">
                    <img src="{{ asset('images/juan.jpg') }}" class="card-img-top img-fluid" alt="Juan Franciasco César">
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4"> <!-- Cada tarjeta ocupará 12 columnas en móviles y 4 en pantallas medianas -->
                <div class="card">
                    <img src="{{ asset('images/albert.jpg') }}" class="card-img-top img-fluid" alt="Albert Martínez Ortells">
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4"> <!-- Cada tarjeta ocupará 12 columnas en móviles y 4 en pantallas medianas -->
                <div class="card">
                    <img src="{{ asset('images/jesus.jpg') }}" class="card-img-top img-fluid" alt="Jesús López">
                </div>
            </div>
        </div>

        <!-- Mensaje de desarrollo -->
        <div class="development-message">
            <strong>¡Página en desarrollo!</strong> Estamos trabajando en mejoras. Gracias por su paciencia.
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
