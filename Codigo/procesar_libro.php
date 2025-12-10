<?php
// Procesa alta de libro: valida inputs, sube archivos y usa modelo Libro
session_start();
require_once 'config/conexion.php';
require_once 'modelos/libro.php';

// Preparar mensajes
$mensaje = '';
$datos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolectar campos
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $isbn = trim($_POST['isbn'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $ano = $_POST['ano'] ?? '';
    $disponible = isset($_POST['disponible']) ? 1 : 0;
    $descripcion = $_POST['descripcion'] ?? null;

    // Guardar datos para volver a mostrarlos si hay error
    $datos = [
        'titulo' => $titulo,
        'autor' => $autor,
        'isbn' => $isbn,
        'categoria' => $categoria,
        'ano' => $ano,
        'disponible' => $disponible,
        'descripcion' => $descripcion
    ];

    // Validaciones básicas
    if ($titulo === '' || $autor === '' || $isbn === '') {
        $mensaje = '<span style="color:red;">Título, autor e ISBN son obligatorios.</span>';
    }

    // Manejo de archivos
    $imagen_nombre = null;
    if (isset($_FILES['imagen_portada']) && $_FILES['imagen_portada']['error'] !== UPLOAD_ERR_NO_FILE) {
        $img = $_FILES['imagen_portada'];
        // Validar tamaño (<= 2MB) y tipo
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
            // guardar
            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
            $imagen_nombre = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            $dest = __DIR__ . '/uploads/portadas/';
            if (!is_dir($dest)) mkdir($dest, 0755, true);
            if (!move_uploaded_file($img['tmp_name'], $dest . $imagen_nombre)) {
                $mensaje = '<span style="color:red;">No se pudo guardar la imagen.</span>';
            }
        }
    }

    $archivo_nombre = null;
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
            // algunos servidores devuelven application/octet-stream para epub
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
            }
        }
    }

    // Si no hay mensajes de error, crear el registro
    if ($mensaje === '') {
        $data = [
            'titulo' => $titulo,
            'autor' => $autor,
            'isbn' => $isbn,
            'categoria' => $categoria,
            'ano' => $ano,
            'descripcion' => $descripcion,
            'imagen' => $imagen_nombre,
            'archivo' => $archivo_nombre,
            'disponible' => $disponible
        ];
        $id = Libro::create($conexion, $data);
        if ($id) {
            $_SESSION['mensaje_libro'] = '<span style="color:green;">Libro registrado correctamente.</span>';
            header('Location: panel_admin.php');
            exit;
        } else {
            $mensaje = '<span style="color:red;">Error al guardar en la base de datos.</span>';
        }
    }
}

// En caso de error, guardar mensaje y datos para mostrar en el formulario
if ($mensaje !== '') {
    $_SESSION['mensaje_libro'] = $mensaje;
    $_SESSION['datos_libro'] = $datos;
    header('Location: panel_admin.php');
    exit;
}

header('Location: panel_admin.php');
exit;
