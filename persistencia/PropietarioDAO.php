<?php

class PropietarioDAO
{
    private $id;
    private $nombre;
    private $apellido;
    private $clave;
    private $fechaNacimiento;

    public function __construct($id = 0, $nombre = "", $apellido = "",  $clave = "", $fechaNacimiento = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->clave = $clave;
        $this->fechaNacimiento = $fechaNacimiento;
    }


    public function autenticar()
    {
        return "SELECT idPropietario 
            FROM Propietario 
            WHERE nombre = '" . $this->nombre . "' AND clave = '" . $this->clave . "'";
    }

    public function consultar()
    {
        return "SELECT idPropietario, nombre, apellido, fechaIngreso FROM Propietario";
    }
}
