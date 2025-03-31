<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Mito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/19e62de92e.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: 'Oswald', sans-serif;
            padding-top: 70px;
        }
        .carousel-item {
            height: 100vh;
            position: relative;
        }
        .carousel-item img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            filter: brightness(0.7);
        }
        .carousel-caption {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .carousel-caption h1 {
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px black;
        }
        .btn-cta {
            background-color: white;
            color: black;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 25px;
            text-decoration: none;
        }
        .btn-cta:hover {
            background-color: #B22222;
            color: white;
        }
        .simplybook-widget-button {
            position: fixed;
            right: 20px;
            bottom: 55%;
            padding: 15px 25px;
            background-color: rgb(255, 198, 43);
            color: rgb(0, 0, 0);
            font-size: 16px;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
            z-index: 9999;
        }
        .simplybook-widget-button:hover {
            background-color: rgb(255, 165, 0);
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg,rgb(128, 21, 21), #8B0000);">
    <div class="container">
        <a class="navbar-brand" href="Index.php" style="font-size: 30px; font-style: italic;">Barbería Mito</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="Index.php" style="font-size: 22px;">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="../vista/registro.php" style="font-size: 22px;">Personal</a></li>
                <li class="nav-item"><a class="nav-link" href="../vista/Servicios.php" style="font-size: 22px;">Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="Vista/Contacto.php" style="font-size: 22px;">Contacto</a></li>
           

                <li class="nav-item">
    <a class="nav-link btn btn-danger text-white px-3" href="../Controlador/Cerrar_sesion.php" style="font-size: 22px;">Cerrar Sesión</a>
</li>
            </ul>
        </div>
    </div>
</nav>

<div class="simplybook-widget-button right">
    <div>Agendar cita</div>
</div>

<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="Imag/1 (1).jpeg" alt="Corte Profesional">
            <div class="carousel-caption">
                <h1>Déjate consentir por nuestros barberos</h1>
            </div>
        </div>
        <div class="carousel-item">
            <img src="Imag/1 (2).jpeg" alt="Barbería Premium">
            <div class="carousel-caption">
                <h1>Estilo único, cortes de calidad</h1>
            </div>
        </div>
        <div class="carousel-item">
            <img src="Imag/1 (3).jpeg" alt="Experiencia Profesional">
            <div class="carousel-caption">
                <h1>Transforma tu look con los mejores</h1>
            </div>
        </div>
    </div>
</div>
<?php
require '../modelo/config.php'; // Conexión a la base de datos
?>

<section class="container my-5 text-center">
    <h2 class="text-center mb-4">Nuestros Servicios</h2>
    <div class="row justify-content-center">
        <?php
        $sql = "SELECT nombre, precio, imagen FROM servicios";
        $result = $conn->query($sql);

        while ($servicio = $result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card bg-dark text-white text-center">';
            echo '<img src="vista/Imag' . $servicio['imagen'] . '" class="card-img-top" alt="' . $servicio['nombre'] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $servicio['nombre'] . '</h5>';
            echo '<p class="card-text"><strong>$' . number_format($servicio['precio'], 2) . '</strong></p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
