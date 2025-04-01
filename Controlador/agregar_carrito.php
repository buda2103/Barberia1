<?php
require '../modelo/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $servicio_id = intval($_POST['id']);
    
    // Obtener información del servicio con manejo de errores
    $sql = "SELECT id, nombre, precio FROM servicios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo json_encode([
            'success' => false,
            'message' => 'Error en la preparación de la consulta'
        ]);
        exit;
    }

    $stmt->bind_param("i", $servicio_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $servicio = $result->fetch_assoc();
        
        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        
        // Usar un índice para verificar la existencia del servicio en el carrito
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
            $_SESSION['carrito'][$servicio_id] = [
                'id' => $servicio['id'],
                'nombre' => $servicio['nombre'],
                'precio' => $servicio['precio'],
                'cantidad' => 1
            ];
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Servicio añadido al carrito',
            'carrito_count' => count($_SESSION['carrito'])
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
