<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: ../../login.php');
    exit;
}

include('../../modelo/Producto.php');
$producto = new Producto();
$productos = $producto->obtenerActivos(); // Solo productos activos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .carrito-flotante {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
    <script>
    function buscarProducto() {
        let input = document.getElementById("buscador").value.toLowerCase();
        let cards = document.querySelectorAll(".producto");

        cards.forEach(card => {
            let nombre = card.querySelector("h5").textContent.toLowerCase();
            card.style.display = nombre.includes(input) ? "block" : "none";
        });
    }

    function agregarAlCarrito(id) {
        fetch('../../ajax/agregar_carrito.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + encodeURIComponent(id)
        }); // No alert ni mensaje visible
    }
    </script>
</head>
<body>

<!-- Botón flotante para ir al carrito -->
<div class="carrito-flotante">
    <a href="carrito.php" class="btn btn-primary">🛒 Ver carrito</a>
</div>

<div class="container mt-5">
    <h2 class="mb-4">🛒 Tienda Virtual</h2>

    <!-- 🔍 Buscador -->
    <div class="input-group mb-4">
        <input type="text" id="buscador" class="form-control" placeholder="Buscar producto..." onkeyup="buscarProducto()">
        <span class="input-group-text">🔍</span>
    </div>

    <div class="row">
        <?php while ($fila = $productos->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="col-md-3 mb-4 producto">
            <div class="card h-100 shadow-sm">
                <img src="../../<?= $fila['imagen'] ?>" class="card-img-top" alt="<?= $fila['nombre'] ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= $fila['nombre'] ?></h5>
                    <p class="card-text"><?= $fila['descripcion'] ?></p>
                    <p class="card-text fw-bold">S/ <?= $fila['precio'] ?></p>
                    <button onclick="agregarAlCarrito(<?= $fila['id'] ?>)" class="btn btn-success">Agregar al carrito</button>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <div class="mt-4">
        <a href="../../logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
</div>
</body>
</html>
