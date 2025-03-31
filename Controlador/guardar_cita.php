<?php
require_once '../modelo/config.php';

// Función para devolver respuestas JSON
function sendJsonResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit; // Asegúrate de detener la ejecución después de enviar la respuesta
}

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($data)) {
    $sucursal = $data['sucursal'];
    $barberoId = $data['barbero_id'];
    $servicioId = $data['servicio_id'];
    $tipoPago = $data['tipo_pago'];
    
    // Aquí deberías agregar también el ID del usuario logueado
    $usuarioId = 1; // Esto debería venir de la sesión
    
    $query = "INSERT INTO citas (usuario_id, barbero_id, servicio_id, sucursal, tipo_pago, fecha_creacion) 
              VALUES (?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiss", $usuarioId, $barberoId, $servicioId, $sucursal, $tipoPago);
    
    if ($stmt->execute()) {
        sendJsonResponse(true, 'Cita agendada correctamente');
    } else {
        sendJsonResponse(false, 'Error al agendar la cita');
    }
} else {
    sendJsonResponse(false, 'Datos inválidos');
}
?>
