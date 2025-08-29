<?php
class Usuario {
    private $conexion;

    public function __construct() {
        require(__DIR__ . '/../config.php'); // Carga $pdo
        $this->conexion = $pdo;
    }

    public function verificarLogin($email, $clave) {
        $sql = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $sql->execute([$email]);
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $clave === $usuario['clave']) {
            return $usuario;
        }
        return false;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM usuarios";
        return $this->conexion->query($sql);
    }

    public function agregar($nombre, $email, $clave, $rol) {
        $estado = 1;
        $sql = $this->conexion->prepare("INSERT INTO usuarios (nombre, email, clave, rol, estado) VALUES (?, ?, ?, ?, ?)");
        return $sql->execute([$nombre, $email, $clave, $rol, $estado]);
    }

    public function eliminar($id) {
        $sql = $this->conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function desactivar($id) {
        $sql = $this->conexion->prepare("UPDATE usuarios SET estado = 0 WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function activar($id) {
        $sql = $this->conexion->prepare("UPDATE usuarios SET estado = 1 WHERE id = ?");
        return $sql->execute([$id]);
    }

    public function existeEmail($email) {
        $sql = $this->conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $sql->execute([$email]);
        return $sql->fetchColumn() > 0;
    }

    public function registrarCliente($nombre, $email, $clave) {
        $rol = 'cliente';
        $estado = 1;
        $sql = $this->conexion->prepare("INSERT INTO usuarios (nombre, email, clave, rol, estado) VALUES (?, ?, ?, ?, ?)");
        return $sql->execute([$nombre, $email, $clave, $rol, $estado]);
    }
}
?>
