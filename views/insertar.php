<?php
require_once '../configuracion/database.php';
require_once '../models/usuario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST["send"])) {
    $usuario = new Usuario();
    $name = '';
    $errorName = '';
    $ape = '';
    $errorApe = '';
    $correo = '';
    $errorCorreo = '';
    $pass = '';
    $errorContrasena = '';
    $flag = false;
    #validaciones
    $validName = $usuario->ValidName();
    if (!$validName['error']) {
        $errorName = $validName['msg'];
        $flag = true;
    } else {
        $name = $validName['campo2'];
    }
    $validSurname = $usuario->ValidSurname();
    if (!$validSurname['error']) {
        $errorApe = $validSurname['msg'];
        $flag = true;
    } else {
        $ape = $validSurname['campo2'];
    }
    $validEmail = $usuario->ValidEmail();
    if (!$validEmail['error']) {
        $errorCorreo = $validEmail['msg'];
        $flag = true;
    } else {
        $correo = $validEmail['campo2'];
    }
    $validPass = $usuario->ValidPass();
    if ($validPass['error']) {
        $errorContrasena = $validPass['msg'];
        $flag = true;
    } else {
        $pass = $validPass['campo2'];
    }
    if ($flag === false) {
        $usuario->nombre = $name;
        $usuario->apellido = $ape;
        $usuario->correo = $correo;
        $usuario->contrasena = password_hash($pass, PASSWORD_BCRYPT);
        $usuario->Agregar();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario para insertar</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="nombre" placeholder="nombre" value="<?= $name ?>" required autofocus
            autocomplete="off">
        <output><?= $errorName ?></output>
        <input type="text" name="apellido" placeholder="apellido" value="<?= $ape ?>" required autofocus
            autocomplete="off">
        <output><?= $errorApe ?></output>
        <input type="email" name="correo" placeholder="correo" value="<?= $correo ?>" required autofocus
            autocomplete="off">
        <output><?= $errorCorreo ?></output>
        <input type="password" name="contrasena" placeholder="contraseña" value="<?= $pass ?>" required autofocus
            autocomplete="off">
        <output><?= $errorContrasena ?></output>
        <button name="send" type="submit">Insertar</button>
    </form>
</body>
</html>