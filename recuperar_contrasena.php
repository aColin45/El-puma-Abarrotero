<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../connection/CSS/estilosLog.css">
    <title>Tienda de Abarrotes - Recuperar Contraseña</title>
    <style>
        /* Estilos para la página de recuperación de contraseña */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1b1726;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            list-style: none;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
        }

        .recover-password-form {
            background-color: #2a223a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .recover-password-form h2 {
            color: #ff5a2c;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-field {
            position: relative;
            margin-bottom: 20px;
        }

        .input-field i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: #ff5a2c;
        }

        .input-field input {
            width: 100%;
            padding: 12px 10px;
            border: none;
            border-bottom: 2px solid #ff5a2c;
            background-color: #2a223a;
            color: #ffffff;
            font-size: 16px;
            outline: none;
        }

        .input-field input:focus {
            border-bottom: 2px solid #08eed0;
        }

        .btn {
            background-color: #ff5a2c;
            color: #ffffff;
            cursor: pointer;
            width: 100%;
            padding: 12px;
        }

        .btn:hover {
            background-color: #1b1726;
        }
    </style>
</head>
<body>

<!-- Contenedor del formulario de recuperación de contraseña -->
<div class="container">
    <form action="procesar_recuperacion.php" method="post" class="recover-password-form">
        <h2 class="title">Recuperar Contraseña</h2>
        <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="recover_email" placeholder="Correo electrónico" required/>
        </div>
        <input type="submit" class="btn" name="recover_submit" value="Enviar Contraseña" />
    </form>
</div>

</body>
</html>
