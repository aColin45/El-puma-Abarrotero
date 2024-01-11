<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - Puma Abarrotero</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
        <!-- ... (código del encabezado) ... -->
        <div class="menu container">
            <a href="#" class="logo">Puma Abarrotero</a>
            <input type="checkbox" id="menu" />
            <label for="menu">
                <img src="images/logo.png" class="menu-icono" alt="menu">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Productos</a></li>
                    <li class="contact-link">
                        <a href="#">Contacto</a>
                        <ul class="submenu">
                            <li><a href="https://www.facebook.com/ELPUMAAbarrotero1?mibextid=LQQJ4d">Facebook</a></li>
                            <li><a href="https://youtube.com/@pumaabarrotero9795?si=jTounSVKrS0dVso1">YouTube</a></li>
                        </ul>
                    </li>
                    <li class="info-link" id="info-btn">
                        <a href="#">Información</a>
                        <ul class="submenu">
                            <li><a href="https://maps.apple.com/?address=Calle%20S.%20Antonio%20Zomeyuca%202,%20San%20Antonio%20Zomeyucan,%2053570%20Naucalpan,%20Edo.%20M%C3%A9x.,%20M%C3%A9xico&auid=5662520294830823252&ll=19.457019,-99.242034&lsp=9902&q=Puma%20Abarrotero&t=h">Google Maps</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        
    <div class="header-content container">
        <div class="header-txt">
            <h1>Compra tu <span>producto</span> <br> favorito aqui </h1>
            <p>
            Nos tomamos muy en serio la experiencia de compra general de todos nuestros clientes, 
            desde la calidad de Nuestro sitio web hasta el servicio posventa para los clientes que 
            requieren ese cuidado adicional.

            Para garantizar que la calidad de nuestro sitio web sea de primera, examinamos todos y cada uno 
            de los productos justo antes de que se envíen al cliente. Al estar en el negocio de vender 
            Nuestro sitio web durante más de 10 años, tenemos la capacidad y el conocimiento técnico para garantizar 
            que todos nuestros clientes obtengan solo los productos de la mejor calidad cuando nos compran.
            </p>

    </header>
    <!-- ... (código HTML existente) ... -->
    <section class="admin-panel container">
        <h2 style="color: #ff5a2c;">Panel de Administrador</h2>

        <!-- Agregar Usuario -->
        <div class="admin-section">
            <h3>Agregar Nuevo Usuario</h3>
            <form action="admin_operations.php" method="post">
                <input type="hidden" name="operation" value="add_user">
                <label for="user_name">Nombre de Usuario:</label>
                <input type="text" name="user_name" required>
                <label for="user_email">Correo:</label>
                <input type="email" name="user_email" required>
                <label for="user_password">Contraseña:</label>
                <input type="password" name="user_password" required>
                <button type="submit">Agregar Usuario</button>
            </form>
        </div>

        <!-- Eliminar Usuario -->
        <div class="admin-section">
            <h3>Eliminar Usuario</h3>
            <form action="admin_operations.php" method="post">
                <input type="hidden" name="operation" value="delete_user">
                <label for="user_name_to_delete">Nombre del Usuario a Eliminar:</label>
                <input type="text" name="user_name_to_delete" required>
                <button type="submit">Eliminar Usuario</button>
            </form>
        </div>

        <!-- Agregar Producto -->
        <div class="admin-section">
            <h3>Agregar Nuevo Producto</h3>
            <form action="agregar_producto.php" method="post">
                <label for="product_name">Nombre del Producto:</label>
                <input type="text" name="product_name" required>
                <label for="product_type">Tipo de Producto:</label>
                <select name="product_type" required>
                    <option value="Abarrotes">Abarrotes</option>
                    <option value="Farmacia Básica">Farmacia Básica</option>
                    <option value="Utensilios de Vidrio">Utensilios de Vidrio</option>
                    <option value="Utensilios de Plástico">Utensilios de Plástico</option>
                    <option value="Herramientas">Herramientas</option>
                </select>
                <label for="product_price">Precio del Producto:</label>
                <input type="number" name="product_price" step="0.01" required>
                <button type="submit">Agregar Producto</button>
            </form>
        </div>
    </section>

    <!-- Resto del contenido principal (main) -->
    <main class="product container">
        <!-- ... (código del contenido principal) ... -->
    </main>



<footer class="footer container">

    <div class="link">
        <a href="#" class="logo">Puma Abarrotero</a> 
    </div>

    <div class="link">
        <ul>
            <li><a href="#">Inicio</a></li> 
        </ul>

    </div>


</footer>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            var infoBtn = document.getElementById("info-btn");

            infoBtn.addEventListener("click", function () {
                var submenu = infoBtn.querySelector(".submenu");
                submenu.style.display = (submenu.style.display === "block") ? "none" : "block";
            });
        });
    </script>

</body>
</html>

<!-- Mostrar Resultados de Consulta -->
<div class="admin-section">
    <h3>Resultados de la Consulta</h3>
    <?php
    session_start();

    $conexion = oci_connect("SYSTEM", "oracle", "localhost/xe");

    if (!$conexion) {
        $m = oci_error();
        echo $m['message'], "\n";
        exit;
    }

    // Ejecutar consulta y mostrar resultados
    $query = oci_parse($conexion, "SELECT * FROM Productos WHERE Tipo = 'Abarrotes'");
    oci_execute($query);

    echo "<h4>Resultados:</h4>";

    while ($row = oci_fetch_assoc($query)) {
        foreach ($row as $key => $value) {
            echo "$key: $value<br>";
        }
        echo "<br>";
    }

    oci_close($conexion);
    ?>
</div>
