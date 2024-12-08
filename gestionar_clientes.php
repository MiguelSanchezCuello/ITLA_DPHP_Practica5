<?php
    require "cliente.php";

    session_start();

    $clientes = [];
    if(isset($_SESSION["clientes"])){
        $clientes = $_SESSION["clientes"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion de Clientes</title>
</head>
<body>
    <?php include "header.php" ?>
    <h1>Gestion de Clientes</h1>


    <p><a href="crear_cliente.php">Crear Cliente</a></p><br>

    <?php if(!$clientes) : ?>
        <h2>No hay clientes registrados, por favor proceda a agregar clientes.</h2>
    <?php else : ?>
        <table border="1">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($clientes as $cliente) : ?>
                <tr>
                    <td><?= $cliente->getId(); ?></td>
                    <td><?= $cliente->getNombre(); ?></td>
                    <td>
                        <a href="editar_cliente.php?id=<?= $cliente->getId(); ?>">Editar</a>
                        <form method="post" style="display:inline;" action="eliminar_cliente.php">
                            <!--                    <input type="hidden" name="accion" value="eliminar_cliente">-->
                            <input type="hidden" name="id_cliente" value="<?= $cliente->getId(); ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>


</body>
</html>