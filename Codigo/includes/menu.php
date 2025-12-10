<?php
// Menu de navegación
// valida que la sesión esté iniciada antes de acceder a $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="menu">
    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="catalogo.php">Cat&aacute;logo</a></li>
        <li><a href="mis_prestamos.php">Pr&eacute;stamos</a></li>

        <?php if (!isset($_SESSION['nombre'])): ?>
            <li><a href="registro.php">Registrarse</a></li>
            <li><a href="login.php">Iniciar Sesi&oacute;n</a></li>
        <?php else: ?>
            <?php // Mostrar enlace de Panel Admin; JS controla visibilidad ?>
                <li><a href="panel_admin.php" id="admin-link">Panel Admin</a></li>
            <li><a href="logout.php">Cerrar sesi&oacute;n</a></li>
        <?php endif; ?>
    </ul>
</nav>
<!-- Validación básica en cliente: crear variable con el rol de PHP y ocultar enlace si no es admin -->
<?php // Garantizar que la sesión esté activa antes de leer rol ?>
<!-- La sesión ya se inició arriba, no es necesario repetir session_start aquí -->
<script>
    window.userRole = <?php echo isset($_SESSION['rol']) ? json_encode($_SESSION['rol']) : 'null'; ?>;
    document.addEventListener('DOMContentLoaded', function(){
        var adminLink = document.getElementById('admin-link');
        if (adminLink) {
            if (typeof window.userRole !== 'string' || window.userRole !== 'admin') {
                // ocultar enlace si no es admin
                adminLink.style.display = 'none';
            }
        }
    });
</script>
