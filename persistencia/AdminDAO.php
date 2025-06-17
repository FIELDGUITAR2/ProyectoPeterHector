<?php

class AdminDAO
{
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $clave;
    private $correo;

    public function __construct($id = 0, $nombre = "", $apellido = "", $telefono = "", $clave = "", $correo = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->clave = $clave;
        $this->correo = $correo;
    }

    public function autenticar()
    {
        return "SELECT idAdmin 
        FROM Admin 
        WHERE Correo = '" . $this->correo . "' AND clave = '" . $this->clave . "'";
    }

    public function consultar()
    {
        return "SELECT idAdmin, nombre, apellido, telefono, clave, Correo FROM Admin
            WHERE idAdmin = '" . $this->id . "'";
    }


    public function consultar2()
    {
        return "SELECT idAdmin, nombre, apellido FROM Admin;";
    }

    
    public function actualizar() {
        return "UPDATE admin SET nombre = '{$this->nombre}', apellido = '{$this->apellido}', telefono = '{$this->telefono}', clave = '{$this->clave}', Correo = '{$this->correo}' WHERE idAdmin = {$this->id}";
    }

    public function insertar() {
        return "INSERT INTO Admin (nombre, apellido, telefono, clave, Correo) 
                VALUES ('{$this->nombre}', '{$this->apellido}', '{$this->telefono}', '{$this->clave}', '{$this->correo}')";
    }
    public function eliminar() {
        return "DELETE FROM Admin WHERE idAdmin = {$this->id}";
    }
}
