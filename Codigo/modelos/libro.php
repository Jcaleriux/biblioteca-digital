<?php
// Modelo de libro para operaciones CRUD
class Libro {
    // Obtiene todos los libros (array asociativo)
    public static function getAll($conexion) {
        $libros = [];
        $sql = "SELECT id, titulo, autor, isbn, categoria, ano, descripcion, imagen, archivo, disponible FROM libros ORDER BY titulo";
        if ($result = $conexion->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $libros[] = $row;
            }
            $result->free();
        }
        return $libros;
    }

    // Obtiene un libro por id
    public static function getById($conexion, $id) {
        $sql = "SELECT id, titulo, autor, isbn, categoria, ano, descripcion, imagen, archivo, disponible FROM libros WHERE id = ? LIMIT 1";
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $libro = $res->fetch_assoc();
            $stmt->close();
            return $libro ?: null;
        }
        return null;
    }

    // Crea un nuevo libro. $data es un array con keys: titulo, autor, isbn, categoria, ano, descripcion, imagen, archivo, disponible
    public static function create($conexion, $data) {
        $sql = "INSERT INTO libros (titulo, autor, isbn, categoria, ano, descripcion, imagen, archivo, disponible) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conexion->prepare($sql)) {
            // Asegurar índices y valores por defecto
            $titulo = $data['titulo'] ?? '';
            $autor = $data['autor'] ?? '';
            $isbn = $data['isbn'] ?? '';
            $categoria = $data['categoria'] ?? null;
            $ano = isset($data['ano']) && $data['ano'] !== '' ? (int)$data['ano'] : null;
            $descripcion = $data['descripcion'] ?? null;
            $imagen = $data['imagen'] ?? null;
            $archivo = $data['archivo'] ?? null;
            $disponible = isset($data['disponible']) ? 1 : 0;

            // tipos: s=string, i=int -> titulo,autor,isbn,categoria,ano,descripcion,imagen,archivo,disponible
            $stmt->bind_param('ssssisssi', $titulo, $autor, $isbn, $categoria, $ano, $descripcion, $imagen, $archivo, $disponible);
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

    // Actualiza un libro por id. $data similar a create
    public static function update($conexion, $id, $data) {
        $sql = "UPDATE libros SET titulo = ?, autor = ?, isbn = ?, categoria = ?, ano = ?, descripcion = ?, imagen = ?, archivo = ?, disponible = ? WHERE id = ?";
        if ($stmt = $conexion->prepare($sql)) {
            $titulo = $data['titulo'] ?? '';
            $autor = $data['autor'] ?? '';
            $isbn = $data['isbn'] ?? '';
            $categoria = $data['categoria'] ?? null;
            $ano = isset($data['ano']) && $data['ano'] !== '' ? (int)$data['ano'] : null;
            $descripcion = $data['descripcion'] ?? null;
            $imagen = $data['imagen'] ?? null;
            $archivo = $data['archivo'] ?? null;
            $disponible = isset($data['disponible']) ? 1 : 0;

            $stmt->bind_param('ssssisssii', $titulo, $autor, $isbn, $categoria, $ano, $descripcion, $imagen, $archivo, $disponible, $id);
            $ok = $stmt->execute();
            $stmt->close();
            return $ok;
        }
        return false;
    }

    // Elimina un libro por id
    public static function delete($conexion, $id) {
        $sql = "DELETE FROM libros WHERE id = ?";
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param('i', $id);
            $ok = $stmt->execute();
            $stmt->close();
            return $ok;
        }
        return false;
    }

    // Buscar libros por título o autor y opcionalmente por categoría
    public static function search($conexion, $query = '', $categoria = '') {
        $libros = [];
        $like = '%' . $query . '%';
        if ($categoria !== '') {
            $sql = "SELECT id, titulo, autor, isbn, categoria, ano, descripcion, imagen, archivo, disponible FROM libros WHERE (titulo LIKE ? OR autor LIKE ?) AND categoria = ? ORDER BY titulo";
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param('sss', $like, $like, $categoria);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_assoc()) $libros[] = $row;
                $stmt->close();
            }
        } else {
            $sql = "SELECT id, titulo, autor, isbn, categoria, ano, descripcion, imagen, archivo, disponible FROM libros WHERE titulo LIKE ? OR autor LIKE ? ORDER BY titulo";
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param('ss', $like, $like);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_assoc()) $libros[] = $row;
                $stmt->close();
            }
        }
        return $libros;
    }
}
