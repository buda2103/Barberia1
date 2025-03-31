<?php
require '../modelo/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['cantidad'])) {
    $servicio_id = intval($_POST['id']);
    $cantidad = intval($_POST['cantidad']);
    
    if ($cantidad < 1) {
        header('Location: ../vistacliente/Carrito.php');
        exit;
    }
    
    // Buscar el item en el carrito y actualizar la cantidad
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $servicio_id) {
            $item['cantidad'] = $cantidad;
            break;
        }
    }
}

header('Location: ../vistacliente/Carrito.php');
?>