<?php
// Panel de administración
session_start();
$titulo = 'Panel de Administración';
include 'includes/header.php';
require_once 'config/conexion.php';

// Mensaje de acción
$mensaje = '';
if (isset($_SESSION['mensaje_libro'])) {
    $mensaje = $_SESSION['mensaje_libro'];
    unset($_SESSION['mensaje_libro']);
}

// Obtener libros de la base de datos
$libros = [];
$sql = "SELECT id, titulo, autor, isbn, categoria, ano, disponible FROM libros";
$result = $conexion->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $libros[] = $row;
    }
}
?>
<div class="admin-bg">
    <div class="admin-container">
        <h2>Panel de Administración</h2>
        <?php if ($mensaje) echo $mensaje; ?>
        <!-- Botón para mostrar/ocultar el formulario -->
        <button id="btn-mostrar-form" class="btn-libro" onclick="document.getElementById('form-libro').style.display = (document.getElementById('form-libro').style.display === 'none' ? 'block' : 'none');">Agregar nuevo libro</button>
        <!-- Formulario para agregar libro -->
        <div id="form-libro" class="form-libro" style="display:none;">
            <h3>Registrar libro</h3>
            <form method="POST" action="procesar_libro.php" class="form-libro" enctype="multipart/form-data">
                    <ul class="lista-libro">
                        <li>
                            <label for="titulo">Título:</label>
                            <div class="input-icono-libro">
                                <span class="icono-user-libro"></span>
                                <input type="text" name="titulo" required>
                            </div>
                        </li>
                        <li>
                            <label for="autor">Autor:</label>
                            <div class="input-icono-libro">
                                <span class="icono-user-libro"></span>
                                <input type="text" name="autor" required>
                            </div>
                        </li>
                        <li>
                            <label for="isbn">ISBN:</label>
                            <div class="input-icono-libro">
                                <span class="icono-mail-libro"></span>
                                <input type="text" name="isbn" required>
                            </div>
                        </li>
                        <li>
                            <label for="categoria">Categoría:</label>
                            <div class="input-icono-libro">
                                <span class="icono-user-libro"></span>
                                <input type="text" name="categoria">
                            </div>
                        </li>
                        <li>
                            <label for="ano">Año:</label>
                            <div class="input-icono-libro">
                                <span class="icono-mail-libro"></span>
                                <input type="number" name="ano" min="0">
                            </div>
                        </li>
                        <li>
                            <label for="disponible">Disponible:</label>
                            <input type="checkbox" name="disponible" value="1" checked>
                        </li>
                        <li>
                            <label for="imagen_portada">Portada (imagen):</label>
                            <input type="file" name="imagen_portada" accept="image/*">
                        </li>
                        <li>
                            <label for="archivo_libro">Archivo (PDF/EPUB):</label>
                            <input type="file" name="archivo_libro" accept="application/pdf,application/epub+zip,.epub">
                        </li>
                        <li>
                            <button type="submit" class="btn-libro">Registrar libro</button>
                        </li>
                    </ul>
                </form>
        </div>
        <!-- Tabla de libros -->
        <div style="margin-top:40px;">
            <table class="tabla-libros">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>ISBN</th>
                        <th>Categoría</th>
                        <th>Año</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                        <td><?php echo htmlspecialchars($libro['isbn']); ?></td>
                        <td><?php echo htmlspecialchars($libro['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($libro['ano']); ?></td>
                        <td><?php echo $libro['disponible'] ? '<span style="color:green;">Disponible</span>' : '<span style="color:red;">No disponible</span>'; ?></td>
                        <td class="acciones-libro">
                            <form method="POST" action="editar_libro.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
                                <button type="submit" title="Editar" class="editar"><span>✏️</span></button>
                            </form>
                            <form method="POST" action="eliminar_libro.php" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este libro?');">
                                <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
                                <button type="submit" title="Eliminar" class="eliminar"><span>🗑️</span></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
