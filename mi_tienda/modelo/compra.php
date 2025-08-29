<?php
class Compra {
    private $conexion;

    public function __construct($pdo) {
        $this->conexion = $pdo;
    }
public function guardarCompra($usuario_id, $carrito) {
    try {
        $this->conexion->beginTransaction();

        $sqlCompra = "INSERT INTO compras (usuario_id, fecha) VALUES (?, NOW())";
        $stmt = $this->conexion->prepare($sqlCompra);
        $stmt->execute([$usuario_id]);

        $compra_id = $this->conexion->lastInsertId(); // ✅ ID correcto

        $sqlDetalle = "INSERT INTO detalle_compra (compra_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)";
        $stmtDetalle = $this->conexion->prepare($sqlDetalle);

        foreach ($carrito as $id => $item) {
            $stmtDetalle->execute([
                $compra_id,
                $id,
                $item['cantidad'],
                $item['precio']
            ]);
        }

        $this->conexion->commit();
        return $compra_id; // ✅ Devuelve el ID
    } catch (Exception $e) {
        $this->conexion->rollBack();
        error_log("Error en guardarCompra: " . $e->getMessage());
        return false;
    }
}


    public function obtenerHistorial() {
        $sql = "
            SELECT 
                c.id AS compra_id,
                u.nombre AS cliente,
                c.fecha AS fecha_compra,
                p.nombre AS producto,
                dc.cantidad,
                dc.precio,
                (dc.cantidad * dc.precio) AS subtotal
            FROM detalle_compra dc
            INNER JOIN compras c ON dc.compra_id = c.id
            INNER JOIN usuarios u ON c.usuario_id = u.id
            INNER JOIN productos p ON dc.producto_id = p.id
            ORDER BY c.fecha DESC
        ";

        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Método para obtener los detalles de una compra específica
    public function obtenerDetalleCompra($id) {
        $sql = "SELECT 
                    c.id,
                    u.nombre AS cliente,
                    c.fecha,
                    p.nombre AS producto,
                    dc.cantidad,
                    dc.precio
                FROM detalle_compra dc
                INNER JOIN compras c ON dc.compra_id = c.id
                INNER JOIN usuarios u ON c.usuario_id = u.id
                INNER JOIN productos p ON dc.producto_id = p.id
                WHERE c.id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerCompraPorId($id) {
    $sql = "
        SELECT 
            c.id AS compra_id,
            u.nombre AS cliente,
            c.fecha AS fecha_compra,
            p.nombre AS producto,
            dc.cantidad,
            dc.precio,
            (dc.cantidad * dc.precio) AS subtotal
        FROM detalle_compra dc
        INNER JOIN compras c ON dc.compra_id = c.id
        INNER JOIN usuarios u ON c.usuario_id = u.id
        INNER JOIN productos p ON dc.producto_id = p.id
        WHERE c.id = ?
    ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}

