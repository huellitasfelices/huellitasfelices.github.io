<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Incluye Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Productos</title>
    <style>
        .header {
            background: #ca7953;
        }

        .nav__logo img {
            width: 60px;
        }

        .nav__link {
            color: #000;
            font-weight: bold;
        }

        .nav__link:hover {
            color: #007bff;
        }

        .mostrador {
            padding: 20px;
        }

        .item {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
        }

        .item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .contenedor-foto img {
            max-width: 100%;
            height: auto;
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .descripcion, .precio {
            margin: 10px 0;
        }

        .seleccion {
            display: none; /* Oculto por defecto */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .info {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            position: relative; /* Para posicionar el ícono de cerrar */
        }

        .info img {
            max-width: 100%;
            height: auto;
        }

        .cerrar {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 24px;
            color: #000;
            background: #fff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .cerrar:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
<header class="header">
    <nav class="nav container navbar navbar-expand-lg navbar-light">
        <a href="#" class="nav__logo navbar-brand">
            <img src="img/img85.png" alt="Logo">
            HUELLITAS FELICES
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="index.html" class="nav__link nav-link">Inicio</a></li>
                <li class="nav-item"><a href="acercade.html" class="nav__link nav-link">Acerca de</a></li>
                <li class="nav-item"><a href="productos.php" class="nav__link nav-link" target="_blank">Tienda</a></li>
                <li class="nav-item"><a href="contactanos.html" class="nav__link nav-link">Contacto</a></li>
                <li class="nav-item"><a href="Servicios.html" class="nav__link nav-link">Servicios</a></li>
                <li class="nav-item"><a href="login.html" class="nav__link nav-link">Regístrate</a></li>
            </ul>
        </div>
    </nav>
</header>

<section class="contenido">
    <div class="container mostrador">
        <div class="row">
            <?php
            $server = "localhost";
            $user = "root";
            $pass = "Joel.lara02@";
            $bd = "base_tienda_mascotas";

            $conexion = new mysqli($server, $user, $pass, $bd);

            // Verificar conexión
            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }

            // Consulta para obtener productos
            $sql = "SELECT * FROM productos";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-3 mb-4'>";
                    echo "<div class='item' onclick='cargar(this, \"" . htmlspecialchars($row["nombre"]) . "\", \"" . htmlspecialchars($row["imagen"]) . "\", \"" . htmlspecialchars($row["precio"]) . "\")'>";
                    echo "<div class='contenedor-foto'>";
                    echo "<img src='" . (isset($row["imagen"]) ? htmlspecialchars($row["imagen"]) : "img/placeholder.jpg") . "' alt='Imagen del producto'>";
                    echo "</div>";
                    echo "<p class='descripcion'>" . (isset($row["nombre"]) ? htmlspecialchars($row["nombre"]) : "Descripción no disponible") . "</p>";
                    echo "<span class='precio'>$" . (isset($row["precio"]) ? htmlspecialchars($row["precio"]) : "Precio no disponible") . "</span>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }

            // Cerrar conexión
            $conexion->close();
            ?>
        </div>
    </div>

    <!-- CONTENEDOR DEL ITEM SELECCIONADO -->
    <div class="seleccion" id="seleccion">
        <div class="info">
            <div class="cerrar" onclick="cerrar()">
                &#x2715; <!-- Código de la "X" -->
            </div>
            <img src="" alt="" id="img">
            <h2 id="modelo"></h2>
            <p id="descripcion"></p>
            <span class="precio" id="precio"></span>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <select class="form-control" id="cantidad">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="agregarAlCarrito()">AGREGAR AL CARRITO</button>
        </div>
    </div>
</section>

<!-- Incluye Bootstrap JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function cargar(element, nombre, imagen, precio) {
        document.getElementById('modelo').innerText = nombre;
        document.getElementById('img').src = imagen;
        document.getElementById('descripcion').innerText = 'Descripción del producto'; // Ajustar si es necesario
        document.getElementById('precio').innerText = '$' + precio;
        document.getElementById('seleccion').style.display = 'flex';
    }

    function cerrar() {
        document.getElementById('seleccion').style.display = 'none';
    }

    function agregarAlCarrito() {
        let cantidad = document.getElementById('cantidad').value;
        alert('Producto agregado al carrito. Cantidad: ' + cantidad);
        cerrar();
    }
</script>
</body>
</html>
