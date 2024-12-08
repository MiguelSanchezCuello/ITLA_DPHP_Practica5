<?php

require_once "factura.php";
require_once "ProductoFactura.php";

session_start();

if (!isset($_GET['id_cliente'])) {
    die("ID de cliente no especificado.");
}

$idCliente = $_GET['id_cliente'];
$cliente = null;

// Busca el cliente
foreach ($_SESSION["clientes"] as $client) {
    if ($client->getId() == $idCliente) {
        $cliente = $client;
        break;
    }
}

if (!$cliente) {
    die("Cliente no encontrado.");
}


// Crear la factura.
$nuevaFactura = new Factura(uniqid(), $idCliente, date("F j, Y, g:i a"), $cliente->getProductos());

$facturasRepetidas = [];
foreach ($_SESSION['facturas'] as $factura) {
    if($factura->getProductosFactura() === $nuevaFactura->getProductosFactura()){
        array_push( $facturasRepetidas, $factura);
    }
}


$duplicarPedido = false;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['repetir_pedido'])) {
        if($_POST['repetir_pedido'] === "true"){
            $nuevaFactura = new Factura($_POST['id_factura'], $_POST['id_cliente'], date("F j, Y, g:i a"), $cliente->getProductos());
            $_SESSION["facturas"][] = $nuevaFactura;

            header("Location: crear_factura.php?id_cliente=$idCliente"); // Redirige para actualizar datos
            exit();
        } else {
            $duplicarPedido = false;
        }
    } else {
        $_SESSION["facturas"][] = $nuevaFactura;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturar</title>
    <?php include "estilos_tabla_factura.php" ?>
</head>
<body>
    <?php include "header.php"; ?>
    <br>
    <?php if($facturasRepetidas): ?>
        <?= "<h2>Este cliente ya ha realizado: <strong><u>" . count($facturasRepetidas) . "</u></strong> pedido/s con los mismos productos. <br>Presione el boton para repetir el pedido y guardar la nueva factura que se ha generado si eso es lo que desea.</h2>" ?>

        <form method="post">
            <input type="hidden" value="<?= $idCliente; ?>" name="id_cliente">
            <input type="hidden" name="id_factura" value="<?= uniqid(); ?>">
            <input type="hidden" name="repetir_pedido" value="true">
            <button type="submit">Repetir Pedido</button>
        </form>
    <?php endif; ?>

    <?php if(!$duplicarPedido) : ?>
        <h1>Factura Generada</h1>

        <h2>Detalle de la Factura</h2>
        <table border="1">
            <thead>
            <th colspan="3">ID de Factura: <?= $nuevaFactura->getId() ?></th>
            <th colspan="2"><?= $nuevaFactura->getFecha() ?> </th>
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
            <?php foreach ($cliente->getProductos() as $productoFactura): ?>
                <tr>
                    <td><?= $productoFactura->producto->getNombre() ?></td>
                    <td><?= $productoFactura->producto->getPrecio() ?></td>
                    <td><?= $productoFactura->getCantidad() ?></td>
                    <td><?= $productoFactura->getSubTotal() ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th><strong>Total: </strong> </th>
                <td colspan="3" style="text-align: right"><strong><?php echo number_format($nuevaFactura->calcularTotal(),2) ?></strong></td>
            </tr>
            </tbody>
        </table>
        <br>
    <?php else: ?>
        <?= "DUPLICAR PEDIDO ES TRUE" ?>
    <?php endif; ?>


    <form action="" method="post">
        <input type="hidden" value="<?= $idCliente; ?>" name="id_cliente">
        <button type="submit">Guardar Factura</button>
    </form>


    <br>
    <a href="gestionar_facturas.php?id=<?= $idCliente; ?>">Gestionar Facturas del Cliente</a>
</body>
</html>