<?php
class Producto {
    private $conexion;

    public function __construct() {
        require(__DIR__ . '/../config.php'); // esto carga $pdo
        $this->conexion = $pdo;              // y lo asigna a la clase
    }

    public function obtenerActivos() {
        $sql = "SELECT * FROM productos WHERE estado = 1";
        return $this->conexion->query($sql);
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM productos";
        return $this->conexion->query($sql);
    }

    public function agregar($nombre, $descripcion, $precio, $imagen) {
        $sql = $this->conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen, estado) VALUES (?, ?, ?, ?, 1)");
        return $sql->execute([$nombre, $descripcion, $precio, $imagen]);
    }

    public function desactivar($id) {
        $sql = $this->conexion->prepare("UPDATE productos SET estado = 0 WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function reactivar($id) {
        $sql = $this->conexion->prepare("UPDATE productos SET estado = 1 WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = $this->conexion->prepare("SELECT * FROM productos WHERE id = ?");
        $sql->execute([$id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}
