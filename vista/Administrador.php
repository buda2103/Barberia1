<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Administrador</title>
    <link rel="stylesheet" href="../vista/assets/style.css">
    <style>
        body {
            background: url('../vista/Imag/2\ \(3\).jpeg') no-repeat center center fixed; 
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

        .success-message {
            color: green;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registro Administrador</h2>

        <?php if (isset($_GET['registro_exitoso'])): ?>
            <p class="success-message">Registro exitoso. Ahora puedes iniciar sesión.</p>
        <?php endif; ?>

        <form method="POST" action="../Controlador/crear_cuenta.php">
            <input type="hidden" name="tipo_usuario" value="administrador">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_password" placeholder="Confirmar contraseña" required>
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
