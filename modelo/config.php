<?php
$servername = "localhost"; // Cambia si usas otro servidor
$username = "root";        // Usuario de la BD
$password = "";            // Contraseña (vacía por defecto en XAMPP)
$database = "barberia";    // Nombre de la BD

$conn = new mysqli($servername, $username, $password, $database);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error); // Registrar el error en el log del servidor
    echo "Hubo un problema con la conexión a la base de datos."; // Mensaje genérico para el usuario
    exit();
}
?>
