<?php
    require "producto.php";

    session_start();

    $productos = [];
    if(isset($_SESSION["productos"])){
        $productos = $_SESSION["productos"];
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion de Productos</title>
</head>
<body>
    <?php include "header.php" ?>
    <h1>Gestion de Productos</h1>

    <p><a href="crear_producto.php">Crear Producto</a></p><br>

    <?php if(!$productos):  ?>
        <!-- Listao de productos en blanco -->
        <p>No hay productos en el registro de productos. Proceda a crear productos.</p>
    <?php print_r($productos); ?>
    <?php else : ?>
        <table border="1">
            <head>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </head>
            <tbody>
                <?php foreach($productos as $producto): ?>
                <tr>
                    <td><?= $producto->getId()?></td>
                    <td><?= $producto->getNombre() ?></td>
                    <td><?= $producto->getPrecio() ?></td>
                    <td>
                        <a href="editar_producto.php?id_producto=<?= $producto->getId()?>">Editar</a>
                        <form method="post" style="display:inline;" action="eliminar_producto.php">
                            <input type="hidden" name="id_producto" value="<?= $producto->getId()?>">
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