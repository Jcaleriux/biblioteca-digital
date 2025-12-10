<?php
// Procesa el login y redirige según resultado
session_start();
require_once 'config/conexion.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $conexion->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE correo = ? LIMIT 1");
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado && $resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        // Verificar el hash de la contraseña
        if (password_verify($password, $usuario['password'])) {
            // Guardar datos esenciales en sesión
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Datos incorrectos.';
        }
    } else {
        $error = 'Datos incorrectos.';
    }
    $stmt->close();
}
// Mensaje de error si el correo no existe o la contraseña es incorrecta, no indicamos cual es el error por seguridad.
$_SESSION['login_error'] = $error;
header('Location: login.php');
exit;
