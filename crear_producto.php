<?php

require "producto.php";

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productos = [];
    $existe = false;
    $id = uniqid(); // Genera un ID único para el producto.
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    if(isset($_SESSION['productos'])){
        $productos = $_SESSION['productos'];

        // Busca el producto.
        foreach ($_SESSION['productos'] as $index => $prod) {
            if (strtolower($prod->getNombre()) == strtolower($nombre)) {
                $_SESSION['productos'][$index]->setPrecio($precio);
                $existe = true;
                break;
            }
        }
    }

    if($existe == false){
        $producto = new Producto($id, $nombre, $precio);
        $_SESSION['productos'][] = $producto;
    }

// Esta linea de abajo puede servir de referencia para Inventario(prod, cant)
//    $nuevoProductoACliente = new ProductoFactura($producto, $cantidad);
//    $cliente->agregarProducto($nuevoProductoACliente);

    header("Location: gestionar_productos.php");
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
<h1>Agregar Producto</h1>
<form method="post">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>
    <label for="precio">Precio:</label><br>
    <input type="number" id="precio" name="precio" step="0.01" required><br><br>
    <button type="submit">Guardar Producto</button>
</form>
<a href="gestionar_productos.php">Cancelar</a>
</body>
</html>
