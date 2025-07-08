<?php
require_once("logica/Persona.php");
require_once("persistencia/Conexion.php");
require_once("persistencia/PropietarioDAO.php");

class Propietario extends Persona
{
    private $fechaIngreso;
    private $PropietariosLista;

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $fechaIngreso = "", $correo = "")
    {
        parent::__construct($id, $nombre, $apellido, $telefono, $clave, $correo);
        $this->fechaIngreso = $fechaIngreso;
    }

    public function getFecha()
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function consultar2()
    {
        $conexion = new Conexion();
        $propietarioDAO = new PropietarioDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($propietarioDAO->consultar2());
        $propietarios = array();
        while (($datos = $conexion->registro()) != null) {
            $propietario = new Propietario($datos[0], $datos[1], $datos[2], "", "", $datos[3]);
            array_push($propietarios, $propietario);
        }
        $conexion->cerrar();
        return $propietarios;
    }

    public function consultar()
    {
        $conexion = new Conexion();
        $propietarioDAO = new PropietarioDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($propietarioDAO->consultar());
        $datos = $conexion->registro();
        if ($datos) {
            $this->id = $datos[0];
            $this->setNombre($datos[1]);
            $this->setApellido($datos[2]);
            $this->setTelefono($datos[3]);
            $this->setClave($datos[4]);
            $this->setFechaIngreso($datos[5]);
            $this->setCorreo($datos[6]);
        }
        $conexion->cerrar();
    }

    public function actualizar()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        $propietarioDAO = new PropietarioDAO(
            addslashes($this->id),
            addslashes($this->getNombre()),
            addslashes($this->getApellido()),
            addslashes($this->getTelefono()),
            addslashes($this->getClave()),
            $this->getFecha(),
            addslashes($this->getCorreo())
        );
        $conexion->ejecutar($propietarioDAO->actualizar());
        $resultado = $conexion->getConexion()->affected_rows > 0;
        $conexion->cerrar();
        return $resultado;
    }

    public function insertar()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        $propietarioDAO = new PropietarioDAO(
            "",
            addslashes($this->getNombre()),
            addslashes($this->getApellido()),
            addslashes($this->getTelefono()),
            addslashes($this->getClave()), // ✅ TEXTO PLANO
            $this->getFecha(),
            addslashes($this->getCorreo())
        );
        $conexion->ejecutar($propietarioDAO->insertar());
        $idInsertado = $conexion->getConexion()->insert_id;
        $conexion->cerrar();
        return $idInsertado;
    }

    public function consultarTodos()
    {
        $propietarios = array();
        $conexion = new Conexion();
        $conexion->abrir();

        $propietarioDAO = new PropietarioDAO();
        $resultadosDAO = $propietarioDAO->consultarTodos($conexion->getConexion());

        foreach ($resultadosDAO as $registro) {
            $propietarios[] = $registro;
        }
        $conexion->cerrar();
        return $propietarios;
    }

    public function eliminar()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        $idSanitizado = addslashes($this->id);
        $propietarioDAO = new PropietarioDAO();

        try {
            $sql = $propietarioDAO->eliminarPropietario($conexion, $idSanitizado);
            if ($sql === null) {
                throw new Exception("ID de propietario inválido para eliminar.");
            }
            $conexion->ejecutar($sql);

            if ($conexion->getConexion()->affected_rows > 0) {
                $conexion->cerrar();
                return true;
            } else {
                $conexion->cerrar();
                return false;
            }
        } catch (Exception $e) {
            $conexion->cerrar();
            throw new Exception("Error al eliminar propietario: " . $e->getMessage());
        }
    }

    public function restaurar()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        $idSanitizado = addslashes($this->id);
        $propietarioDAO = new PropietarioDAO();

        try {
            $resultadoRestaurar = $propietarioDAO->restaurar($conexion->getConexion(), $idSanitizado);
            $conexion->cerrar();
            return $resultadoRestaurar;
        } catch (Exception $e) {
            $conexion->cerrar();
            throw new Exception("Error al restaurar propietario: " . $e->getMessage());
        }
    }

    public function autenticar($correo, $clave)
    {
        $conexion = new Conexion();
        $conexion->abrir();

        $correoSanitizado = addslashes($correo);
        $claveSanitizada = addslashes($clave); // ✅ TEXTO PLANO

        $propietarioDAO = new PropietarioDAO();
        $sql = $propietarioDAO->autenticar($correoSanitizado, $claveSanitizada);

        $conexion->ejecutar($sql);
        if ($conexion->filas() == 1) {
            $this->id = $conexion->registro()[0];
            $conexion->cerrar();
            return true;
        } else {
            $conexion->cerrar();
            return false;
        }
    }

    public function getPropietariosLista()
    {
        return $this->PropietariosLista;
    }

    public function obtenerPropietariosConApartamentos()
    {
        return "SELECT p.idPropietario, p.nombre, p.apellido, p.telefono, p.correo, a.nombre AS apartamento
                FROM Propietario p
                LEFT JOIN Apartamento a ON p.idPropietario = a.Propietario_idPropietario
                ORDER BY p.idPropietario, a.nombre";
    }
}
?>
