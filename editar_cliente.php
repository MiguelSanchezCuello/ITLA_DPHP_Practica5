<?php

require_once "cliente.php";

session_start();
if (!isset($_GET['id'])) {
    die("ID del cliente no especificado.");
}

$idCliente = $_GET['id'];
$cliente = null;

// Buscar cliente
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
    $cliente->setNombre($_POST['nombre']);
    header("Location: gestionar_clientes.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Editar Cliente</h1>
<form method="post">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($cliente->getNombre()); ?>"
           required><br><br>
    <button type="submit">Guardar Cambios</button>
</form>
<a href="gestionar_clientes.php">Cancelar</a>
</body>
</html>
