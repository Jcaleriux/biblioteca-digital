<?php
// Modelo de préstamo para operaciones con la base de datos
class Prestamo {
    // Registra un nuevo préstamo. $data: id_usuario, id_libro, fecha_prestamo (YYYY-MM-DD), fecha_devolucion (nullable), estado
    public static function create($conexion, $data) {
        $sql = "INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, fecha_devolucion, estado) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conexion->prepare($sql)) {
            $id_usuario = $data['id_usuario'];
            $id_libro = $data['id_libro'];
            $fecha_prestamo = $data['fecha_prestamo'];
            $fecha_devolucion = $data['fecha_devolucion'] ?? null;
            $estado = $data['estado'] ?? 'Activo';
            $stmt->bind_param('iisss', $id_usuario, $id_libro, $fecha_prestamo, $fecha_devolucion, $estado);
            $ok = $stmt->execute();
            if ($ok) {
                $insert_id = $stmt->insert_id;
                $stmt->close();
                return $insert_id;
            }
            $stmt->close();
        }
        return false;
    }

    // Obtiene préstamos por usuario
    public static function getByUser($conexion, $id_usuario) {
        $prestamos = [];
        $sql = "SELECT p.id, p.id_usuario, p.id_libro, p.fecha_prestamo, p.fecha_devolucion, p.estado, l.titulo, l.autor, l.imagen, l.archivo FROM prestamos p JOIN libros l ON p.id_libro = l.id WHERE p.id_usuario = ? ORDER BY p.fecha_prestamo DESC";
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param('i', $id_usuario);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) $prestamos[] = $row;
            $stmt->close();
        }
        return $prestamos;
    }
}
