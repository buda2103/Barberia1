<?php
require_once '../modelo/config.php';

// Clase para manejar la entrada de los formularios
class EntradaFormulario {
    // Función para obtener y sanitizar datos de $_GET
    public static function obtener($clave, $tipo = 'string') {
        if (isset($_GET[$clave])) {
            $valor = trim($_GET[$clave]);

            // Filtrar y validar según el tipo de dato
            if ($tipo === 'int') {
                return filter_var($valor, FILTER_VALIDATE_INT);
            } elseif ($tipo === 'string') {
                return $valor;
            }
        }
        return null;
    }
}

// Obtener el barberoId utilizando la clase EntradaFormulario
$barberoId = EntradaFormulario::obtener('barbero_id', 'int');

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
