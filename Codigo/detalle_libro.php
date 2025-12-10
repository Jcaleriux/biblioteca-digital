<?php
// Vista detallada del libro
session_start();
$titulo = 'Detalle del Libro';
include 'includes/header.php';
require_once 'config/conexion.php';
require_once 'modelos/libro.php';

$libro = null;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $libro = Libro::getById($conexion, $id);
}
?>
<div class="detalle-bg">
    <div class="detalle-container">
        <h2>Detalle del Libro</h2>
        <?php if (!$libro): ?>
            <p>No se encontró el libro.</p>
        <?php else: ?>
            <div style="display:flex; gap:20px; align-items:flex-start; justify-content:center;">
                <div style="flex:0 0 280px;">
                    <?php if ($libro['imagen']): ?>
                        <img src="uploads/portadas/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada" style="width:100%; border-radius:8px;">
                    <?php else: ?>
                        <div style="width:100%; height:380px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">Sin imagen</div>
                    <?php endif; ?>
                </div>
                <div style="max-width:600px; text-align:left;">
                    <h3><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                    <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
                    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($libro['isbn']); ?></p>
                    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($libro['categoria']); ?></p>
                    <p><strong>Año:</strong> <?php echo htmlspecialchars($libro['ano']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($libro['descripcion'])); ?></p>
                    <p><strong>Estado:</strong> <?php echo $libro['disponible'] ? '<span style="color:green;">Disponible</span>' : '<span style="color:red;">Prestado</span>'; ?></p>
                    <!-- Nota: el archivo no se muestra ni se descarga directamente. El usuario debe solicitar el préstamo para obtenerlo. -->
                    <?php if ($libro['disponible'] && isset($_SESSION['nombre'])): ?>
                        <form method="POST" action="procesar_prestamo.php">
                            <input type="hidden" name="id_libro" value="<?php echo $libro['id']; ?>">
                            <button type="submit" class="btn-registro">Solicitar préstamo</button>
                        </form>
                    <?php elseif ($libro['disponible']): ?>
                        <p>Inicia sesión para solicitar préstamo.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
