<?php
// Mis préstamos
session_start();
$titulo = 'Mis Préstamos';
include 'includes/header.php';
?>
<?php
require_once 'config/conexion.php';
require_once 'modelos/prestamo.php';

$mensaje = '';
if (isset($_SESSION['mensaje_prestamo'])) {
    $mensaje = $_SESSION['mensaje_prestamo'];
    unset($_SESSION['mensaje_prestamo']);
}

if (!isset($_SESSION['id_usuario'])) {
    // Usuario no autenticado
    $_SESSION['mensaje_prestamo'] = '<span style="color:red;">Debes iniciar sesión para ver tus préstamos.</span>';
    header('Location: login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$prestamos = Prestamo::getByUser($conexion, $id_usuario);
?>
<div class="prestamos-bg">
    <div class="prestamos-container">
        <h2>Mis Préstamos</h2>
        <?php if ($mensaje) echo $mensaje; ?>
        <?php if (count($prestamos) === 0): ?>
            <p>No tienes préstamos registrados.</p>
        <?php else: ?>
            <table class="tabla-libros">
                <thead>
                    <tr>
                        <th>Portada</th>
                        <th>Libro</th>
                        <th>Autor</th>
                        <th>Fecha préstamo</th>
                        <th>Fecha devolución</th>
                        <th>Archivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($prestamos as $p): ?>
                    <tr>
                        <td style="width:80px;">
                            <?php if ($p['imagen']): ?>
                                <img src="uploads/portadas/<?php echo htmlspecialchars($p['imagen']); ?>" alt="Portada" style="width:60px; border-radius:6px;">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($p['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($p['autor']); ?></td>
                        <td><?php echo htmlspecialchars($p['fecha_prestamo']); ?></td>
                        <td><?php echo htmlspecialchars($p['fecha_devolucion'] ?? '-'); ?></td>
                        <td>
                            <?php if ($p['estado'] === 'Activo' && $p['archivo']): ?>
                                <a href="descarga_archivo.php?id_prestamo=<?php echo $p['id']; ?>">Ver/Descargar</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($p['estado']); ?></td>
                        <td>
                            <?php if ($p['estado'] === 'Activo'): ?>
                                <form method="POST" action="procesar_devolucion.php" style="display:inline;">
                                    <input type="hidden" name="id_prestamo" value="<?php echo $p['id']; ?>">
                                    <button type="submit" class="btn-libro">Devolver</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
