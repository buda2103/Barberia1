<?php
session_start();
require '../modelo/config.php';

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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario = isset($_SESSION["user"]) ? $_SESSION["user"] : "Desconocido";

    $sql = "DELETE FROM servicios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        registrarLogArchivo("Aviso", "Producto eliminado con ID: $id", $usuario);
        registrarLogDB("Aviso", "Producto eliminado con ID: $id", $usuario);
    } else {
        registrarLogArchivo("Error", "Error al eliminar producto con ID: $id", $usuario);
        registrarLogDB("Error", "Error al eliminar producto con ID: $id", $usuario);
    }

    header("Location:../vista/Servicios.php");
}
?>
