<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

include('../config.php');
include('../modelo/Compra.php');
$compra = new Compra($pdo);

// Agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'agregar') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];

        if (!isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id] = [
                'nombre' => $nombre,
                'precio' => $precio,
                'cantidad' => 1
            ];
        } else {
            $_SESSION['carrito'][$id]['cantidad']++;
        }

        header('Location: ../vista/cliente/tienda.php');
        exit;
    }

    // Quitar producto
    if ($accion === 'quitar') {
        $id = $_POST['id'];
        unset($_SESSION['carrito'][$id]);

        header('Location: ../vista/cliente/carrito.php');
        exit;
    }

    // Finalizar compra
if ($accion === 'finalizar') {
    if (!empty($_SESSION['carrito']) && isset($_SESSION['usuario_id'])) {
        $id_compra = $compra->guardarCompra($_SESSION['usuario_id'], $_SESSION['carrito']);

        if ($id_compra) {
            $_SESSION['carrito'] = []; // Vaciar carrito
            header("Location: ../vista/cliente/recibo.php?id=$id_compra");
            exit;
        } else {
            echo "❌ Error al guardar la compra.";
        }
    } else {
        echo "⚠️ Carrito vacío o usuario no identificado.";
    }
}

}
