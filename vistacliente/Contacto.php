<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Quejas</title>
    <!-- Enlace a los estilos de Bootstrap 5 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa; /* Fondo más suave y claro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 500px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1.1em;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            width: 100%;
            margin-top: 10px;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, .5);
        }
        textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, .5);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Formulario de Quejas</h2>
        <form id="quejaForm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ingresa tu nombre completo">
            </div>
            <div class="mb-3">
                <label for="nota" class="form-label">Queja:</label>
                <textarea class="form-control" id="nota" name="nota" rows="4" required placeholder="Describe tu queja aquí..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="button" class="btn btn-secondary" onclick="history.back()">Regresar</button>
        </form>
    </div>

    <!-- Enlace a los scripts de Bootstrap 5 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Script para manejar el envío del formulario -->
    <script>
        document.getElementById('quejaForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el comportamiento por defecto del formulario

            const nombre = document.getElementById('nombre').value;
            const nota = document.getElementById('nota').value;

            // Validar si los campos están vacíos
            if (!nombre || !nota) {
                alert('Por favor, completa todos los campos.');
                return;
            }

            // Enviar los datos del formulario usando fetch
            fetch('../Controlador/procesar_queja.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nombre: nombre, nota: nota })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Queja enviada correctamente.');
                    document.getElementById('quejaForm').reset(); // Limpia los campos del formulario
                } else {
                    alert('Error al enviar la queja.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al enviar la queja.');
            });
        });
    </script>

</body>
</html>
