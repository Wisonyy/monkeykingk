<?php
session_start();
if (!isset($_GET['id'])) { echo "ID de compra no encontrado."; exit; }

require '../../config.php';
require '../../modelo/Compra.php';

$compra = new Compra($pdo);
$detalles = $compra->obtenerCompraPorId($_GET['id']);
if (empty($detalles)) { echo "Compra no encontrada."; exit; }

$cliente = $detalles[0]['cliente'];
$fecha = $detalles[0]['fecha_compra'];
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo - Distribuidora Codisac</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="text-center">📄 Recibo de Compra</h2>
    <h4 class="text-center">Distribuidora Codisac</h4>
    <p><strong>Cliente:</strong> <?= $cliente ?></p>
    <p><strong>Fecha y hora:</strong> <?= $fecha ?></p>

    <table class="table table-bordered mt-4">
        <thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr></thead>
        <tbody>
        <?php foreach ($detalles as $item): 
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        ?>
            <tr>
                <td><?= $item['producto'] ?></td>
                <td><?= $item['cantidad'] ?></td>
                <td>S/ <?= number_format($item['precio'], 2) ?></td>
                <td>S/ <?= number_format($subtotal, 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="text-end">Total: S/ <?= number_format($total, 2) ?></h4>

    <a href="recibo_pdf.php?id=<?= $_GET['id'] ?>" target="_blank" class="btn btn-primary">⬇️ Descargar PDF</a>
    <a href="tienda.php" class="btn btn-secondary">← Volver a la tienda</a>
</body>
</html>
