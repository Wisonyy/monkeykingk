<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$rol = $_SESSION['rol'];
if ($_SESSION['rol'] === 'admin') {
    header('Location: vista/admin/panel.php'); // si panel está directo ahí
    exit;
} elseif ($_SESSION['rol'] === 'cliente') {
    header('Location: vista/cliente/tienda.php');
    exit;
}
