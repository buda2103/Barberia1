<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .button-container button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Selecciona el tipo de registro</h2>
        <div class="button-container">
            <button onclick="location.href='../vista/Administrador.php'">Registrar Administrador</button>
            <button onclick="location.href='../vista/Personal.php'">Registrar Personal</button>
        </div>
    </div>
</body>
</html>
