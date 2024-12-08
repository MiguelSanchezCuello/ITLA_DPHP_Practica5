<?php

require_once "factura.php";

session_start();

// Obtener el id_factura de la session.
if(!isset($_GET['id_factura']) || !isset($_GET['id_producto'])) {
    die("Datos de factura o producto no especificado");
}
// Buscar ese ID en el arreglo de facturas de la sesion para identificarlo.

$idFactura = $_GET['id_factura'];
$idProducto = $_GET['id_producto'];
$factura = null;
$producto = null;

foreach ($_SESSION['facturas'] as $facturaSession) {
    if ($facturaSession->getId() === $idFactura) {
        $factura = $facturaSession;
        foreach ($factura->getProductosFactura() as $productoSession) {
            if ($productoSession->getId() === $idProducto) {
                $producto = $productoSession;
                break;
            }
        }
        break;
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto->producto->setNombre($_POST['nombre']);
    $producto->producto->setPrecio($_POST['precio']);
    $producto->setCantidad($_POST['cantidad']);
    $idFacturaForHeader = $factura->getId();
    $idClienteForHeader = $factura->getCliente();
//    header("Location: ver_cliente.php?id=$idCliente");
    header("Location: editar_factura.php?id_factura=$idFacturaForHeader&id_cliente=$idClienteForHeader&id_producto=$idProducto");
/*    <a href="editar_factura.php?id_factura=<?= $factura->getId(); ?>&id_cliente=<?= $idCliente; ?>">Editar</a>*/
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Producto EN FACTURA</title>
</head>
<body>
<?php include "header.php"; ?>
<h1>Editar Producto EN FACTURA: <span style="color:dodgerblue"><?= $factura->getId() ?></span></h1>
<form method="post">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto->producto->getNombre()); ?>"
           required><br><br>
    <label for="precio">Precio:</label><br>
    <input type="number" id="precio" name="precio" step="0.01" value="<?= htmlspecialchars($producto->producto->getPrecio()); ?>"
           required><br><br>
    <label for="cantidad">Cantidad</label>
    <input type="number" id="cantidad" name="cantidad" min="0" max="999" maxlength="3" required value="<?= htmlspecialchars($producto->getCantidad()) ?>"><br><br>
    <button type="submit">Guardar Cambios</button>
</form>
<br>
<a href="gestionar_facturas.php?id=<?= $factura->getCliente(); ?>">Cancelar</a>
</body>
</html>