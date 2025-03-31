<?php
declare(strict_types=1);

session_start();

// Configuración de entorno
require __DIR__ . '/../modelo/config.php';

// Constantes
define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_MIME_TYPES', [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif'
]);

// Funciones de utilidad
function registrarLog(string $tipo, string $accion, string $usuario = 'Desconocido'): void {
    $logDir = __DIR__ . '/../logs/';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $logFile = $logDir . date('Y-m') . '_app.log';
    $fecha = date('Y-m-d H:i:s');
    $mensaje = "[$fecha] [$tipo] [$usuario] - $accion" . PHP_EOL;
    
    file_put_contents($logFile, $mensaje, FILE_APPEND);
    
    // Registrar también en base de datos si es necesario
    global $conn;
    $stmt = $conn->prepare("INSERT INTO logs (tipo, accion, usuario, fecha) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $tipo, $accion, $usuario);
    $stmt->execute();
}

function validarCSRF(): bool {
    if (!isset($_SESSION['csrf_token'], $_POST['csrf_token']) || 
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        return false;
    }
    
    // Verificar tiempo de expiración (1 hora)
    if (time() - $_SESSION['csrf_token_time'] > 3600) {
        return false;
    }
    
    return true;
}

function validarImagen(array $imagen): string {
    // Verificar errores de subida
    if ($imagen['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Error en la subida del archivo');
    }

    // Verificar tamaño
    if ($imagen['size'] > MAX_FILE_SIZE) {
        throw new RuntimeException('El archivo excede el tamaño máximo permitido');
    }

    // Verificar tipo MIME real
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($imagen['tmp_name']);

    if (!array_key_exists($mimeType, ALLOWED_MIME_TYPES)) {
        throw new RuntimeException('Tipo de archivo no permitido');
    }

    // Generar nombre único
    $extension = ALLOWED_MIME_TYPES[$mimeType];
    return uniqid('img_', true) . '.' . $extension;
}

// Procesamiento del formulario
try {
    // Validar método y CSRF
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validarCSRF()) {
        http_response_code(403);
        throw new RuntimeException('Solicitud no válida o token CSRF inválido');
    }

    // Validar campos obligatorios
    $camposRequeridos = ['nombre', 'precio'];
    foreach ($camposRequeridos as $campo) {
        if (empty($_POST[$campo])) {
            http_response_code(400);
            throw new RuntimeException("El campo $campo es requerido");
        }
    }

    // Validar y sanitizar entradas
    $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    if (empty($nombre) || strlen($nombre) > 100) {
        throw new RuntimeException('Nombre no válido');
    }

    $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]]);
    if ($precio === false) {
        throw new RuntimeException('Precio no válido');
    }

    // Validar imagen
    if (empty($_FILES['imagen']['name'])) {
        throw new RuntimeException('Debe seleccionar una imagen');
    }

    $nombreImagen = validarImagen($_FILES['imagen']);
    $carpetaDestino = __DIR__ . '/../subimag/';
    
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0755, true);
    }

    $rutaImagen = $carpetaDestino . $nombreImagen;
    $usuario = $_SESSION['user'] ?? 'Desconocido';

    // Mover archivo subido
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
        throw new RuntimeException('Error al guardar la imagen');
    }

    // Transacción de base de datos
    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO servicios (nombre, precio, imagen) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $nombre, $precio, $rutaImagen);
        
        if (!$stmt->execute()) {
            throw new RuntimeException('Error al guardar el servicio');
        }

        $conn->commit();
        
        // Registrar éxito
        registrarLog('Éxito', "Servicio agregado: $nombre", $usuario);
        
        // Regenerar token CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();

        // Redireccionar
        header('Location: ../vista/Index.php');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        // Eliminar imagen si hubo error en la BD
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
        throw $e;
    }

} catch (RuntimeException $e) {
    // Registrar error
    $usuario = $_SESSION['user'] ?? 'Desconocido';
    registrarLog('Error', $e->getMessage(), $usuario);
    
    // Mostrar error (en producción mostrar mensaje genérico)
    if (getenv('APP_ENV') === 'development') {
        die($e->getMessage());
    } else {
        die('Ocurrió un error al procesar la solicitud');
    }
}
?>
