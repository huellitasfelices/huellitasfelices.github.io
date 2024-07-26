<?php
// Datos de conexión a la base de datos
$host = "localhost"; // Cambia esto si tu base de datos está en un servidor diferente
$user = "root"; // Reemplaza con tu usuario de la base de datos
$password = "Joel.lara02@"; // Reemplaza con tu contraseña de la base de datos
$database = "base_tienda_mascotas"; // Reemplaza con el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$mensaje = $_POST['mensaje'];

// Prevenir inyección SQL
$nombre = $conn->real_escape_string($nombre);
$correo = $conn->real_escape_string($correo);
$mensaje = $conn->real_escape_string($mensaje);

// Insertar datos en la tabla
$sql = "INSERT INTO mensajes (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

if ($conn->query($sql) === TRUE) {
    echo "Mensaje enviado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
