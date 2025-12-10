<?php
session_start(); 

require_once 'config/conexion.php';

$mensaje = '';

// Verificación del método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? ''); 
    $apellido = trim($_POST['apellido'] ?? ''); 
    $correo = trim($_POST['correo'] ?? ''); 
    $password = $_POST['password'] ?? ''; 
    $confirmar = $_POST['confirmar'] ?? '';

    // Validación si hay campos vacíos
    if ($nombre === '' || $apellido === '' || $correo === '' || $password === '' || $confirmar === '') {
        $mensaje = '<span style="color:red;">Todos los campos son obligatorios.</span>';
    // Validación del correo, que tenga formato válido
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = '<span style="color:red;">El correo no es válido.</span>';
    // Validación de coincidencia de contraseñas
    } elseif ($password !== $confirmar) {
        $mensaje = '<span style="color:red;">Las contraseñas no coinciden.</span>';
    } else {
        // Verifica si el correo ya está registrado en la base de datos
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1"); // Prepara la consulta
        $stmt->bind_param('s', $correo); // Asocia el parámetro
        $stmt->execute(); // Ejecuta la consulta
        $stmt->store_result(); // Almacena el resultado
        if ($stmt->num_rows > 0) { // Si existe el correo es decir si alguna fila fue devuelta muestra el mensaje de error
            $mensaje = '<span style="color:red;">El correo ya está registrado.</span>';
        } else {
            // Inserta el nuevo usuario en la base de datos
            $hash = password_hash($password, PASSWORD_DEFAULT); // Hashea la contraseña
            $rol = 'lector'; // Asigna el rol por defecto/(Por ahora no se designa el rol en la pagina de registro, pienso agregarlo en el panel de admin)
            $stmt_insert = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, correo, password, rol) VALUES (?, ?, ?, ?, ?)"); // Prepara la inserción
            $stmt_insert->bind_param('sssss', $nombre, $apellido, $correo, $hash, $rol); // Asocia los parámetros
            //bind_param: Es el método que vincula (asocia) las variables PHP con los ? de la consulta SQL.
            // Esto sirve para: Evitar inyecciones SQL (más seguro que concatenar cadenas) y convertir automáticamente los valores al tipo correcto.
            if ($stmt_insert->execute()) { // Ejecuta la inserción
                // Guarda el mensaje de registro exitoso en sesión y redirige al login
                $_SESSION['registro_exitoso'] = '<span style="color:green;">¡Registro exitoso! Ahora puedes iniciar sesión.</span>';
                header('Location: login.php');
                exit;
            } else {
                $mensaje = '<span style="color:red;">Error al registrar. Intenta de nuevo.</span>';
            }
            $stmt_insert->close(); // Cierra la consulta de inserción
        }
        $stmt->close(); // Cierra la consulta de verificación
    }
}

// Si hay mensaje de error, guarda el mensaje y los datos en sesión y redirige a registro.php
if ($mensaje) {
    $_SESSION['mensaje'] = $mensaje; // Guarda el mensaje de error en sesión
    // Guarda los datos ingresados para que el usuario no tenga que volver a escribirlos
    $_SESSION['datos'] = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo
    ];
    header('Location: registro.php');
    exit;
}
?>
