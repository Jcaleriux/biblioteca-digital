<?php
// Mostrar formulario de edición de libro
session_start();
require_once 'config/conexion.php';
require_once 'modelos/libro.php';

// El panel envía el id por POST cuando se hace clic en editar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $libro = Libro::getById($conexion, $id);
    if (!$libro) {
        // Si el libro no existe, volver al panel con mensaje
        $_SESSION['mensaje_libro'] = '<span style="color:red;">Libro no encontrado.</span>';
        header('Location: panel_admin.php');
        exit;
    }
} else {
    // Acceso directo sin POST: redirigir al panel admin
    header('Location: panel_admin.php');
    exit;
}

$mensaje = '';

$titulo = 'Editar Libro';
include 'includes/header.php';
?>
<div class="admin-container">
    <h2>Editar Libro</h2>
    <?php if ($mensaje) echo $mensaje; ?>
    <?php if ($libro): ?>
    <form method="POST" action="procesar_editar_libro.php" enctype="multipart/form-data" class="form-libro">
        <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
        <ul class="lista-libro">
            <li>
                <label for="titulo">Título:</label>
                <div class="input-icono-libro">
                    <span class="icono-user-libro"></span>
                    <input type="text" name="titulo" required value="<?php echo htmlspecialchars($libro['titulo']); ?>">
                </div>
            </li>
            <li>
                <label for="autor">Autor:</label>
                <div class="input-icono-libro">
                    <span class="icono-user-libro"></span>
                    <input type="text" name="autor" required value="<?php echo htmlspecialchars($libro['autor']); ?>">
                </div>
            </li>
            <li>
                <label for="isbn">ISBN:</label>
                <div class="input-icono-libro">
                    <span class="icono-mail-libro"></span>
                    <input type="text" name="isbn" required value="<?php echo htmlspecialchars($libro['isbn']); ?>">
                </div>
            </li>
            <li>
                <label for="categoria">Categoría:</label>
                <div class="input-icono-libro">
                    <span class="icono-user-libro"></span>
                    <input type="text" name="categoria" value="<?php echo htmlspecialchars($libro['categoria']); ?>">
                </div>
            </li>
            <li>
                <label for="ano">Año:</label>
                <div class="input-icono-libro">
                    <span class="icono-mail-libro"></span>
                    <input type="number" name="ano" min="0" value="<?php echo htmlspecialchars($libro['ano']); ?>">
                </div>
            </li>
            <li>
                <label for="disponible">Disponible:</label>
                <input type="checkbox" name="disponible" value="1" <?php echo $libro['disponible'] ? 'checked' : ''; ?>>
            </li>
            <li>
                <label>Portada actual:</label>
                <?php if ($libro['imagen']): ?>
                    <div><img src="uploads/portadas/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada" style="max-width:120px; border-radius:6px;"></div>
                <?php else: ?>
                    <div>No hay portada.</div>
                <?php endif; ?>
            </li>
            <li>
                <label for="imagen_portada">Cambiar portada (opcional):</label>
                <input type="file" name="imagen_portada" accept="image/*">
            </li>
            <li>
                <label>Archivo actual:</label>
                <?php if ($libro['archivo']): ?>
                    <div><a href="uploads/libros/<?php echo htmlspecialchars($libro['archivo']); ?>" target="_blank">Ver archivo</a></div>
                <?php else: ?>
                    <div>No hay archivo.</div>
                <?php endif; ?>
            </li>
            <li>
                <label for="archivo_libro">Cambiar archivo (opcional):</label>
                <input type="file" name="archivo_libro" accept="application/pdf,application/epub+zip,.epub">
            </li>
            <li>
                <button type="submit" class="btn-libro">Guardar cambios</button>
            </li>
        </ul>
    </form>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
