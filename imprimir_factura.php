<?php

require_once "factura.php";

session_start();

if(!isset($_GET['id_cliente'])){
    die("Cliente no identificado");
}

$idCliente = $_GET['id_cliente'];
$cliente = null;

// Buscamos el cliente.
foreach ($_SESSION['clientes'] as $client){
    if($client->getId() == $idCliente){
        $cliente = $client;
        break;
    }
}

if(!$cliente){
    die("Cliente no encontrado");
}

// Ahora vamos con la factura.
if(!isset($_GET['id_factura'])){
    die("Factura no identificada");
}

$idFactura = $_GET['id_factura'];
$factura = null;

foreach ($_SESSION['facturas'] as $fact){
    if($fact->getId() == $idFactura){
        $factura = $fact;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Imprimir Factura</title>
    <?php include "estilos_tabla_factura.php" ?>
</head>
<body>
<?php include "header.php"; ?>
<br><br>
<table id="tabla-factura" border="1">
    <thead>
    <th colspan="3">ID de Factura: <?= $factura->getId() ?></th>
    <th colspan="2"><?= $factura->getFecha() ?> </th>
    </thead>
    <tbody>
    <tr>
        <td colspan="2">
            <strong>Comercial Sanchez:</strong><br>
            Calle Durate #6 <br>
            Santo Domingo, DN
        </td>
        <td colspan="2">
            <strong>Cliente:</strong> <br>
            <?= $cliente->getNOmbre() ?> <br>
            Otras Informaciones <br>
            Del cliente
        </td>
    </tr>
    </tbody>
    <thead>
    <tr>
        <th>Producto</th>
        <th>Precio Unitario</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($factura->getProductosFactura() as $productoFactura): ?>
        <tr>
            <td><?= $productoFactura->producto->getNombre() ?></td>
            <td><?= $productoFactura->producto->getPrecio() ?></td>
            <td><?= $productoFactura->getCantidad() ?></td>
            <td><?= $productoFactura->getSubTotal() ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <th><strong>Total: </strong> </th>
        <td colspan="3" style="text-align: right"><strong><?php echo number_format($factura->calcularTotal(),2) ?></strong></td>
    </tr>
    </tbody>
</table>
<script>window.print();</script>
</body>
</html>
