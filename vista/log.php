<?php
// Verifica si el archivo existe antes de incluirlo
$filePath = '../modelo/config.php';
if (file_exists($filePath)) {
    require_once $filePath; // Asegura la conexión a la BD
} else {
    die('El archivo de configuración no se encuentra disponible.');
}

// Consulta para obtener el tipo y la acción de los logs
$sql = "SELECT tipo, accion, COUNT(*) as total FROM logs GROUP BY tipo, accion";
$result = $conn->query($sql);

$datos = [];
while ($row = $result->fetch_assoc()) {
    $tipo = $row['tipo'];
    $accion = $row['accion'];
    $total = $row['total'];

    if (!isset($datos[$tipo])) {
        $datos[$tipo] = [];
    }
    $datos[$tipo][$accion] = $total;
}

// Convertir datos para Chart.js
$tipos = array_keys($datos);
$acciones = [];

// Obtener todas las acciones únicas
foreach ($datos as $acciones_tipo) {
    foreach ($acciones_tipo as $accion => $cantidad) {
        if (!in_array($accion, $acciones)) {
            $acciones[] = $accion;
        }
    }
}

// Organizar datos en una matriz alineada
$valores = [];
foreach ($tipos as $tipo) {
    $fila = [];
    foreach ($acciones as $accion) {
        $fila[] = $datos[$tipo][$accion] ?? 0;
    }
    $valores[] = $fila;
}

// Definir colores fijos por tipo
$colores = ['#e74c3c', '#3498db', '#2ecc71', '#f1c40f', '#9b59b6', '#1abc9c'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica de Logs</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .chart-container {
            width: 90%;
            max-width: 1200px;
            height: 600px; /* Aumenta la altura de la gráfica */
            margin: auto;
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
        .buttons {
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn-home {
            background-color: #2ecc71;
            color: white;
        }
        .btn-refresh {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>

    <h2>Gráfica de Logs por Tipo y Acción</h2>
    <div class="chart-container">
        <canvas id="logChart"></canvas>
    </div>

    <div class="buttons">
        <button class="btn-home" onclick="window.location.href='index.php'">Regresar al Inicio</button>
        <button class="btn-refresh" onclick="location.reload()">Refrescar Página</button>
    </div>

    <script>
        const tipos = <?php echo json_encode($tipos); ?>;
        const acciones = <?php echo json_encode($acciones); ?>;
        const valores = <?php echo json_encode($valores); ?>;
        const colores = <?php echo json_encode(array_slice($colores, 0, count($tipos))); ?>;

        const ctx = document.getElementById('logChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: acciones,
                datasets: tipos.map((tipo, i) => ({
                    label: tipo,
                    data: valores[i],
                    backgroundColor: colores[i] || '#95a5a6',
                    borderColor: '#333',
                    borderWidth: 1
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Permite que la gráfica use todo el espacio disponible
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

</body>
</html>
