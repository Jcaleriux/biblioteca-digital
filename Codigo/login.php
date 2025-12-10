<?php
// Página de login
session_start();
$titulo = 'Iniciar Sesión';
include 'includes/header.php';
?>
<div class = "login-bg" >
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php
        $error = '';
        $registro_exitoso = '';
        if (isset($_SESSION['login_error'])) {
            $error = $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }
        if (isset($_SESSION['registro_exitoso'])) {
            $registro_exitoso = $_SESSION['registro_exitoso'];
            unset($_SESSION['registro_exitoso']);
        }
        ?>
        <?php if ($registro_exitoso) { echo '<p style="font-size: large;">' . $registro_exitoso . '</p>'; } ?>
        <?php if ($error) { echo '<p style="color:red;">' . $error . '</p>'; } ?>
        <form method="POST" action="procesar_login.php" class="form-login">
            <ul class="lista-login">
                <li>
                    <label for="correo">Correo:</label>
                    <div class="input-icono-login">
                        <span class="icono-mail-login"></span>
                        <input type="email" name="correo" required>
                    </div>
                </li>
                <li>
                    <label for="password">Contraseña:</label>
                    <div class="input-icono-login">
                        <span class="icono-lock-login"></span>
                        <input type="password" name="password" required>
                    </div>
                </li>
                <li>
                    <button type="submit" class="btn-login">Iniciar sesión</button>
                </li>
            </ul>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>