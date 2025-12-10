<?php
// Sirve el archivo del libro sólo si el usuario tiene un préstamo activo válido
session_start();
require_once 'config/conexion.php';

if (!isset($_GET['id_prestamo'])) {
    http_response_code(400);
    echo 'Solicitud inválida.';
    exit;
}

$id_prestamo = (int)$_GET['id_prestamo'];

if (!isset($_SESSION['id_usuario'])) {
    // Redirigir a login para simplificar UX
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">Debes iniciar sesión para descargar archivos.</span>';
    header('Location: login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener el registro del préstamo y el nombre de archivo
$sql = "SELECT p.estado, l.archivo FROM prestamos p JOIN libros l ON p.id_libro = l.id WHERE p.id = ? AND p.id_usuario = ? LIMIT 1";
if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param('ii', $id_prestamo, $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    if (!$res || $res->num_rows === 0) {
        http_response_code(404);
        echo 'No autorizado o préstamo no encontrado.';
        exit;
    }
    $row = $res->fetch_assoc();
    if ($row['estado'] !== 'Activo') {
        http_response_code(403);
        echo 'El préstamo no está activo.';
        exit;
    }
    $archivo = $row['archivo'];
    $stmt->close();
} else {
    http_response_code(500);
    echo 'Error interno.';
    exit;
}

// Validar existencia del archivo en el filesystem
$ruta = __DIR__ . '/uploads/libros/' . $archivo;
if (!$archivo || !file_exists($ruta)) {
    http_response_code(404);
    echo 'Archivo no encontrado.';
    exit;
}

// Enviar el archivo con headers seguros
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $ruta);
finfo_close($finfo);

header('Content-Description: File Transfer');
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . basename($ruta) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($ruta));
readfile($ruta);
exit;

?>
