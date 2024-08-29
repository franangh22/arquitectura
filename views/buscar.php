<?php
require_once '../configuracion/database.php';
require_once '../models/Usuario.php';
$id = '';
$id_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST['send'])) {
    $user = new Usuario();
    $flag = false;
    $validID = $user->ValidNumber();
    if ($validID['error']) {
        $id_error = $validID['msg'];
        $flag = true;
    } else {
        $id = $validID['campo2'];
    }
    if ($flag === false) {
        $user->id = $id;
        $user->BuscarID();
    }
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
    <form action="" method="post">
        <input type="text" name="id" placeholder="ingrese ID" value="<?= $id ?>" required autocomplete="off" autofocus>
        <output class="msg_error"><?= $id_error ?></output>
        <button class="btn" name="send" type="submit">Buscar</button>
    </form>
</body>

</html>