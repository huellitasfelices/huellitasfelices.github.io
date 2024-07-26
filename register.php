<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $ap = $_POST['ap'];
    $am = $_POST['am'];
    $fn = $_POST['fn'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si las contraseñas coinciden
    if ($password !== $_POST['password1']) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Encriptar la contraseña
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', 'Joel.lara02@', 'base_tienda_mascotas');

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO clientes (nombre, apellido_p, apellido_m, fecha_nacimiento, correo_electronico, contrasena) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssss", $nombre, $ap, $am, $fn, $email, $password_hashed);

        if ($stmt->execute()) {
            echo "Registro exitoso.";
            //rediregir a index.html
            header("Location: index.html");
            exit(); //Detener la ejecucion del script despues de la redireccion
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la declaración: " . $conn->error;
    }

    $conn->close();
}
?>
