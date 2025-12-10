<?php
// Página de registro de usuarios
session_start();
$titulo = 'Registro de Usuario';
include 'includes/header.php';
?>
<?php
// Verificación si hubo un mensaje de error o éxito en el registro.
$mensaje = ''; 
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // unset elimina el mensaje de la sesión para que no se muestre nuevamente
}
// Si hubo un error en el registro, guarda los datos ingresados en sesión para que el usuario no tenga que volver a escribirlos
$datos = [
    'nombre' => '',
    'apellido' => '',
    'correo' => ''
];
if (isset($_SESSION['datos'])) {
    $datos = $_SESSION['datos'];
    unset($_SESSION['datos']);
}
?>
<!-- Estructura del formulario de registro -->
<div class="registro-bg">
    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <?php if ($mensaje) echo $mensaje; // Mostramos el mensaje de error si lo hubo.?>
        <form method="POST" action="procesar_registro.php" class="form-registro">
            <ul class="lista-registro">
                <li>
                    <label for="nombre">Nombre:</label>
                    <div class="input-icono">
                        <span class="icono-user"></span>
                            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($datos['nombre']); ?>">
                    </div>
                </li>
                <li>
                    <label for="apellido">Apellido:</label>
                    <div class="input-icono">
                        <span class="icono-user"></span>
                            <input type="text" name="apellido" required value="<?php echo htmlspecialchars($datos['apellido']); ?>">
                    </div>
                </li>
                <li>
                    <label for="correo">Correo:</label>
                    <div class="input-icono">
                        <span class="icono-mail"></span>
                            <input type="email" name="correo" required value="<?php echo htmlspecialchars($datos['correo']); ?>">
                    </div>
                </li>
                <li>
                    <label for="password">Contraseña:</label>
                    <div class="input-icono">
                        <span class="icono-lock"></span>
                        <input type="password" name="password" required>
                    </div>
                </li>
                <li>
                    <label for="confirmar">Confirmar Contraseña:</label>
                    <div class="input-icono">
                        <span class="icono-lock"></span>
                        <input type="password" name="confirmar" required>
                    </div>
                </li>
                <li>
                    <button type="submit" class="btn-registro">Registrarse</button>
                </li>
            </ul>
    </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
