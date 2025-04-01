<?php
// Iniciar buffer de salida para evitar problemas con header()
ob_start();

require '../modelo/config.php';
session_start();

// Clase Carrito para gestionar el carrito de compras
class Carrito {
    /** 
     * Inicializa el carrito en la sesión si no existe.
     */
    public static function iniciarCarrito() {
        if (!self::existeEnSesion('carrito')) {
            self::establecerEnSesion('carrito', []);
        }
    }

    /** 
     * Agrega o actualiza un item en el carrito.
     */
    public static function agregarItem($id, $cantidad) {
        $item_encontrado = false;
        foreach (self::obtenerDeSesion('carrito') as &$item) {
            if ($item['id'] === $id) {
                $item['cantidad'] = $cantidad;
                $item_encontrado = true;
                break;
            }
        }

        if (!$item_encontrado) {
            self::establecerEnSesion('error', 'El servicio no está en el carrito');
        }
    }

    /** 
     * Método principal para actualizar el carrito.
     */
    public static function actualizarCarrito($id, $cantidad) {
        self::iniciarCarrito();
        self::agregarItem($id, $cantidad);
    }

    /** 
     * Verifica si existe una clave en la sesión.
     */
    private static function existeEnSesion($clave) {
        return isset($_SESSION[$clave]);
    }

    /** 
     * Obtiene un valor de la sesión.
     */
    private static function obtenerDeSesion($clave) {
        return $_SESSION[$clave] ?? null;
    }

    /** 
     * Establece un valor en la sesión.
     */
    private static function establecerEnSesion($clave, $valor) {
        $_SESSION[$clave] = $valor;
    }
}

// Función para verificar la solicitud POST y validar los datos
function validarSolicitud() {
    return ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['cantidad']));
}

// Verificar si la solicitud es POST y si existen los parámetros necesarios
if (validarSolicitud()) {
    // Validar y sanitizar entradas
    $servicio_id = filter_var($_POST['id'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);

    $cantidad = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);

    // Verificar validación
    if ($servicio_id === false || $cantidad === false) {
        Carrito::establecerEnSesion('error', 'Datos inválidos recibidos');
        ob_end_clean();
        header('Location: ../vistacliente/Carrito.php');
        exit;
    }

    // Actualizar el carrito usando la clase Carrito
    Carrito::actualizarCarrito($servicio_id, $cantidad);
}

// Redirección segura
ob_end_clean();
header('Location: ../vistacliente/Carrito.php');
exit;
?>
