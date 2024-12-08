<?php

class Producto
{
    private $id;
    private $nombre;
    private $precio;

    public function __construct($id, $nombre, $precio)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
    }

    public function __toString(): string
    {
        return "ID: " . $this->id . "<br>Nombre: " . $this->nombre . "<br>Precio: " . $this->precio;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getPrecio(): string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio)
    {
        $this->precio = $precio;
    }
}

