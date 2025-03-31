<?php
// Iniciar buffer de salida para evitar problemas con header()
ob_start();

require '../modelo/config.php'; // Conexión a la base de datos

// Función para registrar en el archivo log
function registrarLogArchivo($tipo, $accion, $usuario) {
    $logfile = 'log.txt';
    $fecha = date("Y-m-d H:i:s");
    $log = "[$fecha] [$tipo] [$usuario] - $accion\n";
    file_put_contents($logfile, $log, FILE_APPEND);
}

// Función para registrar en la base de datos
function registrarLogDB($tipo, $accion, $usuario) {
    global $conn;
    $sql = "INSERT INTO logs (tipo, accion, usuario) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $tipo, $accion, $usuario);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitización de inputs
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
        registrarLogArchivo("Aviso", "Las contraseñas no coinciden", $username);
        registrarLogDB("Aviso", "Las contraseñas no coinciden", $username);
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, correo, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $correo, $username, $password_hashed);

        if ($stmt->execute()) {
            registrarLogArchivo("Aviso", "Cuenta creada exitosamente", $username);
            registrarLogDB("Aviso", "Cuenta creada exitosamente", $username);
            
            // Redirección segura
            ob_end_clean(); // Limpiar buffer antes de header
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Error al registrar usuario: " . $conn->error;
            registrarLogArchivo("Error", "Error al registrar usuario: " . $conn->error, $username);
            registrarLogDB("Error", "Error al registrar usuario", $username);
        }
    }
}
?>