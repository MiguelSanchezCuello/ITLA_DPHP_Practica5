<?php

require "producto.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProducto = $_POST['id_producto'];

    foreach ($_SESSION['productos'] as $index => $producto) {
        if($producto->getId() == $idProducto){
            array_splice($_SESSION['productos'], $index, 1);
            break;
        }
    }

    header("Location: gestionar_productos.php");
    exit();
}
?>
