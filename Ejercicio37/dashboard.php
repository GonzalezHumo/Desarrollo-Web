<?php
session_start();

// Si no hay sesión, redirige al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h2>¡Bienvenido, <?= $_SESSION['usuario_nombre'] ?>!</h2>
    <p>Esta es la <strong>sección exclusiva</strong> solo visible para usuarios que han iniciado sesión.</p>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>