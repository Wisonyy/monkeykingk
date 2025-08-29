<?php
class Cliente {
    private $conexion;

    public function __construct() {
        require(__DIR__ . '/../config.php'); // esto debe definir $pdo
        $this->conexion = $pdo;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM usuarios WHERE rol = 'cliente'";
        return $this->conexion->query($sql);
    }

    public function obtenerClientes() {
        $sql = "SELECT * FROM usuarios WHERE rol = 'cliente'";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ Método correcto
    }

    public function agregar($nombre, $email, $clave) {
        $rol = 'cliente';
        $estado = 1;
        $sql = $this->conexion->prepare("INSERT INTO usuarios (nombre, email, clave, rol, estado) VALUES (?, ?, ?, ?, ?)");
        return $sql->execute([$nombre, $email, $clave, $rol, $estado]);
    }

    public function desactivar($id) {
        $sql = $this->conexion->prepare("UPDATE usuarios SET estado = 0 WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function reactivar($id) {
        $sql = $this->conexion->prepare("UPDATE usuarios SET estado = 1 WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function eliminar($id) {
        $sql = $this->conexion->prepare("DELETE FROM usuarios WHERE id = ? AND rol = 'cliente'");
        return $sql->execute([$id]);
    }
}
?>

