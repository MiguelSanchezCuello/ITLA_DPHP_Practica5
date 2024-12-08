<?php

require_once "factura.php";

session_start();

if(!isset($_GET["id_factura"])){
    die("ID de la factura no especificado");
}

$idCliente = null;
if(isset($_GET["id_cliente"])){
    $idCliente = $_GET["id_cliente"];
}

$idFactura = $_GET["id_factura"];
$facturaEditar = null;

foreach ($_SESSION["facturas"] as $factura) {
    if($factura->getId() == $idFactura){
        $facturaEditar = $factura;
        break;
    }
}

if(!$facturaEditar){
    die("Factura no encontrada");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editando Factura <?= $idFactura ?> </title>
</head>
<body>
<?php include "header.php"; ?>
<h1>Editando factura id: <?= $idFactura ?></h1>

<label for="cliente">Pertenece al Cliente: </label>
<?php foreach($_SESSION['clientes'] as $cliente){
    if($cliente->getId() == $_GET["id_cliente"]){
        echo "<u>".$cliente->getNombre()."</u>";
        break;
    }
}
?>

<h2>Productos</h2>
<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($facturaEditar->getProductosFactura() as $productoFactura): ?>
        <tr>
            <td><?= $productoFactura->producto->getId(); ?></td>
            <td><?= htmlspecialchars($productoFactura->producto->getNombre()); ?></td>
            <td><?= number_format($productoFactura->producto->getPrecio(), 2); ?></td>
            <td><?= number_format($productoFactura->getCantidad()) ?></td>
            <td>
                <form method="post" action="eliminar_producto_factura.php" style="display:inline;">
                    <input type="hidden" name="id_cliente" value="<?= $idCliente ?>">
                    <input type="hidden" name="id_producto" value="<?= $productoFactura->producto->getId(); ?>">
                    <input type="hidden" name="id_factura" value="<?= $idFactura; ?>">
                    <button type="submit">Eliminar</button>
                </form>
                <a href="editar_producto_factura.php?id_factura=<?= $idFactura ?>&id_producto=<?= $productoFactura->producto->getId(); ?>">Editar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="crear_producto_factura.php?id_factura=<?= $idFactura; ?>&id_cliente=<?= $facturaEditar->getCliente(); ?>">Agregar Producto a Factura</a>
<br><br>
<?php if($facturaEditar->getProductosFactura() > 0): ?>
    <a href="crear_factura.php?id_cliente=<?= $facturaEditar->getCliente() ?>">Generar Nueva Factura</a>
<?php endif; ?>
<br><br>
<a href="gestionar_clientes.php">Volver al inicio</a>

</body>
</html>
