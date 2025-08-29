<?php
session_start();
include('../../modelo/Producto.php');

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito si viene por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $producto_id = $_POST['id'];
    $productoModelo = new Producto();
    $producto = $productoModelo->obtenerPorId($producto_id);

    if ($producto) {
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad']++;
        } else {
            $_SESSION['carrito'][$producto_id] = [
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => 1,
                'imagen' => $producto['imagen']
            ];
        }
    }
}

$carrito = $_SESSION['carrito'];
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>🛒 Tu Carrito</h2>

    <?php if (empty($carrito)): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Quitar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $id => $item): 
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= $item['nombre'] ?></td>
                    <td>S/<?= $item['precio'] ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>S/<?= number_format($subtotal, 2) ?></td>
                    <td>
                        <form method="post" action="../../controlador/carritoController.php">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button name="accion" value="quitar" class="btn btn-danger btn-sm">X</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total: S/<?= number_format($total, 2) ?></h4>
        <form method="post" action="../../controlador/carritoController.php">
            <button type="submit" name="accion" value="finalizar" class="btn btn-success">Finalizar Compra</button>
        </form>
    <?php endif; ?>
    <a href="tienda.php" class="btn btn-secondary mt-3">← Volver a la tienda</a>
</div>
</body>
</html>
