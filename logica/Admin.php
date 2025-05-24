<?php
require_once("persistencia/Conexion.php");
require_once("logica/Persona.php");
require_once("persistencia/AdminDAO.php");

class Admin extends Persona
{

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "")
    {
        parent::__construct($id, $nombre, $apellido, $telefono, $clave);
    }



    public function consultar2()
    {
        $conexion = new Conexion();
        $adminDAO = new AdminDAO();
        $conexion->abrir();
        $conexion->ejecutar($adminDAO->consultar2());
        $admins = array();
        while (($datos = $conexion->registro()) != null) {
            $admin = new Admin($datos[0], $datos[1], $datos[2], "", "");

            array_push($admins, $admin);
        }
        $conexion->cerrar();
        return $admins;
    }


    public function consultar()
    {
        $conexion = new Conexion();
        $adminDAO = new AdminDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($adminDAO->consultar());
        $datos = $conexion->registro();
        if ($datos) {
            $this->nombre = $datos[1];
            $this->apellido = $datos[2];
            $this->telefono = $datos[3];
            $this->clave = $datos[4];
        }
        $conexion->cerrar();
        return $this;
    }


    public function autenticar()
    {
        $conexion = new Conexion();
        $adminDAO = new AdminDAO("", $this->nombre, "", "", $this->clave);
        $conexion->abrir();
        $conexion->ejecutar($adminDAO->autenticar());
        if ($conexion->filas() == 1) {
            $this->id = $conexion->registro()[0];
            $conexion->cerrar();
            return true;
        } else {
            $conexion->cerrar();
            return false;
        }
    }

    public function actualizar()
    {
        $conexion = new Conexion();
        $adminDAO = new AdminDAO($this->id, $this->nombre, $this->apellido, $this->telefono, $this->clave);
        $conexion->abrir();
        $resultado = $conexion->ejecutar($adminDAO->actualizar());
        $conexion->cerrar();
        return $resultado; 
    }
}
