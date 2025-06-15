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
            }
            $conexion->cerrar();
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

        /**
         * Get the value of PropietariosLista
         */ 
        public function getPropietariosLista()
        {
                return $this->PropietariosLista;
        }
    }
