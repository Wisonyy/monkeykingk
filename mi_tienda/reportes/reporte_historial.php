<?php
require '../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

require('../modelo/Compra.php');
require('../config.php');

$compra = new Compra($pdo);
$historial = $compra->obtenerHistorial();

ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
    </style>
</head>
<body>
    <h2>🧾 Historial de Compras</h2>
    <table>
        <thead>
            <tr>
                <th>ID Compra</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($historial as $fila): ?>
            <tr>
                <td><?= $fila['compra_id'] ?></td>
                <td><?= $fila['cliente'] ?></td>
                <td><?= $fila['fecha_compra'] ?></td>
                <td><?= $fila['producto'] ?></td>
                <td><?= $fila['cantidad'] ?></td>
                <td>S/<?= number_format($fila['precio'], 2) ?></td>
                <td>S/<?= number_format($fila['subtotal'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("historial_compras.pdf", ["Attachment" => false]);
?>
