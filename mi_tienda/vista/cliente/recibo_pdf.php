<?php
require '../../librerias/dompdf/autoload.inc.php';
require '../../config.php';
require '../../modelo/Compra.php';

use Dompdf\Dompdf;

$id = $_GET['id'] ?? null;
$compra = new Compra($pdo);
$detalles = $compra->obtenerCompraPorId($id);

ob_start();
?>
<h2 style="text-align:center;"> Recibo de Compra</h2>
<h3 style="text-align:center;">Distribuidora Codisac</h3>
<p><strong>Cliente:</strong> <?= $detalles[0]['cliente'] ?></p>
<p><strong>Fecha:</strong> <?= $detalles[0]['fecha_compra'] ?></p>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
<tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr>
<?php $total = 0;
foreach ($detalles as $item): 
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
</table>
<h3>Total: S/ <?= number_format($total, 2) ?></h3>
<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("recibo_compra.pdf", ["Attachment" => false]);
?>
