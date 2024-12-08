<?php
require "producto.php";

session_start();

if (!isset($_GET['id_producto'])) {
    die("Producto no especificado.");
}

$idProducto = $_GET['id_producto'];
$producto = null;

// Buscar producto
foreach ($_SESSION['productos'] as $index => $prod) {
    if ($prod->getId() == $idProducto) {
        $producto = $prod;
    }
}

if (!$producto) {
    die("producto no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto->setNombre($_POST['nombre']);
    $producto->setPrecio($_POST['precio']);

    header("Location: gestionar_productos.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="">
<head>
    <title>Editar Producto</title>
</head>
<body>
<h1>Editar Producto</h1>
<form method="post">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto->getNombre()); ?>"
           required><br><br>
    <label for="precio">Precio:</label><br>
    <input type="number" id="precio" name="precio" step="0.01" value="<?= htmlspecialchars($producto->getPrecio()); ?>"
           required><br><br>
    <button type="submit">Guardar Cambios</button>
</form>
<a href="gestionar_productos.php">Cancelar</a>
</body>
</html>
