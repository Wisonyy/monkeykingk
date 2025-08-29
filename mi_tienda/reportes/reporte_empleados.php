<?php
require '../librerias/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include('../modelo/Empleado.php');
$empleado = new Empleado();
$resultado = $empleado->obtenerTodos();

ob_start();
?>

<h2 style="text-align:center;">REPORTE DE EMPLEADOS</h2>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultado as $fila): ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= $fila['nombre'] ?></td>
            <td><?= $fila['email'] ?></td>
            <td><?= $fila['rol'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$html = ob_get_clean();
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_empleados.pdf", ["Attachment" => false]);
?>
