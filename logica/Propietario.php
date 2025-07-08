<?php
require_once("logica/Persona.php");
require_once("persistencia/Conexion.php");
require_once("persistencia/PropietarioDAO.php");

class Propietario extends Persona {
    private $fechaIngreso;
    private $PropietariosLista;

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $fechaIngreso = "", $correo = "") {
        parent::__construct($id, $nombre, $apellido, $telefono, $clave, $correo);
        $this->fechaIngreso = $fechaIngreso;
    }

    public function getFecha() {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function consultar() {
        $conexion = new Conexion();
        $propietarioDAO = new PropietarioDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($propietarioDAO->consultar());
        $datos = $conexion->getResultado()->fetch_assoc(); // acceso asociativo

        if ($datos) {
            $this->id = $datos["idPropietario"];
            $this->setNombre($datos["nombre"]);
            $this->setApellido($datos["apellido"]);
            $this->setTelefono($datos["telefono"]);
            $this->setClave($datos["clave"]);
            $this->setFechaIngreso($datos["fechaIngreso"]);
            $this->setCorreo($datos["correo"]);
        }

        $conexion->cerrar();
    }

    public function insertar() {
        $conexion = new Conexion();
        $conexion->abrir();
        $propietarioDAO = new PropietarioDAO(
            "",
            addslashes($this->getNombre()),
            addslashes($this->getApellido()),
            addslashes($this->getTelefono()),
            addslashes($this->getClave()),
            $this->getFecha(),
            addslashes($this->getCorreo())
        );
        $conexion->ejecutar($propietarioDAO->insertar());
        $idInsertado = $conexion->getConexion()->insert_id;
        $conexion->cerrar();
        return $idInsertado;
    }

    public function autenticar($correo, $clave) {
        $conexion = new Conexion();
        $conexion->abrir();
        $correo = addslashes($correo);
        $clave = addslashes($clave);

        $dao = new PropietarioDAO();
        $sql = $dao->autenticar($correo, $clave);
        $conexion->ejecutar($sql);

        if ($conexion->filas() == 1) {
            $fila = $conexion->getResultado()->fetch_assoc();
            $this->id = $fila["idPropietario"];
            $conexion->cerrar();
            return true;
        }

        $conexion->cerrar();
        return false;
    }

    public function getPropietariosLista() {
        return $this->PropietariosLista;
    }

    public function obtenerPropietariosConApartamentos() {
        return "SELECT p.idPropietario, p.nombre, p.apellido, p.telefono, p.correo, a.nombre AS apartamento
                FROM Propietario p
                LEFT JOIN Apartamento a ON p.idPropietario = a.Propietario_idPropietario
                ORDER BY p.idPropietario, a.nombre";
    }
}
?>
