<?php

class Cliente
{
    private $id;
    private $nombre;
    private $productos;

    public function __construct($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->productos = [];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function agregarProducto(ProductoFactura $producto)
    {
        $this->productos[] = $producto;
    }

    public function eliminarProducto(string $idProducto): void
    {
        foreach ($this->productos as $index => $producto) {
            if ($producto->getId() === $idProducto) {
                unset($this->productos[$index]);
                break;
            }
        }
        $this->productos = array_values($this->productos); // Reindexa el array
    }

    public function getProductos(): array
    {
        return $this->productos;
    }

    public function setProductos(array $productos){
        $this->productos = $productos;
    }
}

?>
