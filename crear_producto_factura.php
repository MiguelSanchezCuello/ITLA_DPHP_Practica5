<?php

require_once "factura.php";
require_once "cliente.php";
//require_once "Inventario.php";
require_once "ProductoFactura.php";

session_start();

if (!isset($_GET['id_cliente'])) {
    die("ID de cliente no especificado.");
}

$idCliente = $_GET['id_cliente'];
$cliente = null;
$idFactura = null;

if(isset($_GET['id_factura'])){
    $idFactura = $_GET['id_factura'];
}

// Busca el cliente
foreach ($_SESSION['clientes'] as $c) {
    if ($c->getId() == $idCliente) {
        $cliente = $c;
        break;
    }
}

if (!$cliente) {
    die("Cliente no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = uniqid(); // Genera un ID único para el producto.
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $producto = new Producto($id, $nombre, $precio);
    $nuevoProductoACliente = new ProductoFactura($producto, $cantidad);


    if($idFactura != null){
        foreach ($_SESSION['facturas'] as $index => $fact) {
            if($fact->getId() == $idFactura){
                $facturaTemp = $_SESSION['facturas'][$index];
                $facturaTemp->agregarProducto($nuevoProductoACliente);
//                $_SESSION['facturas'][$index] = $facturaTemp;
                $cliente->agregarProducto($nuevoProductoACliente);
                break;
            }
        }
    }

    header("Location: editar_factura.php?id_factura=".$idFactura."&id_cliente=".$cliente->getId());
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Producto</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Agregar Producto a la Factura: <?= $idFactura ?></h1>
<h2>Del Cliente: <?= htmlspecialchars($cliente->getNombre()); ?></h2>
<form method="post">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>
    <label for="precio">Precio:</label><br>
    <input type="number" id="precio" name="precio" step="0.01" required><br><br>
    <label for="cantidad">Cantidad</label>
    <input type="number" id="cantidad" name="cantidad" min="0" max="999" maxlength="3" required><br><br>
    <button type="submit">Guardar Producto</button>
</form>
<br>
<a href="editar_factura.php?id_factura=<?= $idFactura; ?>&id_cliente=<?= $idCliente; ?>">Cancelar</a>
</body>
</html>
