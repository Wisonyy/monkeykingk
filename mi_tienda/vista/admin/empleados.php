<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

require('../../modelo/Empleado.php');
$empleado = new Empleado();
$resultado = $empleado->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <a href="../../reportes/reporte_empleados.php" target="_blank" class="btn btn-danger mb-3">📄 Descargar PDF</a>

</head>
<body>
<div class="container mt-5">
    <h2>👥 Gestión de Empleados</h2>

    <form method="post" action="../../controlador/empleadoController.php" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
        </div>
        <div class="col-md-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-3">
            <input type="password" name="clave" class="form-control" placeholder="Clave" required>
        </div>
        <div class="col-md-3">
            <button type="submit" name="accion" value="agregar" class="btn btn-success w-100">Agregar</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= $fila['nombre'] ?></td>
                    <td><?= $fila['email'] ?></td>
                    <td>
                        <?= $fila['estado'] == 1 ? '<span class="text-success">Activo</span>' : '<span class="text-danger">Inactivo</span>' ?>
                    </td>
                    <td>
                        <form method="post" action="../../controlador/empleadoController.php" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                            <?php if ($fila['estado'] == 1): ?>
                                <button type="submit" name="accion" value="desactivar" class="btn btn-warning btn-sm">Desactivar</button>
                            <?php else: ?>
                                <button type="submit" name="accion" value="activar" class="btn btn-primary btn-sm">Activar</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="panel.php" class="btn btn-secondary mt-3">← Volver al panel</a>
</div>
</body>
</html>
