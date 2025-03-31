<?php
declare(strict_types=1);

session_start();

// Configuración de entorno
require __DIR__ . '/../modelo/config.php';

// Constantes
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_MIME_TYPES', [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif'
]);

// Funciones de utilidad
function registrarLog(string $tipo, string $accion, string $usuario = 'Desconocido'): void {
    $logDir = __DIR__ . '/../logs/';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true); // Crea el directorio de logs si no existe
    }
    
    $logFile = $logDir . date('Y-m') . '_app.log'; // Archivo de log mensual
    $fecha = date('Y-m-d H:i:s'); // Fecha y hora de la acción
    $mensaje = "[$fecha] [$tipo] [$usuario] - $accion" . PHP_EOL; // Formato del log
    
    file_put_contents($logFile, $mensaje, FILE_APPEND); // Escribe el mensaje en el log
    
    // Registrar también en base de datos si es necesario
    global $conn;
    $stmt = $conn->prepare("INSERT INTO logs (tipo, accion, usuario, fecha) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $tipo, $accion, $usuario);
    $stmt->execute(); // Ejecuta la inserción en la base de datos
}

function validarCSRF(): bool {
    // Validar el token CSRF en la sesión
    if (!isset($_SESSION['csrf_token'], $_POST['csrf_token']) || 
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        return false; // Si no coinciden, es un ataque CSRF
    }
    
    // Verificar tiempo de expiración (1 hora)
    if (time() - $_SESSION['csrf_token_time'] > 3600) {
        return false; // Si el token ha expirado, es inválido
    }
    
    return true; // El token es válido
}

function validarImagen(array $imagen): string {
    // Verificar errores de subida
    if ($imagen['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Error en la subida del archivo'); // Si hay un error
    }

    // Verificar tamaño
    if ($imagen['size'] > MAX_FILE_SIZE) {
        throw new RuntimeException('El archivo excede el tamaño máximo permitido'); // Si el archivo es demasiado grande
    }

    // Verificar tipo MIME real
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($imagen['tmp_name']);

    if (!array_key_exists($mimeType, ALLOWED_MIME_TYPES)) {
        throw new RuntimeException('Tipo de archivo no permitido'); // Si el tipo MIME no es permitido
    }

    // Generar nombre único para la imagen
    $extension = ALLOWED_MIME_TYPES[$mimeType];
    return uniqid('img_', true) . '.' . $extension; // Devuelve el nombre único con la extensión correspondiente
}

// Procesamiento del formulario
try {
    // Validar método y CSRF
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validarCSRF()) {
        http_response_code(403);
        throw new RuntimeException('Solicitud no válida o token CSRF inválido'); // Error si la solicitud es no válida o el token CSRF es inválido
    }

    // Validar campos obligatorios
    $camposRequeridos = ['nombre', 'precio'];
    foreach ($camposRequeridos as $campo) {
        if (empty($_POST[$campo])) {
            http_response_code(400);
            throw new RuntimeException("El campo $campo es requerido"); // Si falta algún campo requerido
        }
    }

    // Validar y sanitizar entradas
    $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    if (empty($nombre) || strlen($nombre) > 100) {
        throw new RuntimeException('Nombre no válido'); // Si el nombre no es válido
    }

    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]]);
    if ($precio === false) {
        throw new RuntimeException('Precio no válido'); // Si el precio no es válido
    }

    // Validar imagen
    if (empty($_FILES['imagen']['name'])) {
        throw new RuntimeException('Debe seleccionar una imagen'); // Si no se selecciona una imagen
    }

    $nombreImagen = validarImagen($_FILES['imagen']); // Validar la imagen
    $carpetaDestino = __DIR__ . '/../subimag/'; // Carpeta de destino de la imagen
    
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0755, true); // Crear carpeta de destino si no existe
    }

    $rutaImagen = $carpetaDestino . $nombreImagen;
    $usuario = $_SESSION['user'] ?? 'Desconocido'; // Obtener el usuario actual

    // Mover archivo subido
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
        throw new RuntimeException('Error al guardar la imagen'); // Si no se puede mover la imagen
    }

    // Transacción de base de datos
    $conn->begin_transaction(); // Iniciar la transacción

    try {
        $stmt = $conn->prepare("INSERT INTO servicios (nombre, precio, imagen) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $nombre, $precio, $rutaImagen); // Bind de parámetros
        if (!$stmt->execute()) {
            throw new RuntimeException('Error al guardar el servicio'); // Si falla la inserción
        }

        $conn->commit(); // Confirmar la transacción
        
        // Registrar éxito
        registrarLog('Éxito', "Servicio agregado: $nombre", $usuario);
        
        // Regenerar token CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();

        // Redireccionar a la página principal
        header('Location: ../vista/Index.php');
        exit();

    } catch (Exception $e) {
        $conn->rollback(); // Deshacer la transacción en caso de error
        // Eliminar imagen si hubo error en la BD
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen); // Eliminar archivo si hubo un error
        }
        throw $e;
    }

} catch (RuntimeException $e) {
    // Registrar error
    $usuario = $_SESSION['user'] ?? 'Desconocido';
    registrarLog('Error', $e->getMessage(), $usuario);
    
    // Mostrar error (en producción mostrar mensaje genérico)
    if (getenv('APP_ENV') === 'development') {
        die($e->getMessage()); // En desarrollo, mostrar el mensaje de error completo
    } else {
        die('Ocurrió un error al procesar la solicitud'); // En producción, mensaje genérico
    }
}
?>
