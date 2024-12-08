<?php

require_once "cliente.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = uniqid(); // Genera un ID único para el cliente.
    $nombre = $_POST['nombre'];

    $nuevoCliente = new Cliente($id, $nombre);
    $_SESSION['clientes'][] = $nuevoCliente;

    header("Location: gestionar_clientes.php"); // Redirige al sistema principal.
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Cliente</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Crear Nuevo Cliente</h1>
<form method="post">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>
    <button type="submit">Guardar Cliente</button>
</form>
<a href="gestionar_clientes.php">Cancelar</a>
</body>
</html>
