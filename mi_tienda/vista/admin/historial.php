<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

require '../../config.php';
require '../../modelo/Compra.php';

$compra = new Compra($pdo);
$historial = $compra->obtenerHistorial();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>📄 Historial de Compras</h2>
    <a href="../../reportes/reporte_historial.php" class="btn btn-outline-primary mb-3" target="_blank">📥 Generar PDF</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Compra ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach ($historial as $compra): ?>
    <tr>
        <td><?= $compra['compra_id'] ?></td>  <!-- antes 'id' -->
        <td><?= $compra['cliente'] ?></td>
        <td><?= $compra['fecha_compra'] ?></td> <!-- antes 'fecha' -->
        <td><?= $compra['producto'] ?></td>
        <td><?= $compra['cantidad'] ?></td>
        <td>S/ <?= number_format($compra['precio'], 2) ?></td>
        <td>S/ <?= number_format($compra['subtotal'], 2) ?></td>
    </tr>
<?php endforeach; ?>

        </tbody>
    </table>

    <a href="panel.php" class="btn btn-secondary">← Volver al panel</a>
</body>
</html>
