<?php
require '../modelo/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $servicio_id = intval($_POST['id']);
    
    // Buscar el item en el carrito y eliminarlo
    foreach ($_SESSION['carrito'] as $key => $item) {
        if ($item['id'] == $servicio_id) {
            unset($_SESSION['carrito'][$key]);
            // Reindexar el array para evitar problemas
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
            break;
        }
    }
}

header('Location: ../vistacliente/Carrito.php');
?>