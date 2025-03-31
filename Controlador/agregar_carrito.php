<?php
require '../modelo/config.php';
session_start();

// Verificar si el token CSRF es válido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['csrf_token'])) {
    if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
        echo json_encode([
            'success' => false,
            'message' => 'Token CSRF inválido'
        ]);
        exit();
    }

    $servicio_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    
    if (!$servicio_id) {
        echo json_encode([
            'success' => false,
            'message' => 'ID de servicio inválido'
        ]);
        exit();
    }

    // Obtener información del servicio
    $sql = "SELECT id, nombre, precio FROM servicios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $servicio_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $servicio = $result->fetch_assoc();
        
        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        
        // Verificar si el servicio ya está en el carrito
        $encontrado = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id'] == $servicio_id) {
                $item['cantidad'] += 1;
                $encontrado = true;
                break;
            }
        }
        
        // Si no está en el carrito, agregarlo
        if (!$encontrado) {
            $_SESSION['carrito'][] = [
                'id' => $servicio['id'],
                'nombre' => $servicio['nombre'],
                'precio' => $servicio['precio'],
                'cantidad' => 1
            ];
        }

        // Regenerar token CSRF para la próxima solicitud
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        echo json_encode([
            'success' => true,
            'message' => 'Servicio añadido al carrito',
            'carrito_count' => count($_SESSION['carrito']),
            'csrf_token' => $_SESSION['csrf_token'] // Enviar nuevo token
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Servicio no encontrado'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud inválida'
    ]);
}
?>
