<?php
session_start();
require '../modelo/config.php'; // Conexión a la base de datos

// Función para registrar en el archivo log
// Función para registrar en el archivo log y en la base de datos
function registrarLog($tipo, $accion, $usuario) {
    global $conn;

    // Guardar en archivo log.txt
    $logfile = 'log.txt';
    $fecha = date("Y-m-d H:i:s");
    $log = "[$fecha] [$tipo] [$usuario] - $accion\n";
    file_put_contents($logfile, $log, FILE_APPEND);

    // Guardar en la base de datos
    $sql = "INSERT INTO logs (tipo, accion, usuario, fecha) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $tipo, $accion, $usuario, $fecha);
    $stmt->execute();
}

// Ejemplo de uso:
registrarLog("Aviso", "Inicio de sesión exitoso", "usuario123");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $username;
            registrarLog("Aviso", "Inicio de sesión exitoso", $username);
            header("Location:../vista/Index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
            registrarLog("Aviso", "Error de contraseña incorrecta", $username);
        }
    } else {
        $error = "Usuario no encontrado";
        registrarLog("Aviso", "Usuario no encontrado", $username);
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../vista/assets//Estilos.css">
    <style>
        body {
            background: url('../vista/Imag/1\ \(3\).jpeg') no-repeat center center fixed; 
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }

        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
       </form>
     
       <?php 
        /*
        if (isset($error)) echo "<p class='error-message'>$error</p>"; 
        echo '<p>¿No tienes cuenta? <a href="../Controlador/crear_cuenta.php">Regístrate aquí</a></p>';
        */
        ?>

    </div>
</body>
</html>
