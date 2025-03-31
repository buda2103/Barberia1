<?php
require '../modelo/config.php'; // Conexión a la base de datos

// Función para registrar en el archivo log
function registrarLogArchivo($tipo, $accion, $usuario) {
    $logfile = 'log.txt';
    $fecha = date("Y-m-d H:i:s");
    $log = "[$fecha] [$tipo] [$usuario] - $accion\n";
    file_put_contents($logfile, $log, FILE_APPEND);
}

// Función para registrar en la base de datos
function registrarLogDB($tipo, $accion, $usuario) {
    global $conn;
    $sql = "INSERT INTO logs (tipo, accion, usuario) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $tipo, $accion, $usuario);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $celular = $_POST["celular"];
    
    $sql = "INSERT INTO personal (correo, nombre, celular) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $correo, $nombre, $celular);
    
    if ($stmt->execute()) {
        registrarLogArchivo("Aviso", "Personal registrado exitosamente", $nombre);
        registrarLogDB("Aviso", "Personal registrado exitosamente", $nombre);
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Error al registrar personal";
        registrarLogArchivo("Aviso", "Error al registrar personal", $nombre);
        registrarLogDB("Aviso", "Error al registrar personal", $nombre);
    }
}
?>
