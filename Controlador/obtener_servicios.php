<?php
require '../modelo/config.php'; // Archivo de conexión

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir acceso desde cualquier origen

$sql = "SELECT id, nombre, precio FROM servicios";
$result = $conn->query($sql);

$servicios = [];

if ($result->num_rows === 0) {
    // Si no hay resultados, se devuelve un array vacío o un mensaje de error
    $servicios = [];
} else {
    while ($row = $result->fetch_assoc()) {
        $servicios[] = $row;
    }
}

echo json_encode($servicios, JSON_UNESCAPED_UNICODE); // Evitar problemas de codificación

$conn->close();
?>
