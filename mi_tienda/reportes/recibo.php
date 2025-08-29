<?php
require_once '../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include('../modelo/Compra.php');
include('../config.php');

$id = $_GET['id'] ?? 0;
$compra = new Compra($pdo);
$datos = $compra->obtenerDetalleCompra($id);

if (empty($datos)) {
    echo "No se encontró la compra.";
    exit;
}

ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>🧾 Recibo de Compra - Comercial Codisac</h2>
    <p><strong>Cliente:</strong> <?= $datos[0]['cliente'] ?></p>
    <p><strong>Fecha:</strong> <?= $datos[0]['fecha'] ?></p>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>
        <?php 
        $total = 0;
        foreach ($datos as $item): 
            $subtotal = $item['cantidad'] * $item['precio'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $item['producto'] ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td>S/ <?= number_format($item['precio'], 2) ?></td>
            <td>S/ <?= number_format($subtotal, 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="3">Total</th>
            <th>S/ <?= number_format($total, 2) ?></th>
        </tr>
    </table>
</body>
</html>
<?php
$html = ob_get_clean();

// Opciones de DomPDF
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("recibo_codisac.pdf", ["Attachment" => false]); // true para forzar descarga
