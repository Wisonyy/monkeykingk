<?php
class Empleado {
    private $conexion;

    public function __construct() {
        include(__DIR__ . '/../config.php');
        $this->conexion = $pdo;  // Asume que $pdo viene de config.php
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM usuarios WHERE rol = 'admin'";
        return $this->conexion->query($sql);
    }

    public function agregar($nombre, $email, $clave) {
        $rol = 'admin';
        $sql = "INSERT INTO usuarios (nombre, email, clave, rol, estado) VALUES (?, ?, ?, ?, 1)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nombre, $email, $clave, $rol]);
    }

   public function desactivar($id) {
    $sql = $this->conexion->prepare("UPDATE usuarios SET estado = 0 WHERE id = ? AND rol = 'admin'");
    return $sql->execute([$id]);
}

public function activar($id) {
    $sql = $this->conexion->prepare("UPDATE usuarios SET estado = 1 WHERE id = ? AND rol = 'admin'");
    return $sql->execute([$id]);
}

}
?>
