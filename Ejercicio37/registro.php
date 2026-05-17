<?php
include 'db.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres    = $_POST['nombres'];
    $apellidos  = $_POST['apellidos'];
    $correo     = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombres, apellidos, correo, contrasena) 
            VALUES ('$nombres', '$apellidos', '$correo', '$contrasena')";

    if (mysqli_query($conn, $sql)) {
        $mensaje = "Usuario registrado correctamente.";
    } else {
        $mensaje = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Registro</title></head>
<body>
    <h2>Registrar Usuario</h2>
    <p><?= $mensaje ?></p>
    <form method="POST">
        <input type="text" name="nombres" placeholder="Nombre(s)" required><br><br>
        <input type="text" name="apellidos" placeholder="Apellido(s)" required><br><br>
        <input type="email" name="correo" placeholder="Correo electrónico" required><br><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br><br>
        <button type="submit">Registrar</button>
    </form>
    <br>
    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
</body>
</html>