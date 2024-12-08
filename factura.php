<?php
include "ProductoFactura.php";
include "cliente.php";

class Factura
{
    private $id;
    private $cliente;
    private $fecha;
    private $productosFactura = [];

    public function __construct($id, $cliente, $fecha, $productosFactura){
        $this->id = $id;
        $this->cliente = $cliente;
        $this->fecha = $fecha;
        $this->productosFactura = $productosFactura;
    }
    public function agregarProducto(ProductoFactura $nuevoProducto){
        $existe = false;
        foreach ($this->productosFactura as $productoFactura){
            if($productoFactura->getProducto() === $nuevoProducto->getProducto()){
                $existe = true;
                $productoFactura->setCantidad($nuevoProducto->getCantidad());
            }
        }
        if(!$existe){
            $this->productosFactura[] = $nuevoProducto;
        }
    }

    public function eliminarProducto(ProductoFactura $productoEliminar){
        foreach ($this->productosFactura as $index => $producto){
            if($producto->getProducto() === $productoEliminar->getProducto()){
                unset($this->productosFactura[$index]);
            }
        }
    }

    public function eliminarProductoPorId($idProducto){
        foreach ($this->productosFactura as $index => $producto){
            if($producto->getId() === $idProducto){
                array_splice($this->productosFactura, $index, 1);
            }
        }
    }

    public function calcularTotal(){
        $total = 0;
        foreach ($this->productosFactura as $productoFactura){
            $total += $productoFactura->getSubtotal();
        }

        // This total had no return, added to it.
        return $total;
    }

    public function getProductosFactura(){
        return $this->productosFactura;
    }

    public function getProductoPorId($idProducto){
        foreach ($this->productosFactura as $productoFactura){
            if($productoFactura->getId() === $idProducto){
                return $productoFactura;
            }
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getCliente(){
        return $this->cliente;
    }
}