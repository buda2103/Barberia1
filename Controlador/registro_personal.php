<?php
require '../modelo/config.php'; // Conexión a la base de datos
session_start();

// Generar un token CSRF si no existe
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Clase para manejar la entrada de los formularios
class EntradaFormulario {
    // Función para obtener y sanitizar datos de $_POST
    public static function obtener($clave, $tipo = 'string') {
        if (isset($_POST[$clave])) {
            $valor = trim($_POST[$clave]);

            // Filtrar y validar según el tipo de dato
            if ($tipo === 'email') {
                return filter_var($valor, FILTER_VALIDATE_EMAIL);
            } elseif ($tipo === 'string') {
                return $valor;
            } elseif ($tipo === 'int') {
                return filter_var($valor, FILTER_VALIDATE_INT);
            }
        }
        return null;
    }
}

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
    // Verificar token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Solicitud no válida.");
    }

    // Limpiar y validar entrada utilizando la clase EntradaFormulario
    $nombre = EntradaFormulario::obtener("nombre");
    $correo = EntradaFormulario::obtener("correo", "email");
    $celular = EntradaFormulario::obtener("celular", "int");

    if ($nombre && $correo && $celular) {
        $sql = "INSERT INTO personal (correo, nombre, celular) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $correo, $nombre, $celular);

        if ($stmt->execute()) {
            registrarLogArchivo("Aviso", "Personal registrado exitosamente", $nombre);
            registrarLogDB("Aviso", "Personal registrado exitosamente", $nombre);
            header("Location: ../index.php");
            exit();
        } else {
            registrarLogArchivo("Error", "Error al registrar personal", $nombre);
            registrarLogDB("Error", "Error al registrar personal", $nombre);
        }
    } else {
        registrarLogArchivo("Error", "Datos inválidos al registrar personal", "Desconocido");
        registrarLogDB("Error", "Datos inválidos al registrar personal", "Desconocido");
    }
}
?>
