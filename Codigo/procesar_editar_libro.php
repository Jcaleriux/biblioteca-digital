<?php
// Procesa la edición de un libro (reemplaza archivos si se suben)
session_start();
require_once 'config/conexion.php';
require_once 'modelos/libro.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $libro = Libro::getById($conexion, $id);
    if (!$libro) {
        $_SESSION['mensaje_libro'] = '<span style="color:red;">Libro no encontrado.</span>';
        header('Location: panel_admin.php'); exit;
    }

    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $isbn = trim($_POST['isbn'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $ano = $_POST['ano'] ?? '';
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    // manejar imagen
    $imagen_nombre = $libro['imagen'];
    if (isset($_FILES['imagen_portada']) && $_FILES['imagen_portada']['error'] !== UPLOAD_ERR_NO_FILE) {
        $img = $_FILES['imagen_portada'];
        $maxImg = 2 * 1024 * 1024;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $img['tmp_name']);
        finfo_close($finfo);
        $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
        if ($img['error'] !== UPLOAD_ERR_OK) {
            $mensaje = '<span style="color:red;">Error al subir la imagen.</span>';
        } elseif ($img['size'] > $maxImg) {
            $mensaje = '<span style="color:red;">La imagen excede 2MB.</span>';
        } elseif (!in_array($mime, $allowed)) {
            $mensaje = '<span style="color:red;">Formato de imagen no permitido.</span>';
        } else {
            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
            $imagen_nombre = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            $dest = __DIR__ . '/uploads/portadas/';
            if (!is_dir($dest)) mkdir($dest, 0755, true);
            if (!move_uploaded_file($img['tmp_name'], $dest . $imagen_nombre)) {
                $mensaje = '<span style="color:red;">No se pudo guardar la imagen.</span>';
            } else {
                // eliminar la anterior si existía
                if ($libro['imagen'] && file_exists($dest . $libro['imagen'])) {
                    @unlink($dest . $libro['imagen']);
                }
            }
        }
    }

    // manejar archivo
    $archivo_nombre = $libro['archivo'];
    if (isset($_FILES['archivo_libro']) && $_FILES['archivo_libro']['error'] !== UPLOAD_ERR_NO_FILE) {
        $f = $_FILES['archivo_libro'];
        $maxFile = 20 * 1024 * 1024; // 20MB
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $f['tmp_name']);
        finfo_close($finfo);
        $allowedFiles = ['application/pdf','application/epub+zip','application/octet-stream'];
        if ($f['error'] !== UPLOAD_ERR_OK) {
            $mensaje = '<span style="color:red;">Error al subir el archivo del libro.</span>';
        } elseif ($f['size'] > $maxFile) {
            $mensaje = '<span style="color:red;">El archivo excede 20MB.</span>';
        } elseif (!in_array($mime, $allowedFiles)) {
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
            if ($mime !== 'application/pdf' && $ext !== 'epub') {
                $mensaje = '<span style="color:red;">Formato de archivo no permitido (solo PDF o EPUB).</span>';
            }
        }
        if ($mensaje === '') {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $archivo_nombre = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            $dest = __DIR__ . '/uploads/libros/';
            if (!is_dir($dest)) mkdir($dest, 0755, true);
            if (!move_uploaded_file($f['tmp_name'], $dest . $archivo_nombre)) {
                $mensaje = '<span style="color:red;">No se pudo guardar el archivo del libro.</span>';
            } else {
                if ($libro['archivo'] && file_exists($dest . $libro['archivo'])) {
                    @unlink($dest . $libro['archivo']);
                }
            }
        }
    }

    if ($mensaje === '') {
        $data = [
            'titulo' => $titulo,
            'autor' => $autor,
            'isbn' => $isbn,
            'categoria' => $categoria,
            'ano' => $ano,
            'descripcion' => $libro['descripcion'],
            'imagen' => $imagen_nombre,
            'archivo' => $archivo_nombre,
            'disponible' => $disponible
        ];
        $ok = Libro::update($conexion, $id, $data);
        if ($ok) {
            $_SESSION['mensaje_libro'] = '<span style="color:green;">Libro actualizado correctamente.</span>';
            header('Location: panel_admin.php'); exit;
        } else {
            $_SESSION['mensaje_libro'] = '<span style="color:red;">Error al actualizar el libro.</span>';
            header('Location: panel_admin.php'); exit;
        }
    } else {
        $_SESSION['mensaje_libro'] = $mensaje;
        header('Location: editar_libro.php'); exit;
    }
}

header('Location: panel_admin.php');
exit;
