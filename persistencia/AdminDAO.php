<?php

class AdminDAO
{
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $clave;

    public function __construct($id = 0, $nombre = "", $apellido = "",$telefono="", $clave = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this -> telefono = $telefono;
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
        return "SELECT idAdmin, nombre, apellido FROM Admin
        where idAdmin = '" . $this -> id . "'";
    }

    public function consultar2()
    {
        return "SELECT idAdmin, nombre, apellido FROM Admin;";
    }

}
