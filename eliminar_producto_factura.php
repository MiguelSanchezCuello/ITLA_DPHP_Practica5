<?php

require_once "factura.php";
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $idFactura = $_POST['id_factura'];
    $idCliente = $_POST['id_cliente'];
    $idProducto = $_POST['id_producto'];
    foreach ($_SESSION["facturas"] as $index => $factura) {
        if($factura->getId() == $idFactura){
            $_SESSION["facturas"][$index]->eliminarProductoPorId($idProducto);
            break;
        }
    }

    foreach ($_SESSION["clientes"] as $index => $cliente) {
        echo "idCliente: " . $idCliente . "<br><br>";
        if($cliente->getId() == $idCliente){
            $_SESSION['clientes'][$index]->eliminarProducto($idProducto);
            break;
        }
    }
}

header("Location: editar_factura.php?id_factura=".$idFactura."&id_cliente=".$idCliente);
exit();

?>