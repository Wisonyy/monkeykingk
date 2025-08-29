<?php
session_start();
require_once('../modelo/Cliente.php');

$cliente = new Cliente();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    switch ($accion) {
        case 'agregar':
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $clave = trim($_POST['clave'] ?? '');

            if ($nombre && $email && $clave) {
                $cliente->agregar($nombre, $email, $clave);
            }
            break;

        case 'desactivar':
            if (!empty($_POST['id'])) {
                $cliente->desactivar($_POST['id']);
            }
            break;

        case 'reactivar':
            if (!empty($_POST['id'])) {
                $cliente->reactivar($_POST['id']);
            }
            break;

        case 'eliminar':
            if (!empty($_POST['id'])) {
                $cliente->eliminar($_POST['id']);
            }
            break;
    }

    // Redirigir de vuelta a la vista de clientes
    header('Location: ../vista/admin/clientes.php');
    exit;
}
?>
