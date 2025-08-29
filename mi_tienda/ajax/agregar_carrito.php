<?php
session_start();
include('../../modelo/Producto.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $productoModelo = new Producto();
        $producto = $productoModelo->obtenerPorId($id);

        if ($producto) {
            if (!isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id] = [
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'cantidad' => 1
                ];
            } else {
                $_SESSION['carrito'][$id]['cantidad']++;
            }
            echo json_encode(['status' => 'ok', 'mensaje' => 'Producto agregado']);
        } else {
            echo json_encode(['status' => 'error', 'mensaje' => 'Producto no encontrado']);
        }
    }
}
?>
