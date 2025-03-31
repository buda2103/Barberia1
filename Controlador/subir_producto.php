<?php
session_start();
require '../modelo/config.php'; // Conexión a la base de datos

function registrarLogArchivo($tipo, $accion, $usuario) {
    $logfile = 'log.txt';
    $fecha = date("Y-m-d H:i:s");
    $log = "[$fecha] [$tipo] [$usuario] - $accion\n";
    file_put_contents($logfile, $log, FILE_APPEND);
}

function registrarLogDB($tipo, $accion, $usuario) {
    global $conn;
    $sql = "INSERT INTO logs (tipo, accion, usuario, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $tipo, $accion, $usuario);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $carpetaDestino = "../subimag/"; // Carpeta donde se guardarán las imágenes

    // Verificar si la carpeta 'subimag' existe, si no, crearla
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true); // Crear carpeta con permisos adecuados
    }

    $imagen = $carpetaDestino . basename($_FILES["imagen"]["name"]);
    $usuario = isset($_SESSION["user"]) ? $_SESSION["user"] : "Desconocido";

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagen)) {
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
}
?>
