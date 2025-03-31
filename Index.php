<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Mito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/19e62de92e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="vistacliente/assets/Estilos.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS + Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Barra de navegación (Header) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="Index.php">Barbería Mito</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="Index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="vistacliente/Servicios.php">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="vistacliente/Contacto.php">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="vistacliente/Nosotros.php">Nosotros</a></li>
                </ul>
                <!-- Botón de carrito -->
                <a href="vistacliente/Carrito.php" class="btn btn-light me-2">
                    <i class="fas fa-shopping-cart"></i> Carrito
                </a>
                <!-- Botón de inicio de sesión alineado a la derecha -->
                <a href="../barberia/vista/Login.php" class="btn btn-warning text-dark fw-bold px-4">Iniciar Sesión</a>
            </div>
        </div>
    </nav>

    <!-- Carrusel de imágenes -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="20000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../Barberia/vista/Imag/1 (1).jpeg" class="d-block w-100" alt="Corte Profesional">
                <div class="carousel-caption">
                    <h1>Déjate consentir por nuestros barberos</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="vista/Imag/2 (1).jpeg" class="d-block w-100" alt="Barbería Premium">
                <div class="carousel-caption">
                    <h1>Estilo único, cortes de calidad</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="vista/Imag/1 (3).jpeg" class="d-block w-100" alt="Experiencia Profesional">
                <div class="carousel-caption">
                    <h1>Transforma tu look con los mejores</h1>
                </div>
            </div>
        </div>

        <!-- Botones de navegación del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <style>
        .carousel-caption {
            top: 50%;
            transform: translateY(-50%);
        }
    </style>

    <script src="/vistacliente/assets/scripts.js"></script> <!-- Archivo JS separado -->
</body>
</html>
