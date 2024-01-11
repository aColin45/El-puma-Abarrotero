<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../connection/CSS/estilosLog.css">
    <title>Tienda de Abarrotes - Inicio de Sesión</title>
    <style>
        /* Estilos para el formulario de inicio de sesión */
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

        .sign-in-form {
            background-color: #2a223a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sign-in-form h2 {
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

        .btn.solid {
            background-color: #ff5a2c;
            color: #ffffff;
            cursor: pointer;
        }

        .btn.solid:hover {
            background-color: #1b1726;
        }

        /* Estilos para el mensaje de "¿No tienes cuenta? Regístrate aquí" */
        .sign-in-form p {
            color: #ffffff;
            text-align: center;
            margin-top: 20px;
        }

        .sign-in-form a {
            color: #ff5a2c;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Contenedor del formulario de inicio de sesión -->
<div class="container">
    <form action="login.php" method="post" class="sign-in-form">
        <h2 class="title">Ingresa ahora</h2>
        <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="login_username" placeholder="Usuario" />
        </div>
        <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="login_password" placeholder="Contraseña" />
        </div>
        <input type="submit" value="Ingresar" class="btn solid" />
        <p>¿No tienes cuenta? <a href="http://localhost/Elpuma/register.php">Regístrate aquí</a></p>
        <p><a href="http://localhost/Elpuma/recuperar_contrasena.php">¿Olvidaste tu contraseña?</a></p>
    </form>
</div>

</body>
</html>


<?php
session_start();

$conexion = oci_connect("SYSTEM", "oracle", "localhost/xe");

if (!$conexion) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}

// Función para limpiar y validar datos
function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Registrar el usuario
if (isset($_POST['register'])) {
    $username = cleanInput($_POST['username']);
    $email = cleanInput($_POST['email']);
    $password = password_hash(cleanInput($_POST['password']), PASSWORD_DEFAULT);
    $role = cleanInput($_POST['role']);

    // Validación
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        echo "Por favor, completa todos los campos.";
    } else {
        // Función para evitar inyección SQL
        $query = oci_parse($conexion, "INSERT INTO Usuarios (Username, Email, Password, ROL) VALUES (:username, :email, :password, :role)");
        oci_bind_by_name($query, ':username', $username);
        oci_bind_by_name($query, ':email', $email);
        oci_bind_by_name($query, ':password', $password);
        oci_bind_by_name($query, ':role', $role);

        if (oci_execute($query)) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Error al registrar el usuario: " . oci_error($query)['message'];
        }
    }
}

// Inicio de sesión
if (isset($_POST['login_username']) && isset($_POST['login_password'])) {
    $login_username = cleanInput($_POST['login_username']);
    $login_password = cleanInput($_POST['login_password']);

    // Validación
    if (empty($login_username) || empty($login_password)) {
        echo "Por favor, ingresa usuario y contraseña.";
    } else {
        // Consulta preparada
        $query = oci_parse($conexion, "SELECT * FROM Usuarios WHERE Username = :username");
        oci_bind_by_name($query, ':username', $login_username);

        if (oci_execute($query)) {
            $row = oci_fetch_assoc($query);

            if ($row && password_verify($login_password, $row['PASSWORD'])) {
                $_SESSION['user_id'] = $row['ID'];
                $_SESSION['username'] = $row['Username'];
                $role = $row['ROL'];

                // Redirigir al usuario según su rol
                switch ($role) {
                    case 'Admin':
                        header("Location: http://localhost/Elpuma/admin.php#");
                        break;
                    case 'Cliente':
                        header("Location: http://localhost/Elpuma/#");
                        break;
                    case 'Vendedor':
                        header("Location: http://localhost/Elpuma/#");
                        break;
                    default:
                        // Redirige a una página predeterminada si el rol no coincide con ninguna opción
                        header('Location: http://localhost/Elpuma/#');
                        break;
                }
                exit();
            } else {
                echo "Credenciales incorrectas.";
            }
        } else {
            echo "Error al realizar la consulta: " . oci_error($query)['message'];
        }
    }
}

oci_close($conexion);
?>
