<?php
// Archivo: procesar_queja.php

// Incluir el archivo de configuración de la base de datos
require '../modelo/config.php'; // Asegúrate de que la ruta sea correcta

// Establecer cabeceras para permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Obtener los datos JSON enviados
$input = json_decode(file_get_contents('php://input'), true);

// Verificar que se hayan recibido los datos necesarios
if (isset($input['nombre']) && isset($input['nota'])) {
    $nombre = $input['nombre'];
    $nota = $input['nota'];

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO quejas (nombre, nota) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $nota);

    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
}
?>
