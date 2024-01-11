<?php
// procesar_recuperacion.php

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

if (isset($_POST['recover_submit'])) {
    $email_to_recover = cleanInput($_POST['recover_email']);

    // Verificar la existencia del correo en la base de datos
    $query = oci_parse($conexion, "SELECT * FROM Usuarios WHERE Email = :email");
    oci_bind_by_name($query, ':email', $email_to_recover);

    if (oci_execute($query)) {
        $row = oci_fetch_assoc($query);

        if ($row) {
            // Correo encontrado en la base de datos
            // Generar una nueva contraseña aleatoria
            $new_password = bin2hex(random_bytes(8)); // Ejemplo de generación aleatoria

            // Actualizar la contraseña en la base de datos
            $update_query = oci_parse($conexion, "UPDATE Usuarios SET Password = :new_password WHERE Email = :email");
            oci_bind_by_name($update_query, ':new_password', password_hash($new_password, PASSWORD_DEFAULT));
            oci_bind_by_name($update_query, ':email', $email_to_recover);

            if (oci_execute($update_query)) {
                // Envía la nueva contraseña al correo del usuario
                $subject = "Recuperación de Contraseña";
                $message = "Tu nueva contraseña es: " . $new_password;
                mail($email_to_recover, $subject, $message);

                echo "Hemos enviado una nueva contraseña a tu correo electrónico.";
            } else {
                echo "Error al actualizar la contraseña: " . oci_error($update_query)['message'];
            }
        } else {
            echo "No existe ninguna cuenta asociada a ese correo electrónico.";
        }
    } else {
        echo "Error al realizar la consulta: " . oci_error($query)['message'];
    }
}

oci_close($conexion);
?>
