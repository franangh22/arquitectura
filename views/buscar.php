<?php
require_once '../configuracion/database.php';
require_once '../models/Usuario.php';


$user = new Usuario();
$usuarios = $user->BuscarTodos();

$name = '';
$errorName = '';
$ape = '';
$errorApe = '';
$mailt = '';
$errorCorreo = '';
$pass = '';
$errorContrasena = '';
$upd_name = '';
$upd_ape = '';
$upd_mail = '';
$upd_pass = '';
if ($_SERVER['REQUEST_METHOD'] === "POST" || isset($_POST['send'])) {
    $flag = false;
    #validaciones
    $validName = $user->ValidName();
    if ($validName['error']) {
        $errorName = $validName['msg'];
        $flag = true;
    } else {
        $name = $validName['campo2'];
    }
    $validSurname = $user->ValidSurname();
    if ($validSurname['error']) {
        $errorApe = $validSurname['msg'];
        $flag = true;
    } else {
        $ape = $validSurname['campo2'];
    }
    $validEmail = $user->ValidEmail();
    if ($validEmail['error']) {
        $errorCorreo = $validEmail['msg'];
        $flag = true;
    } else {
        $mailt = $validEmail['campo2'];
    }
    $validPass = $user->ValidPass();
    if ($validPass['error']) {
        $errorContrasena = $validPass['msg'];
        $flag = true;
    } else {
        $pass = $validPass['campo2'];
    }
    if ($flag === false) {
        $nombre = $name;
        $apellido = $ape;
        $correo = $mailt;
        $contrasena = password_hash($pass, PASSWORD_BCRYPT);
        $user->Agregar($nombre, $apellido, $correo, $contrasena);
        header('location:buscar.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST['update'])) {
    $flag = false;
    $validName = $user->ValidName();
    if ($validName['error']) {
        $errorName = $validName['msg'];
        $flag = true;
    } else {
        $upd_name = $validName['campo2'];
    }
    $validSurname = $user->ValidSurname();
    if ($validSurname['error']) {
        $errorApe = $validSurname['msg'];
        $flag = true;
    } else {
        $upd_ape = $validSurname['campo2'];
    }
    $validEmail = $user->ValidEmail();
    if ($validEmail['error']) {
        $errorCorreo = $validEmail['msg'];
        $flag = true;
    } else {
        $upd_mail = $validEmail['campo2'];
    }
    $validPass = $user->ValidPass();
    if ($validPass['error']) {
        $errorContrasena = $validPass['msg'];
        $flag = true;
    } else {
        $upd_pass = $validPass['campo2'];
    }
    if ($flag === false) {
        $id = $_GET['actualizar'];
        $nombre = $upd_name;
        $apellido = $upd_ape;
        $correo = $upd_mail;
        $contrasena = password_hash($upd_pass, PASSWORD_BCRYPT);
        $user->Actualizar($id, $nombre, $apellido, $correo, $contrasena);
        header('location:buscar.php');
        exit;
    }

}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $user->Eliminar($id);
    header('location:buscar.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
    <title>buscar</title>
</head>

<body>
    <div class="content">
        <h1>Lista de usuarios</h1>
        <div class="grid">
            <?php foreach ($usuarios as $usuario): ?>
                <ul>
                    <li><span>Nombre:</span> <?= $usuario->nombre ?></li>
                    <li><span>Apellido:</span> <?= $usuario->apellido ?></li>
                    <li><span>Correo:</span> <?= $usuario->correo ?></li>
                    <li class="pass"><span>contraseña:</span> <?= $usuario->contrasena ?></li>
                    <li class="actions"><span>Acciones:</span>
                        <a class="delete" href="buscar.php?eliminar=<?= $usuario->id ?>"
                            onclick="return confirm('¿Seguro que desea eliminar?');">Eliminar</a>
                        <a class="update" id="btnUPD" href="buscar.php?actualizar=<?= $usuario->id ?>">Actualizar</a>
                    </li>
                </ul>
            <?php endforeach; ?>
        </div>
        <a class="add" id="btnAbrir">Crear otro</a>
    </div>

    <!-- Add modal START -->
    <script src="../public/modal.js"></script>
    <div class="add-modal" id="Abrirmodal">
        <div class="flex-content">
            <form action="" method="post">
                <span class="close">&times;</span>
                <h2>Añadir usuario</h2>
                <input type="text" name="nombre" placeholder="nombre" value="<?= $upd_name ?>" required autofocus
                    autocomplete="off">
                <output class="msg_error"><?= $errorName ?></output>
                <input type="text" name="apellido" placeholder="apellido" value="<?= $upd_ape ?>" required autofocus
                    autocomplete="off">
                <output class="msg_error"><?= $errorApe ?></output>
                <input type="email" name="correo" placeholder="correo" value="<?= $upd_mail ?>" required autofocus
                    autocomplete="off">
                <output class="msg_error"><?= $errorCorreo ?></output>
                <input type="password" name="contrasena" placeholder="contraseña" value="<?= $upd_pass ?>" required
                    autofocus autocomplete="off">
                <output class="msg_error"><?= $errorContrasena ?></output>
                <button name="send" class="btnAdd" type="submit">Agregar</button>
            </form>
        </div>
    </div>
    <!-- Add modal END -->
    <!-- Start update modal  -->
    <script src="../public/update_modal.js"></script>
    <div class="upd-modal" id="upd-modal">
        <div class="flex-content">
            <form action="" method="post">
                <span class="cerrar">&times;</span>
                <h2>Actualizar</h2>
                <input type="text" name="nombre" placeholder="nombre" value="<?= $usuario->nombre ?>" required autofocus
                    autocomplete="off">
                <output class="msg_error"><?= $errorName ?></output>
                <input type="text" name="apellido" placeholder="apellido" value="<?= $usuario->apellido ?>" required
                    autofocus autocomplete="off">
                <output class="msg_error"><?= $errorApe ?></output>
                <input type="email" name="correo" placeholder="correo" value="<?= $usuario->correo ?>" required
                    autofocus autocomplete="off">
                <output class="msg_error"><?= $errorCorreo ?></output>
                <input type="password" name="contrasena" placeholder="contraseña" value="<?= $usuario->contrasena ?>"
                    required autofocus autocomplete="off">
                <output class="msg_error"><?= $errorContrasena ?></output>
                <button name="update" class="btnAdd" type="submit">Actualizar</button>
            </form>
        </div>
    </div>
    <!-- End update modal  -->
</body>

</html>