<?php

include "factura.php";

session_start();

$clientes = [];
$productos = [];
$productosPedido = [];
if(isset($_SESSION["clientes"])){
    $clientes = $_SESSION["clientes"];
}

if(isset($_SESSION["productos"])){
    $productos = $_SESSION["productos"];
}

if(isset($_SESSION["productosPedido"])){
    $productosPedido = $_SESSION["productosPedido"];
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $idProducto = null;
    if (isset($_POST["id_producto"])) {
        $idProducto = $_POST['id_producto'];
    }

    $idCliente = null;

    if (isset($_POST['cliente'])) {
        $idCliente = $_POST['cliente'];
    }

    if ($_POST['accion'] == "eliminar") {
        foreach ($_SESSION["productosPedido"] as $index => $producto) {
            if ($producto->getId() == $idProducto) {
                array_splice($_SESSION["productosPedido"], $index, 1);
            }
        }
        header('Location: crear_pedido.php');
    } else if ($_POST['accion'] == "agregar") {
        $nuevoProductoAgregar = null;
        $precioVenta = $_POST['precio'];
        $cantidadProducto = $_POST['cantidad'];
        $productoExiste = false;
        foreach ($productos as $producto) {
            if ($producto->getId() == $idProducto) {
                $producto->setPrecio($precioVenta);
                $nuevoProductoAgregar = new ProductoFactura($producto, $cantidadProducto);
                $productoExiste = true;
                break;
            }
        }

        $_SESSION["productosPedido"][] = $nuevoProductoAgregar;
        header('Location: crear_pedido.php');
        exit();
    } else if ($_POST['accion'] == "completar") {
        echo $idCliente;
        foreach ($_SESSION['clientes'] as $index => $cliente) {
            if ($cliente->getId() == $idCliente) {
                $_SESSION['clientes'][$index]->setProductos($productosPedido);
                unset($_SESSION['productosPedido']);
                break;
            }
        }

        header("Location: crear_factura.php?id_cliente=$idCliente");

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
    <title>Crear Pedido</title>
</head>
<body>
<?php include "header.php" ?>

    <h1>Crear Pedido: </h1>
    <ol> <h3>Pasos para crear un pedido:</h3>
        <li><strong>Agregar productos: </strong>Para agregar un producto llene los campos y presione "Agregar Producto".</li>
        <li><strong>Confirmar Detalles: </strong>Puede ver los productos agregados y elinar los que desee.</li>
        <li><strong>Seleccionar Cliente: </strong>Debe seleccionar el cliente al cual pertenece el pedido.</li>
        <li><strong>Completar: </strong>Presione el boton "Completar Pedido".</li>
    </ol>

    <h2>Detalles del Pedido</h2>
    <table border="1">
        <thead>
        <tr>
            <th>ID Producto:</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($productosPedido) : ?>
            <?php foreach ($productosPedido as $producto): ?>
                <tr>
                    <td><?= $producto->getId() ?></td>
                    <td><?= $producto->getProducto()->getNombre() ?></td>
                    <td><?= $producto->getProducto()->getPrecio() ?></td>
                    <td><?= $producto->getCantidad() ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id_producto" value="<?= $producto->getId(); ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <br><br>
    <form method="POST">
        <input type="hidden" name="accion" value="completar">
        <label for="cliente"><h2 style="display: inline;">Cliente: </h2></label>
        <?php if (!$clientes) : ?>
            <h2>No hay clientes registrados, proceda a agregar cliente.</h2>
            <p><a href="crear_cliente.php">Crear Cliente</a></p><br>
        <?php else : ?>
            <select name="cliente">
                <?php foreach ($clientes as $client): ?>
                    <option value="<?= $client->getId() ?>"><?= $client->getNombre() ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
        <button type="submit">Completar Pedido</button>
    </form>

    <br>
    <form method="POST">


        <?php if (!$productos) : ?>
            <h2>No hay productos registrados, proceda a agregar productos.</h2>
            <p><a href="crear_producto.php">Crear Producto</a></p><br>
        <?php else : ?>
            <div style="padding:10px; border: 1px solid black; width: 40%">
                <h3>Para adicionar un nuevo producto ingrese los datos</h3>
                <label for="id_producto">Producto: </label>
                <select name="id_producto">
                    <?php foreach ($productos as $prod): ?>
                        <option value="<?= $prod->getId() ?>"><?= $prod->getNombre() ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <input type="hidden" name="accion" value="agregar">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01"><br><br>
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" min="0" max="999" maxlength="3"><br><br>
                <button type="submit">Agregar Producto</button>
            </div>
        <?php endif; ?>

        <br><br>
        <a href="gestionar_facturas.php">Volver al inicio</a>
    </form>
</body>
</html>