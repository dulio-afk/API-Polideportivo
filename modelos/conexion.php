<?php
// Utiliza __DIR__ para obtener la ruta del directorio actual
require_once __DIR__ . '/../config/configuracion.php';

class Conexion {
    private $conexion;

    public function abrirConexion() {
        $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $this->conexion->connect_error);
        }
        return $this->conexion; // Devolvemos la conexión
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>
