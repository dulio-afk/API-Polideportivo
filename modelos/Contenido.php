<?php
class Contenido {
    private $conexion;

    // Constructor que acepta la conexión como argumento
    public function __construct($db) {
        $this->conexion = $db;
    }

    // Método para obtener todos los contenidos
    public function obtenerTodos() {
        try {
            $query = "SELECT * FROM contenidos";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            echo "Error al obtener contenidos: " . $e->getMessage();
            return [];
        }
    }

    // Método para obtener un contenido por su ID
    public function obtenerPorId($id) {
        $query = "SELECT * FROM contenidos WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Método para crear un nuevo contenido
    public function crear($titulo, $descripcion, $tipo, $horario, $imagenUrl) {
        $query = "INSERT INTO contenidos (titulo, descripcion, tipo, horario, imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('sssss', $titulo, $descripcion, $tipo, $horario, $imagenUrl);
        return $stmt->execute();
    }

    // Método para editar contenido existente
    public function editar($id, $titulo, $descripcion, $tipo, $horario, $imagenUrl) {
        $query = "UPDATE contenidos SET titulo = ?, descripcion = ?, tipo = ?, horario = ?, imagen = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('sssssi', $titulo, $descripcion, $tipo, $horario, $imagenUrl, $id);
        return $stmt->execute();
    }

    // Método para eliminar contenido
    public function eliminar($id) {
        $query = "DELETE FROM contenidos WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
