<?php

class AdminDAO
{
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $clave;

    public function __construct($id = 0, $nombre = "", $apellido = "", $telefono = "", $clave = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->clave = $clave;
    }

    public function autenticar()
    {
        return "SELECT idAdmin 
        FROM Admin 
        WHERE nombre = '" . $this->nombre . "' AND clave = '" . $this->clave . "'";
    }

    public function consultar()
    {
        return "SELECT idAdmin, nombre, apellido, telefono, clave FROM Admin
            WHERE idAdmin = '" . $this->id . "'";
    }


    public function consultar2()
    {
        return "SELECT idAdmin, nombre, apellido FROM Admin;";
    }

    
    public function actualizar() {
        return "UPDATE admin SET nombre = '{$this->nombre}', apellido = '{$this->apellido}', telefono = '{$this->telefono}', clave = '{$this->clave}' WHERE idAdmin = {$this->id}";
    }
}
