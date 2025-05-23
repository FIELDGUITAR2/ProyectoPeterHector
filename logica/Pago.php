<?php

class Pago
{
    private $id;
    private $fecha;
    private $cuenta;

    public function __construct($id = "", $fecha = "", $cuenta = null)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->cuenta = $cuenta;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getCuenta()
    {
        return $this->cuenta;
    }
}
