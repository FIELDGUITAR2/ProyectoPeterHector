    <?php
    require_once("logica/Persona.php");
    require_once("persistencia/PropietarioDAO.php");


    class Propietario extends Persona
    {
        private $fechaIngreso;

        public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $fechaIngreso = "")
        {
            parent::__construct($id, $nombre, $apellido, $telefono, $clave);
            $this->fechaIngreso = $fechaIngreso;
        }

        public function getFecha()
        {
            return $this->fechaIngreso;
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
            $PropietarioDao = new PropietarioDAO($this->id);
            $conexion->abrir();
            $conexion->ejecutar($PropietarioDao->consultar());
            $datos = $conexion->registro();
            $this->nombre = $datos[1];
            $this->apellido = $datos[2];
            $this->fechaIngreso = $datos[3]; 
            $conexion->cerrar();
        }


        public function autenticar()
        {
            $conexion = new Conexion();
            $propietarioDAO = new PropietarioDAO("", $this->nombre, "", $this->clave);
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
    }
