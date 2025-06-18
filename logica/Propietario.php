    <?php
    require_once("logica/Persona.php");
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
                $this->nombre = $datos[1];
                $this->apellido = $datos[2];
                $this->telefono = $datos[3];
                $this->clave = $datos[4];
                $this->fechaIngreso = $datos[5];
                $this->correo = $datos[6];
            }
            $conexion->cerrar();
        }

        public function consultarTodos() {
        $propietarios = array();
        $conexion = new Conexion();
        $conexion->abrir();
    
        $propietarioDAO = new PropietarioDAO();
        $propietarios = $propietarioDAO->consultarTodos($conexion->getConexion());
    
        $conexion->cerrar();
        return $propietarios;
}

           public function eliminar()
        {
            $conexion = new Conexion();
            $propietarioDAO = new PropietarioDAO($this->id);
            $conexion->abrir();
    
        try {
        
            $sql = $propietarioDAO->eliminarPropietario($conexion->getConexion(), $this->id);
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
        throw new Exception("Error al eliminar propietario: " . $e->getMessage());
        }      
}


        public function restaurar() {
        $conexion = new Conexion();
        $conexion->abrir();
    
        $propietarioDAO = new PropietarioDAO();
        $resultado = $propietarioDAO->restaurar($conexion->getConexion(), $this->id);
    
        $conexion->cerrar();
        return $resultado;
}

        public function autenticar()
        {
            $conexion = new Conexion();
            $propietarioDAO = new PropietarioDAO("", "", "", "", $this->clave, "",
            $this->correo);

            $conexion->abrir();
            $conexion->ejecutar($propietarioDAO->autenticar());
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
            $propietarioDAO = new PropietarioDAO($this->id, $this->nombre, $this->apellido, $this->telefono, $this->clave, $this->fechaIngreso);
            $conexion->abrir();
            $conexion->ejecutar($propietarioDAO->actualizar());
            $resultado = $conexion->getResultado();
            $conexion->cerrar();
            return $resultado;
        }

        public function insertar()
        {
            $conexion = new Conexion();
            $propietarioDAO = new PropietarioDAO("", $this->nombre, $this->apellido, $this->telefono, $this->clave, $this->fechaIngreso, $this->correo);
            $conexion->abrir();
            $conexion->ejecutar($propietarioDAO->insertar());
            $resultado = $conexion->getResultado();
            $conexion->cerrar();
            return $resultado;
        }
        

        
        public function getPropietariosLista()
        {
            return $this->PropietariosLista;
        }

        public function obtenerPropietariosConApartamentos() {
            return "SELECT p.idPropietario, p.nombre, p.apellido, p.telefono, p.correo, a.nombre AS apartamento
                        FROM Propietario p
                        LEFT JOIN Apartamento a ON p.idPropietario = a.Propietario_idPropietario
                        ORDER BY p.idPropietario, a.nombre";
            }
    }
