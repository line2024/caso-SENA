<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "caso");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Preparar la consulta SQL
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si el usuario existe
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    if (password_verify($contrasena, $fila['contrasena'])) {
        echo "Autenticación satisfactoria";
    } else {
        echo "Error en la autenticación";
    }
} else {
    echo "Error en la autenticación";
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>