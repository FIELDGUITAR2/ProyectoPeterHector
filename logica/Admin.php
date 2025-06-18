<?php
require_once("persistencia/Conexion.php");
require_once("logica/Persona.php");
require_once("persistencia/AdminDAO.php");

class Admin extends Persona
{
    private $PropietariosLista;
    private $fechaIngreso;

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $correo = "")
    {
        parent::__construct($id, $nombre, $apellido, $telefono, $clave, $correo);
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
            $this->correo = $datos[5];
        }
        $conexion->cerrar();
        return $this;
    }

  public function consultarTodos() {
    $admins = array();
    $conexion = new Conexion();
    $conexion->abrir();
    
    $adminDAO = new AdminDAO();
    $admins = $adminDAO->consultarTodos($conexion->getConexion());
    
    $conexion->cerrar();
    return $admins;
}


    public function autenticar()
    {
        $conexion = new Conexion();
        $adminDAO = new AdminDAO("", "", "", "", $this->clave, $this->correo);
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
        $adminDAO = new AdminDAO($this->id, $this->nombre, $this->apellido, $this->telefono, $this->clave, $this->correo);
        $conexion->abrir();
        $conexion->ejecutar($adminDAO->actualizar());
        $resultado = $conexion -> getResultado();
        $conexion->cerrar();
        return $resultado; 
    }

    public function insertar()
    {
        $conexion = new Conexion();
        $adminDAO = new AdminDAO("", $this->nombre, $this->apellido, $this->telefono, $this->clave, $this->correo);
        $conexion->abrir();
        $conexion->ejecutar($adminDAO->insertar());
        $resultado = $conexion -> getResultado();
        $conexion->cerrar();
        return $resultado; 
    }

   public function eliminar()
{
    $conexion = new Conexion();
    $adminDAO = new AdminDAO($this->id);
    $conexion->abrir();
    
    try {
        // Ejecutar la consulta SQL de eliminación (soft delete)
        $sql = $adminDAO->eliminarAdmin($conexion->getConexion(), $this->id);
        $conexion->ejecutar($sql);
        
        // Verificar si la operación fue exitosa
        if ($conexion->getConexion()->affected_rows > 0) {
            $conexion->cerrar();
            return true;
        } else {
            $conexion->cerrar();
            return false;
        }
        
    } catch (Exception $e) {
        $conexion->cerrar();
        throw new Exception("Error al eliminar administrador: " . $e->getMessage());
    }
}

    public function restaurar() {
    $conexion = new Conexion();
    $conexion->abrir();
    $adminDAO = new AdminDAO();
    $resultado = $adminDAO->restaurar($conexion->getConexion(), $this->id);
    $conexion->cerrar();
    return $resultado;
}
}
