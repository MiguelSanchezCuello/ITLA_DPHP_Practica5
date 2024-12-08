<?php

require_once "factura.php";
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $idFactura = $_POST['id_factura'];
    $idCliente = $_POST['id_cliente'];
    foreach ($_SESSION["facturas"] as $index => $factura) {
        if($factura->getId() == $idFactura){
            array_splice($_SESSION["facturas"], $index, 1);
            break;
        }
    }
}

header("Location: gestionar_facturas.php?id=$idCliente");
exit();

?>
