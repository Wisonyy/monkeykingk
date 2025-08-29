<?php
session_start();
include('modelo/Usuario.php');

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $clave = trim($_POST['clave'] ?? '');

  if ($nombre && $email && $clave) {
    $usuario = new Usuario();
    $existe = $usuario->existeEmail($email);

    if ($existe) {
      $mensaje = '⚠️ El email ya está registrado.';
    } else {
      $usuario->registrarCliente($nombre, $email, $clave);
      $mensaje = '✅ Registro exitoso. Puedes iniciar sesión.';
    }
  } else {
    $mensaje = '⚠️ Todos los campos son obligatorios.';
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link rel="stylesheet" href="estilos/login.css">
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <div class="icon">📝</div>
      <form method="post">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <button type="submit">REGISTRARSE</button>
        <?php if ($mensaje): ?>
          <p class="error"><?= $mensaje ?></p>
        <?php endif; ?>
        <p class="forgot">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
      </form>
    </div>
  </div>
</body>
</html>
