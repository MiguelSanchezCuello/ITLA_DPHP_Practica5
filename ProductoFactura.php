<?php
include "producto.php";

class ProductoFactura
{
    public Producto $producto;
    public $cantidad;

    public function __construct($producto, $cantidad){
        $this->producto = $producto;
        $this->cantidad = $cantidad;
    }

    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }

    public function getCantidad(){
        return $this->cantidad;
    }

    public function getProducto(){
        return $this->producto;
    }

    public function setProducto($producto){
        $this->producto = $producto;
    }

    public function getSubTotal(){
        return $this->producto->getPrecio() * $this->cantidad;
    }

    public function getId(){
        return $this->producto->getId();
    }
}