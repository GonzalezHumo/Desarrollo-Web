<?php
session_start();
include 'db.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo     = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conn, $sql);
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['usuario_id']     = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombres'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Iniciar Sesión</h2>
    <p><?= $error ?></p>
    <form method="POST">
        <input type="email" name="correo" placeholder="Correo electrónico" required><br><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br><br>
        <button type="submit">Entrar</button>
    </form>
    <br>
    <a href="registro.php">¿No tienes cuenta? Regístrate</a>
</body>
</html>