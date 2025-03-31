<?php
require '../modelo/config.php'; // Archivo de conexión a la base de datos
session_start(); // Asegúrate de iniciar la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Elite - Servicios</title>
    <link rel="stylesheet" href="../vista/assets/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        /* Estilos adicionales para las imágenes */
        .imagen-servicio {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ddd;
            transition: transform 0.3s ease;
        }
        
        .imagen-servicio:hover {
            transform: scale(1.05);
        }
        
        .servicio {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            margin: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 250px;
            transition: box-shadow 0.3s ease;
        }
        
        .servicio:hover {
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .servicio-nombre {
            font-weight: bold;
            margin: 10px 0 5px;
            font-size: 1.1rem;
        }
        
        .servicio-precio {
            color: #e67e22;
            font-weight: bold;
            font-size: 1.2rem;
            margin: 5px 0 15px;
        }
        
        .btn-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 8px;
        }
        
        .btn-carrito, .btn-comprar {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        
        .btn-carrito {
            background: #3498db;
            color: white;
        }
        
        .btn-carrito:hover {
            background: #2980b9;
        }
        
        .btn-comprar {
            background: #2ecc71;
            color: white;
        }
        
        .btn-comprar:hover {
            background: #27ae60;
        }
        
        .galeria-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-title">Barbería Mito</div>
        <a href="../Index.php" class="btn-volver">
            <i class="bi bi-arrow-left"></i> Volver al Inicio
        </a>
        <a href="../vistacliente/Carrito.php" class="btn-carrito-header">
            <i class="bi bi-cart"></i> Carrito (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)
        </a>
    </header>
    
    <div class="container">
        <h2>Nuestros Servicios</h2>
        <div class="galeria-container">
            <?php
            $sql = "SELECT id, imagen, nombre, precio FROM servicios";
            $result = $conn->query($sql);
            while ($servicio = $result->fetch_assoc()) {
                echo "<div class='servicio'>";
                echo "<img class='imagen-servicio' src='" . $servicio['imagen'] . "' alt='" . $servicio['nombre'] . "'>";
                echo "<p class='servicio-nombre'>" . $servicio['nombre'] . "</p>";
                echo "<p class='servicio-precio'>$" . number_format($servicio['precio'], 2) . "</p>";
                echo "<div class='btn-container'>";
                echo "<button class='btn-carrito' onclick='agregarAlCarrito(".$servicio['id'].")'>";
                echo "<i class='bi bi-cart-plus'></i> Añadir al carrito";
                echo "</button>";
                echo "<button class='btn-comprar' onclick='comprarAhora(".$servicio['id'].")'>";
                echo "<i class='bi bi-bag-check'></i> Comprar ahora";
                echo "</button>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <script>
    function agregarAlCarrito(servicioId) {
        fetch('../controlador/agregar_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + servicioId
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert(data.message);
                // Actualizar el contador del carrito
                document.querySelector('.btn-carrito-header i').nextSibling.textContent = 
                    ' Carrito (' + data.carrito_count + ')';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error en la solicitud");
        });
    }

    function comprarAhora(servicioId) {
        agregarAlCarrito(servicioId);
        // Redirigir al carrito después de un breve retraso
        setTimeout(() => {
            window.location.href = '../vistacliente/Carrito.php';
        }, 500);
    }
    </script>
</body>
</html>