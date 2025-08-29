<?php
session_start();
include('modelo/Usuario.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $clave = $_POST['clave'] ?? '';

  $usuario = new Usuario();
  $datos = $usuario->verificarLogin($email, $clave);

  if ($datos) {
    $_SESSION['usuario_id'] = $datos['id'];
    $_SESSION['rol'] = $datos['rol'];
    echo "<script>window.location='index.php';</script>";
    exit;
  } else {
    $error = '❌ Credenciales inválidas';
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="estilos/login.css">
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <div class="icon">
        🔒
      </div>
      <form method="post">
        <input type="email" name="email" placeholder="email" required>
        <input type="password" name="clave" placeholder="password" required>
        <button type="submit">SIGN IN</button>
        <?php if (!empty($error)): ?>
          <p class="error"><?= $error ?></p>
        <?php endif; ?>
       <p class="forgot">¿no tienes cuenta? <a href="registro.php">crear aquí</a></p>

        </a></p>
      </form>
    </div>
  </div>
</body>
</html>
