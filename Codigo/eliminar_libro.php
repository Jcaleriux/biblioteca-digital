<?php
// Elimina un libro y sus archivos asociados
session_start();
require_once 'config/conexion.php';
require_once 'modelos/libro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $libro = Libro::getById($conexion, $id);
    if (!$libro) {
        $_SESSION['mensaje_libro'] = '<span style="color:red;">Libro no encontrado.</span>';
        header('Location: panel_admin.php'); exit;
    }

    // borrar archivos si existen
    if ($libro['imagen']) {
        $pathImg = __DIR__ . '/uploads/portadas/' . $libro['imagen'];
        if (file_exists($pathImg)) {
            @unlink($pathImg);
        }
    }
    if ($libro['archivo']) {
        $pathFile = __DIR__ . '/uploads/libros/' . $libro['archivo'];
        if (file_exists($pathFile)) @unlink($pathFile);
    }

    $ok = Libro::delete($conexion, $id);
    if ($ok) {
        $_SESSION['mensaje_libro'] = '<span style="color:green;">Libro eliminado.</span>';
    } else {
        $_SESSION['mensaje_libro'] = '<span style="color:red;">No se pudo eliminar el libro.</span>';
    }
}
header('Location: panel_admin.php');
exit;
