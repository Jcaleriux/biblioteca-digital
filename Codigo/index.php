<?php
// Página de inicio - Biblioteca Digital Universe
session_start();
$titulo = 'Inicio';
include 'includes/header.php';
?>
<div class="inicio-bg">
    <div class="inicio-container">
        <h1>Bienvenido a Biblioteca Digital Universe</h1>
        <p>Nuestra biblioteca digital permite a lectores y administradores gestionar libros,
             realizar préstamos y acceder a una amplia colección de títulos desde cualquier dispositivo.</p>
        <p>Explora, administra y disfruta de la lectura en línea con facilidad y seguridad.</p>
            <?php
            if (isset($_SESSION['nombre'])) {
                            echo '<div style="margin-bottom: 25px;">';
                            echo '<h2>¡Hola, ' . htmlspecialchars($_SESSION['nombre']) . '!</h2><br>';
                            echo '<a href="mis_prestamos.php" class="tarjeta">Ir a mis préstamos</a>';
                            echo '</div>';
            } else {
                include 'vistas/tarjetas_inicio.php';
            }
            ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
