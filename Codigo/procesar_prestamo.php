<?php
// Procesa la solicitud de préstamo
session_start();
require_once 'config/conexion.php';
require_once 'modelos/prestamo.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">Debes iniciar sesión para solicitar préstamos.</span>';
    header('Location: login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_libro = isset($_POST['id_libro']) ? (int)$_POST['id_libro'] : 0;

// Validar que el libro exista y esté disponible
$stmt = $conexion->prepare("SELECT disponible FROM libros WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id_libro);
$stmt->execute();
$res = $stmt->get_result();
if (!$res || $res->num_rows === 0) {
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">Libro no encontrado.</span>';
    header('Location: catalogo.php');
    exit;
}
$row = $res->fetch_assoc();
if (!$row['disponible']) {
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">El libro no está disponible actualmente.</span>';
    header('Location: detalle_libro.php?id=' . $id_libro);
    exit;
}

// Crear préstamo
$fecha = date('Y-m-d');
$data = [
    'id_usuario' => $id_usuario,
    'id_libro' => $id_libro,
    'fecha_prestamo' => $fecha,
    'fecha_devolucion' => null,
    'estado' => 'Activo'
];
$insert_id = Prestamo::create($conexion, $data);
if ($insert_id) {
    // Marcar libro como no disponible
    $up = $conexion->prepare("UPDATE libros SET disponible = 0 WHERE id = ?");
    $up->bind_param('i', $id_libro);
    $up->execute();
    // Mensaje y redirección a mis préstamos
    $_SESSION['mensaje_prestamo'] = '<span style="color:green;">Solicitud de préstamo registrada. Revisa "Mis préstamos" para más detalles.</span>';
    header('Location: mis_prestamos.php');
    exit;
} else {
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">No se pudo registrar la solicitud. Intenta de nuevo.</span>';
    header('Location: detalle_libro.php?id=' . $id_libro);
    exit;
}

?>
