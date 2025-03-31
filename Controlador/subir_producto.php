<?php
session_start();
require '../modelo/config.php'; // Conexión a la base de datos

// Función para registrar log en archivo
function registrarLogArchivo($tipo, $accion, $usuario) {
    $logfile = 'log.txt';
    $fecha = date("Y-m-d H:i:s");
    $log = "[$fecha] [$tipo] [$usuario] - $accion\n";
    file_put_contents($logfile, $log, FILE_APPEND);
}

// Función para registrar log en base de datos
function registrarLogDB($tipo, $accion, $usuario) {
    global $conn;
    $sql = "INSERT INTO logs (tipo, accion, usuario, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $tipo, $accion, $usuario);
    $stmt->execute();
}

// Verificación CSRF (Si se implementa un token de sesión)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    // Validación de datos de entrada
    $nombre = trim($_POST["nombre"]);
    $precio = filter_var($_POST["precio"], FILTER_VALIDATE_FLOAT);
    $carpetaDestino = "../subimag/"; // Carpeta donde se guardarán las imágenes

    // Verificar si la carpeta 'subimag' existe, si no, crearla
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true); // Crear carpeta con permisos adecuados
    }

    // Verificar que el archivo sea una imagen válida
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
        $imagenTipo = mime_content_type($_FILES["imagen"]["tmp_name"]);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($imagenTipo, $tiposPermitidos)) {
            $imagen = $carpetaDestino . basename($_FILES["imagen"]["name"]);
            $usuario = isset($_SESSION["user"]) ? $_SESSION["user"] : "Desconocido";

            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagen)) {
                // Insertar datos en la base de datos
                $sql = "INSERT INTO servicios (nombre, precio, imagen) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sds", $nombre, $precio, $imagen);

                if ($stmt->execute()) {
                    registrarLogArchivo("Aviso", "Producto agregado: $nombre", $usuario);
                    registrarLogDB("Aviso", "Producto agregado: $nombre", $usuario);
                    header("Location:../vista/Index.php");
                } else {
                    registrarLogArchivo("Error", "Error al agregar producto: $nombre", $usuario);
                    registrarLogDB("Error", "Error al agregar producto: $nombre", $usuario);
                }
            } else {
                registrarLogArchivo("Error", "Error al subir la imagen de $nombre", $usuario);
                registrarLogDB("Error", "Error al subir la imagen de $nombre", $usuario);
            }
        } else {
            registrarLogArchivo("Error", "El archivo no es una imagen válida", $usuario);
            registrarLogDB("Error", "El archivo no es una imagen válida", $usuario);
        }
    } else {
        registrarLogArchivo("Error", "No se recibió una imagen válida", $usuario);
        registrarLogDB("Error", "No se recibió una imagen válida", $usuario);
    }
} else {
    echo "Solicitud no válida o CSRF token inválido.";
}
?>
