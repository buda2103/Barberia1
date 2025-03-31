<?php
require_once '../modelo/config.php';

$barberoId = $_GET['barbero_id'] ?? null;

if ($barberoId) {
    $query = "SELECT s.id, s.nombre 
              FROM servicios s
              INNER JOIN barbero_servicio bs ON s.id = bs.servicio_id
              WHERE bs.barbero_id = ? AND s.estado = 1
              ORDER BY s.nombre";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $barberoId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $servicios = [];
    while ($row = $result->fetch_assoc()) {
        $servicios[] = $row;
    }
    
    header('Content-Type: application/json');
    echo json_encode($servicios);
}
?>