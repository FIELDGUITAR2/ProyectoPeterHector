<?php
require_once("persistencia/Conexion.php");
require_once("logica/Persona.php");
require_once("persistencia/AdminDAO.php");

class Admin extends Persona {

    public function __construct($id = "", $nombre = "", $apellido = "",  $clave = ""){
        parent::__construct($id, $nombre, $apellido, $clave);
    }
    
    
    public function consultar(){
        $conexion = new Conexion();
        $adminDAO = new AdminDAO();
        $conexion -> abrir();
        $conexion -> ejecutar($adminDAO -> consultar());
        $admins = array();
        while(($datos = $conexion -> registro()) != null){        
            $admin = new Admin($datos[0], $datos[1], $datos[2]);
            array_push($admins, $admin);
        }
        $conexion -> cerrar();
        return $admins;

    }

    public function autenticar()
    {
        $conexion = new Conexion();
        $adminDAO = new AdminDAO("", $this->nombre,"", $this->clave);
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

}
