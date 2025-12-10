<?php
// Catálogo de libros
session_start();
$titulo = 'Catálogo de Libros';
include 'includes/header.php';
require_once 'config/conexion.php';
require_once 'modelos/libro.php'; // REVISAR ESTO

$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$categoria = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';

// Obtener lista de categorías existentes para el select
$categorias = [];
$sqlCat = "SELECT DISTINCT categoria FROM libros WHERE categoria IS NOT NULL AND categoria <> '' ORDER BY categoria";
if ($resCat = $conexion->query($sqlCat)) {
    while ($r = $resCat->fetch_assoc()) {
        $categorias[] = $r['categoria'];
    }
    $resCat->free();
}

// Buscar libros según parámetros
$libros = Libro::search($conexion, $busqueda, $categoria);
?>
<div class="catalogo-bg">
    <div class="catalogo-container">
        <h2>Catálogo de Libros</h2>
        <form method="GET" action="catalogo.php">
            <input type="text" name="busqueda" placeholder="Buscar por título o autor" value="<?php echo htmlspecialchars($busqueda); ?>">
            <select name="categoria">
                <option value="">Todas las categorías</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $categoria === $cat ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Buscar</button>
        </form>
        <table class="tabla-libros">
            <thead>
                <tr>
                    <th>Portada</th>
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
            <?php if (count($libros) === 0): ?>
                <tr>
                    <td colspan="7">No se encontraron libros.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($libros as $libro): ?>
                <tr>
                    <td style="width:80px;">
                        <?php if ($libro['imagen']): ?>
                            <img src="uploads/portadas/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="Portada" style="width:60px; border-radius:6px;">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                    <td><?php echo htmlspecialchars($libro['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($libro['categoria']); ?></td>
                    <td><?php echo htmlspecialchars($libro['ano']); ?></td>
                    <td><?php echo $libro['disponible'] ? '<span style="color:green;">Disponible</span>' : '<span style="color:red;">No disponible</span>'; ?></td>
                    <td class="acciones-libro">
                        <a href="detalle_libro.php?id=<?php echo $libro['id']; ?>" title="Ver detalles">🔍</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
