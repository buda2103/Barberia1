<?php
session_start();

// Asegurarse de que el archivo de configuración exista antes de incluirlo
$configFile = '../modelo/config.php';
if (!file_exists($configFile)) {
    die("Error: Archivo de configuración no encontrado.");
}

require_once $configFile; // Conexión a la base de datos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Elite - Carrito</title>
    <link rel="stylesheet" href="../vista/assets/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        /* Estilos específicos para el carrito */
        .carrito-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        
        .carrito-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .carrito-table th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        .carrito-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        
        .carrito-table tr:hover {
            background: #f9f9f9;
        }
        
        .cantidad-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .cantidad-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        
        .btn-actualizar, .btn-eliminar {
            background: transparent;
            border: none;
            cursor: pointer;
            color: #3498db;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }
        
        .btn-eliminar {
            color: #e74c3c;
        }
        
        .btn-actualizar:hover {
            color: #2980b9;
        }
        
        .btn-eliminar:hover {
            color: #c0392b;
        }
        
        .total-text {
            text-align: right;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .total-amount {
            font-weight: bold;
            font-size: 1.2rem;
            color: #e67e22;
        }
        
        .carrito-acciones {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        
        .btn-seguir-comprando, .btn-pagar {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-seguir-comprando {
            background: #3498db;
            color: white;
            border: 2px solid #3498db;
        }
        
        .btn-seguir-comprando:hover {
            background: #2980b9;
            border-color: #2980b9;
        }
        
        .btn-pagar {
            background: #2ecc71;
            color: white;
            border: 2px solid #2ecc71;
        }
        
        .btn-pagar:hover {
            background: #27ae60;
            border-color: #27ae60;
        }
        
        /* Estilos para carrito vacío */
        .carrito-vacio {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .carrito-vacio p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #7f8c8d;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .carrito-table {
                display: block;
                overflow-x: auto;
            }
            
            .carrito-acciones {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn-seguir-comprando, .btn-pagar {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-title">Barbería Mito</div>
        <a href="../Index.php" class="btn-volver">
            <i class="bi bi-arrow-left"></i> Volver al Inicio
        </a>
        <a href="Carrito.php" class="btn-carrito-header">
            <i class="bi bi-cart"></i> Carrito (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)
        </a>
    </header>
    
    <div class="container">
        <h2>Tu Carrito de Compras</h2>
        
        <?php if (empty($_SESSION['carrito'])): ?>
            <div class="carrito-vacio">
                <p>Tu carrito está vacío</p>
                <a href="servicios.php" class="btn-seguir-comprando">
                    <i class="bi bi-arrow-left"></i> Ver nuestros servicios
                </a>
            </div>
        <?php else: ?>
            <div class="carrito-container">
                <table class="carrito-table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['carrito'] as $key => $item): 
                            // Asegurarse de que el precio y la cantidad sean numéricos y no nulos
                            $precio = isset($item['precio']) ? (float)$item['precio'] : 0;
                            $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
                            $subtotal = $precio * $cantidad;
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                <td>$<?php echo number_format($precio, 2); ?></td>
                                <td>
                                    <form action="../controlador/actualizar_carrito.php" method="post" class="cantidad-form">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        <input type="number" name="cantidad" value="<?php echo $cantidad; ?>" min="1" class="cantidad-input">
                                        <button type="submit" class="btn-actualizar" title="Actualizar cantidad">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                                <td>
                                    <form action="../controlador/eliminar_carrito.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="btn-eliminar" title="Eliminar del carrito">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="total-text">Total:</td>
                            <td colspan="2" class="total-amount">$<?php echo number_format($total, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="carrito-acciones">
                    <a href="servicios.php" class="btn-seguir-comprando">
                        <i class="bi bi-arrow-left"></i> Seguir comprando
                    </a>
                    <a href="../controlador/procesar_pago.php" class="btn-pagar">
                        <i class="bi bi-credit-card"></i> Proceder al pago
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
