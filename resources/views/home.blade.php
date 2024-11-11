{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Campsur - Empresa Hortofrutícola dedicada a ofrecer los mejores productos frescos.">
    <title>Campsur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    @include('partials/header')

    <style>
        /* Estilos de escritorio (sin cambios) */
        
        .hero-image {
            background-image: url('{{ asset('images/imagen-principal-frontend.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 800px;
            position: relative;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-right: 20px;
        }
        
        .hero-text {
            color: #046433;
            text-align: right;
            margin-right: 250px;
        }

        .info-boxes {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            max-width: calc(100% - 700px);
            margin: 0 auto;
            position: relative;
            top: -50px;
        }

        .info-box {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Cambios específicos para dispositivos móviles/tablets */
    @media (max-width: 1366px) {
        .hero-image {
            height: 400px;
            padding-right: 10px;
        }

        .hero-text {
            margin-right: 0;
            text-align: center;
        }

        .hero-text h1 {
            font-size: 2.5rem;
        }

        .hero-text h2 {
            font-size: 1.5rem;
        }

        .info-boxes {
            flex-direction: column;
            gap: 10px;
            top: 0;
            max-width: 100%;
        }

        /* Ajustes para la sección 'Nos presentamos' en móvil */
        .nosotros-section .container-fluid {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .imagenes-container {
            order: -1;
            margin-bottom: 20px;
        }

        .img-grande {
            width: 240px !important;  /* Ajusta el tamaño de la imagen grande en móvil */
            height: 240px !important; /* Ajusta el tamaño de la imagen grande en móvil */
            border-radius: 50%; /* Asegura que la imagen sea redonda */
        }

        .img-pequena {
            display: none; /* Oculta la imagen pequeña en dispositivos móviles */
        }

        .texto-container {
            text-align: center;
        }

        /* Ajustes para la sección 'QUÉ TE OFRECEMOS' en móvil */
        .offer-section .d-flex {
            flex-direction: column;
            align-items: center;
        }

        .offer-box {
            width: 100%;
            margin-bottom: 10px;
            text-align: center;
        }
    }
    </style>
</head>
<body>
    <section class="hero-image">
        <div class="hero-text">
            <h1>CAMPSUR</h1>
            <h2>Sabor Natural</h2>
        </div>
    </section>

    <!-- Sección de recuadros -->
    <section class="info-boxes">
        <div class="info-box">
            <h3>Texto 1</h3>
        </div>
        <div class="info-box">
            <h3>Texto 2</h3>
        </div>
        <div class="info-box">
            <h3>Texto 3</h3>
        </div>
    </section>

    <!-- Sección Nos Presentamos -->
    <section class="nosotros-section d-flex align-items-center" style="padding: 50px 0;">
        <div class="container-fluid d-flex">
            <div class="imagenes-container position-relative" style="flex: 1; display: flex; justify-content: center;">
                <img src="{{ asset('images/imagen-principal-frontend.jpg') }}" class="img-grande img-fluid rounded-circle" alt="Imagen grande" style="width: 500px; height: auto;">
                <img src="{{ asset('images/imagen-principal-frontend.jpg') }}" class="img-pequena img-fluid rounded-circle position-absolute" alt="Imagen pequeña" style="width: 200px; height: 200px; bottom: -20px; left: 10%;">
            </div>
            <div class="texto-container" style="flex: 1; color: #046433">
                <h1 class="display-4">Nos presentamos</h1>
                <p style="font-size: 1.2rem; margin-top: 20px;">Grupo Camp Sur es una productora y comercializadora de verduras en Almería, formada por un equipo joven pero con amplia experiencia. Nos dedicamos a cultivar y producir alimentos de alta calidad, saludables y sostenibles, respetando las formas tradicionales de la agricultura. Ofrecemos productos frescos, garantizando lo mejor de la tierra al consumidor final.</p>
                <h1 class="display-4">¿Nuestro Compromiso?</h1><i>"Llevar lo mejor de Almería directamente a tu mesa"</i>
                <p style="font-size: 1.2rem; margin-top: 20px;">En cada producto que seleccionamos, se refleja la pasión por nuestra tierra. Desde los frescos campos Almerienses hasta tu hogar, nos esforzamos por ofrecer calidad, frescura y autenticidad en cada entrega. Nuestro compromiso no es solo con el sabor, sino con la sostenibilidad y el respeto al entorno. Disfruta de la riqueza de nuestros productos, cultivados con el esfuerzo de agricultores locales, y siente la esencia de Almería en cada bocado.</p>
            </div>
        </div>
    </section>

    <!-- Sección QUÉ TE OFRECEMOS -->
    <section class="container offer-section">
        <h2>QUÉ TE OFRECEMOS</h2>
        <div class="d-flex justify-content-center">
            <div class="offer-box">
                <h3>Texto 1</h3>
            </div>
            <div class="offer-box">
                <h3>Texto 2</h3>
            </div>
            <div class="offer-box">
                <h3>Texto 3</h3>
            </div>
            <div class="offer-box">
                <h3>Texto 4</h3>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@include('partials/footer')
</html> --}}
