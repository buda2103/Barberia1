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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $usuario = isset($_SESSION["user"]) ? $_SESSION["user"] : "Desconocido";

    $sql = "UPDATE productos SET nombre = ?, precio = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $nombre, $precio, $id);

    if ($stmt->execute()) {
        registrarLogArchivo("Aviso", "Producto modificado: ID $id, Nombre: $nombre, Precio: $precio", $usuario);
        registrarLogDB("Aviso", "Producto modificado: ID $id, Nombre: $nombre, Precio: $precio", $usuario);
    } else {
        registrarLogArchivo("Error", "Error al modificar producto: ID $id", $usuario);
        registrarLogDB("Error", "Error al modificar producto: ID $id", $usuario);
    }

    header("Location: ../vista/Servicios.php");
}
?>
