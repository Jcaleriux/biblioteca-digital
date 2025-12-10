<?php
// Procesa la devolución de un préstamo
session_start();
require_once 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: mis_prestamos.php');
    exit;
}

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">Debes iniciar sesión.</span>';
    header('Location: login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_prestamo = isset($_POST['id_prestamo']) ? (int)$_POST['id_prestamo'] : 0;

// Verificar que el préstamo exista y pertenezca al usuario
$stmt = $conexion->prepare("SELECT id_libro, estado FROM prestamos WHERE id = ? AND id_usuario = ? LIMIT 1");
$stmt->bind_param('ii', $id_prestamo, $id_usuario);
$stmt->execute();
$res = $stmt->get_result();
if (!$res || $res->num_rows === 0) {
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">Préstamo no encontrado.</span>';
    header('Location: mis_prestamos.php');
    exit;
}
$row = $res->fetch_assoc();
if ($row['estado'] !== 'Activo') {
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">El préstamo ya fue devuelto.</span>';
    header('Location: mis_prestamos.php');
    exit;
}
$id_libro = $row['id_libro'];

// Actualizar préstamo: estado Devuelto y fecha_devolucion = hoy
$fecha = date('Y-m-d');
$upd = $conexion->prepare("UPDATE prestamos SET estado = 'Devuelto', fecha_devolucion = ? WHERE id = ?");
$upd->bind_param('si', $fecha, $id_prestamo);
$ok = $upd->execute();
if ($ok) {
    // Marcar libro disponible
    $up2 = $conexion->prepare("UPDATE libros SET disponible = 1 WHERE id = ?");
    $up2->bind_param('i', $id_libro);
    $up2->execute();
    $_SESSION['mensaje_prestamo'] = '<span style="color:green;">Préstamo devuelto correctamente.</span>';
} else {
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">Error al procesar la devolución.</span>';
}
header('Location: mis_prestamos.php');
exit;

?>
