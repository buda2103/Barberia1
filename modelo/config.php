<?php
$servername = "localhost"; // Cambia si usas otro servidor
$username = "root";        // Usuario de la BD
$password = "";            // Contraseña (vacía por defecto en XAMPP)
$database = "barberia"; // Nombre de la BD

$conn = new mysqli($servername, $username, $password, $database);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
