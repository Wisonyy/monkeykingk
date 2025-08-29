<?php
require_once '../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

require_once '../modelo/Producto.php';
$producto = new Producto();
$productos = $producto->obtenerTodos();

ob_start(); // Captura la salida HTML
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; font-size: 12px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Reporte de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio (S/)</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $fila): ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= $fila['nombre'] ?></td>
                <td><?= $fila['descripcion'] ?></td>
                <td><?= number_format($fila['precio'], 2) ?></td>
                <td><?= $fila['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$html = ob_get_clean(); // Captura HTML

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_productos.pdf", ["Attachment" => false]); // Muestra en navegador
?>
