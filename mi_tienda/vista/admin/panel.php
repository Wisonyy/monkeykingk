<?php
// vista/admin/panel.php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Bienvenido, Administrador</h2>

    <div class="row mt-4">
        <div class="col-md-4">
            <a href="empleados.php" class="btn btn-primary w-100">Gestionar Empleados</a>
        </div>
        <div class="col-md-4">
            <a href="clientes.php" class="btn btn-success w-100">Gestionar Clientes</a>
        </div>
        <div class="col-md-4">
            <a href="productos.php" class="btn btn-warning w-100">Gestionar Productos</a>
        </div>
        <a href="historial.php" class="btn btn-outline-dark">📋 Ver Historial de Compras</a>

    </div>

    <div class="text-end mt-4">
        <a href="../../logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
</div>
</body>
</html>
