<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

include('../../modelo/Cliente.php');
$cliente = new Cliente();
$clientes = $cliente->obtenerClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <a href="../../reportes/reporte_clientes.php" target="_blank" class="btn btn-danger mb-3">📄 Descargar PDF</a>

</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">👥 Gestión de Clientes</h2>

    <form action="../../controlador/clienteController.php" method="post" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" required>
        </div>
        <div class="col-md-3">
            <input type="email" name="email" class="form-control" placeholder="Correo" required>
        </div>
        <div class="col-md-3">
            <input type="password" name="clave" class="form-control" placeholder="Contraseña" required>
        </div>
        <div class="col-md-3">
            <button type="submit" name="accion" value="agregar" class="btn btn-primary w-100">Agregar Cliente</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= $c['nombre'] ?></td>
                <td><?= $c['email'] ?></td>
                <td><?= $c['estado'] ? 'Activo' : 'Inactivo' ?></td>
                <td>
                    <form action="../../controlador/clienteController.php" method="post">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <button type="submit" name="accion" value="<?= $c['estado'] ? 'desactivar' : 'reactivar' ?>"
                                class="btn btn-<?= $c['estado'] ? 'warning' : 'success' ?> btn-sm">
                            <?= $c['estado'] ? 'Desactivar' : 'Reactivar' ?>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="panel.php" class="btn btn-secondary">← Volver al Panel</a>
</div>
</body>
</html>

