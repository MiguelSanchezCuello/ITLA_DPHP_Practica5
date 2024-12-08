<?php

require_once "cliente.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = $_POST['id_cliente'];

    foreach ($_SESSION['clientes'] as $index => $cliente) {
        if ($cliente->getId() == $idCliente) {
            unset($_SESSION['clientes'][$index]);
            $_SESSION['clientes'] = array_values($_SESSION['clientes']);
            break;
        }
    }

    header("Location: gestionar_clientes.php");
    exit();
}
?>