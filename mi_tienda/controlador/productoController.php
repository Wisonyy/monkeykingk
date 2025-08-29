<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

include('../modelo/Producto.php');
$producto = new Producto();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'agregar') {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = trim($_POST['precio'] ?? '');

        if (empty($nombre) || empty($descripcion) || empty($precio) || empty($_FILES['imagen']['name'])) {
            echo "⚠️ Todos los campos son obligatorios.";
            exit;
        }

        if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagenNombre = basename($_FILES['imagen']['name']);
            $imagenTmp = $_FILES['imagen']['tmp_name'];
            $rutaDestino = '../imagenes/' . $imagenNombre;

            if (move_uploaded_file($imagenTmp, $rutaDestino)) {
                $rutaBD = 'imagenes/' . $imagenNombre;
                $producto->agregar($nombre, $descripcion, $precio, $rutaBD);
                header('Location: ../vista/admin/productos.php');
                exit;
            } else {
                echo "⚠️ Error al mover la imagen.";
            }
        } else {
            echo "⚠️ Error en la imagen.";
        }
    }

    if ($accion === 'desactivar') {
        $producto->desactivar($_POST['id']);
        header('Location: ../vista/admin/productos.php');
        exit;
    }

    if ($accion === 'reactivar') {
        $producto->reactivar($_POST['id']);
        header('Location: ../vista/admin/productos.php');
        exit;
    }
}
?>
