<?php
// Iniciar buffer de salida para evitar problemas con header()
ob_start();

require '../modelo/config.php';
session_start();

// Verificar si el carrito existe en la sesión
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['cantidad'])) {
    // Validar y sanitizar entradas
    $servicio_id = filter_var($_POST['id'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);
    
    $cantidad = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);

    // Verificar validación
    if ($servicio_id === false || $cantidad === false) {
        $_SESSION['error'] = 'Datos inválidos recibidos';
        ob_end_clean();
        header('Location: ../vistacliente/Carrito.php');
        exit;
    }

    // Buscar y actualizar el item en el carrito
    $item_encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $servicio_id) {
            $item['cantidad'] = $cantidad;
            $item_encontrado = true;
            break;
        }
    }

    if (!$item_encontrado) {
        $_SESSION['error'] = 'El servicio no está en el carrito';
    }
}

// Redirección segura
ob_end_clean();
header('Location: ../vistacliente/Carrito.php');
exit;
?>