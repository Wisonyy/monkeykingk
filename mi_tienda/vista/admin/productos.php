<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}

include('../../modelo/Producto.php');
$producto = new Producto();
$resultado = $producto->obtenerTodos(); // Esto devuelve un PDOStatement
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <a href="../../reportes/reporte_productos.php" class="btn btn-primary mb-3" target="_blank">📄 Generar PDF</a>

</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Gestión de Productos</h2>

    <form method="post" action="../../controlador/productoController.php" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="col">
                <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
            </div>
            <div class="col">
                <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required>
            </div>
            <div class="col">
                <input type="file" name="imagen" class="form-control" required>
            </div>
            <div class="col">
                <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio (S/)</th>
            <th>Imagen</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= $fila['nombre'] ?></td>
                <td><?= $fila['descripcion'] ?></td>
                <td><?= $fila['precio'] ?></td>
                <td><img src="../../<?= $fila['imagen'] ?>" width="50"></td>
                <td><?= $fila['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                <td>
                    <form method="post" action="../../controlador/productoController.php" onsubmit="return confirm('¿Está seguro?');">
                        <input type="hidden" name="id" value="<?= $fila['id'] ?>">
                        <?php if ($fila['estado'] == 1): ?>
                            <button name="accion" value="desactivar" class="btn btn-warning btn-sm">Desactivar</button>
                        <?php else: ?>
                            <button name="accion" value="reactivar" class="btn btn-info btn-sm">Reactivar</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="panel.php" class="btn btn-secondary">← Volver al panel</a>
</div>
</body>
</html>
