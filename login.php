<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    //Conexion con la base de datos
    $conn = new mysqli('localhost', 'root', 'Joel.lara02@', 'base_tienda_mascotas');

    //Verificar la conexion
    if ($conn->connect_error) {
        die("Conexion fallida: " . $conn->connect_error);
    }

    //Buscar el usuario en la base de datos
    $sql = "SELECT * FROM clientes WHERE correo_electronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if(password_verify($pass, $user['contrasena'])){
            $_SESSION['id_cliente'] = $user['id_cliente'];
            echo "Inicio de sesion exitoso.";
            //rediregir a index.html
            header("Location: index.html");
            exit(); //Detener la ejecucion del script despues de la redireccion
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    $stmt->close();
    $conn->close();
}
?>