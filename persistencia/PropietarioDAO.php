<?php
class PropietarioDAO {
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $clave;
    private $fechaIngreso;

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $fechaIngreso = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->clave = $clave;
        $this->fechaIngreso = $fechaIngreso;
    }

    public function autenticar() {
        return "SELECT idPropietario 
                FROM Propietario 
                WHERE nombre = '" . $this->nombre . "' AND clave = '" . $this->clave . "'";
    }

    public function consultar2() {
        return "SELECT idPropietario, nombre, apellido, fechaIngreso FROM Propietario";
    }

    public function consultar() {
        return "SELECT idPropietario, nombre, apellido, telefono, clave, fechaIngreso 
                FROM Propietario 
                WHERE idPropietario = '" . $this->id . "'";
    }

    public function actualizar() {
        return "UPDATE Propietario 
                SET nombre = '{$this->nombre}', apellido = '{$this->apellido}', 
                    telefono = '{$this->telefono}', clave = '{$this->clave}' 
                WHERE idPropietario = {$this->id}";
    }


}
