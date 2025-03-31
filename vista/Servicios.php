<?php
session_start();
require '../modelo/config.php'; // Archivo de conexión a la base de datos
// Función para registrar en el archivo log y en la base de datos
function registrarLog($tipo, $accion, $usuario) {
    global $conn;

    // Guardar en archivo log.txt
    $logfile = 'log.txt';
    $fecha = date("Y-m-d H:i:s");
    $log = "[$fecha] [$tipo] [$usuario] - $accion\n";
    file_put_contents($logfile, $log, FILE_APPEND);

    // Guardar en la base de datos
    $sql = "INSERT INTO logs (tipo, accion, usuario, fecha) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $tipo, $accion, $usuario, $fecha);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Elite</title>
    <link rel="stylesheet" href="../vista/assets/estilo.css">
    <script>
        function toggleFormulario() {
            var formulario = document.getElementById("formularioAgregar");
            formulario.style.display = (formulario.style.display === "none" || formulario.style.display === "") ? "block" : "none";
        }

        function mostrarFormularioEdicion(id, nombre, precio) {
            document.getElementById("formularioEditar").style.display = "block";
            document.getElementById("servicio_id").value = id;
            document.getElementById("nombre_editar").value = nombre;
            document.getElementById("precio_editar").value = precio;
        }
    </script>
</head>
<body>
    <header>Barbería Mito</header>
    
    <nav>
        <a href="index.php">Inicio</a>
    </nav>
    
    <button class="btn-agregar" onclick="toggleFormulario()">Agregar Servicio</button>

    <div class="form-container" id="formularioAgregar" style="display: none;">
        <h2>Agregar Servicio</h2>
        <form action="../Controlador/subir_producto.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre del servicio" required>
            <input type="number" step="0.01" name="precio" placeholder="Precio" required>
            <input type="file" name="imagen" required>
            <button type="submit">Subir Servicio</button>
        </form>
    </div>

    <div class="container">
        <h2>Nuestros Servicios</h2>
        <div class="galeria-container">
            <?php
            $sql = "SELECT * FROM servicios";
            $result = $conn->query($sql);
            while ($servicio = $result->fetch_assoc()) {
                echo "<div class='servicio'>";
                echo "<img src='" . $servicio['imagen'] . "' alt='" . $servicio['nombre'] . "'>";
                echo "<p>" . $servicio['nombre'] . "</p>";
                echo "<p>$" . number_format($servicio['precio'], 2) . "</p>";
                echo "<button class='btn-eliminar' onclick=\"window.location.href='../Controlador/eliminar_producto.php?id=" . $servicio['id'] . "'\">Eliminar</button>";
                echo "<button class='btn-modificar' onclick=\"mostrarFormularioEdicion('" . $servicio['id'] . "', '" . $servicio['nombre'] . "', '" . $servicio['precio'] . "')\">Modificar</button>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <style>
        .galeria-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .servicio {
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 10px;
            background: #f9f9f9;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .servicio img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .servicio p {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
    <div class="form-container" id="formularioEditar" style="display: none;">
        <h2>Modificar Servicio</h2>
        <form action="../Controlador/modificar_producto.php" method="POST">
            <input type="hidden" id="servicio_id" name="id">
            <input type="text" id="nombre_editar" name="nombre" placeholder="Nombre del servicio" required>
            <input type="number" id="precio_editar" name="precio" step="0.01" placeholder="Precio" required>
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
