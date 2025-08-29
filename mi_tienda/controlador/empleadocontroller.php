<?php
session_start();
include('../modelo/Empleado.php');

$empleado = new Empleado();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $id = $_POST['id'] ?? null;

    if ($accion === 'agregar') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $clave = $_POST['clave'];
        $empleado->agregar($nombre, $email, $clave);
    }

    if ($accion === 'desactivar' && $id) {
        $empleado->desactivar($id);
    }

    if ($accion === 'activar' && $id) {
        $empleado->activar($id);
    }
    
    header('Location: ../vista/admin/empleados.php');
    exit;
}
