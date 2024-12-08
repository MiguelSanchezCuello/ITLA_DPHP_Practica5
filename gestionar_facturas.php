<?php

include "factura.php";

session_start();

$idCliente = null;
$cliente = null;
$facturasCliente = [];
// Buscar facturas del cliente
if(!isset($_GET["id"])){
    // Si no viene un id, Mostrar una lista de todas las facturas
    // Preparar la data para mostrar lista con todas.
} else {
    // Prepara la data para mostrar lista de un cliente especifico.
    $idCliente = $_GET["id"];
    foreach ($_SESSION["facturas"] as $factura) {
        if($factura->getCliente() == $idCliente){
            $facturasCliente[] = $factura;
        }
    }

    // Buscar el cliente.
    foreach ($_SESSION['clientes'] as $client) {
        if($client->getId() == $idCliente){
            $cliente = $client;
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestionar Facturas</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Gestionando Facturas</h1>

<?php if($facturasCliente != []) : ?>

<?= "<h2>Estas son las facturas de: <u>".$cliente->getNombre()."</u></h2>" ?>

<table border="1">
    <thead>
        <tr>
            <th>ID Factura</th>
            <th>Fecha</th>
            <th>Productos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($facturasCliente as $factura) : ?>
        <tr>
            <td><?= $factura->getId() ?></td>
            <td><?= $factura->getFecha() ?></td>
            <td><?= count($factura->getProductosFactura()) ?></td>
            <td>
                <form method="post" action="eliminar_factura.php" style="display:inline;">
                    <input type="hidden" name="id_factura" value="<?= $factura->getId() ?>">
                    <input type="hidden" name="id_cliente" value="<?= $cliente->getId() ?>">
                    <button type="submit">Eliminar</button>
                </form> |
                <a href="editar_factura.php?id_factura=<?= $factura->getId(); ?>&id_cliente=<?= $idCliente; ?>">Editar</a> |
                <a href="imprimir_factura.php?id_factura=<?= $factura->getId(); ?>&id_cliente=<?= $idCliente; ?>">Imprimir</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php else : ?>
    <?php if($idCliente != null) : ?>
        <h2>Este cliente no tiene facturas.</h2>
    <?php else : ?>
        <table border="1">
            <thead>
            <tr>
                <th>ID Cliente</th>
                <th>Nombre</th>
                <th>Pedidos</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['clientes'] as $cliente): ?>
                <tr>
                    <td><?= $cliente->getId(); ?></td>
                    <td><?= htmlspecialchars($cliente->getNombre()); ?></td>
                    <td>
                        <?php
                        $facturasCliente = [];
                        foreach($_SESSION['facturas'] as $fac){
                            if($fac->getCliente() == $cliente->getId()){
                                $facturasCliente[] = $fac;
                            }
                        }
                        echo count($facturasCliente);
                        ?>

                    </td>
                    <td>
                        <a href="gestionar_facturas.php?id=<?= $cliente->getId(); ?>">Ver Facturas</a>
                        <form method="post" style="display:inline;" action="eliminar_cliente.php">
                            <!--                    <input type="hidden" name="accion" value="eliminar_cliente">-->
                            <input type="hidden" name="id_cliente" value="<?= $cliente->getId(); ?>">
                            <button type="submit">Eliminar Cliente y Sus Pedidos</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php endif; ?>

<br>
<a href="crear_pedido.php">Agregar un nuevo Pedido</a>
<br>
</body>
</html>
