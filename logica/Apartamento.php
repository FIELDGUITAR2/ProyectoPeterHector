<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/ApartamentoDAO.php");


class Apartamento
{
    private $id;
    private $nombre;
    private $area;
    private $propietario;
    private $CuentasLista;

    public function __construct($id = "", $nombre = "", $area = null, $propietario = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->area = $area;
        $this->propietario = $propietario;
    }

    public function consultarTodos(){
        $conexion = new Conexion();
        $apartamentoDAO = new ApartamentoDAO();
        $conexion->abrir();
        $conexion->ejecutar($apartamentoDAO->consultarTodos());
        $apartamentos = array();
        while (($datos = $conexion->registro()) != null) {
            $propietario = null;
            if ($datos[2] !== null) {
                $propietario = new Propietario($datos[2], $datos[3], $datos[4], $datos[5]);
            }

            $area = new Area($datos[6], $datos[7], $datos[8]);
            $apartamento = new Apartamento($datos[0], $datos[1], $area, $propietario);

            array_push($apartamentos, $apartamento);
        }
        $conexion->cerrar();
        return $apartamentos;
    }

    public function ConsultarApartamentosCuentas($idPropietario){
        $conexion = new Conexion();
        $apartamentoDAO = new ApartamentoDAO();
        $conexion->abrir();
        $conexion->ejecutar($apartamentoDAO->ApartamentosPropietarioLista($idPropietario));
        $apartamentos = array();
        while (($datos = $conexion->registro()) != null) {
            $Area = new Area($datos[2],$datos[3]);
            $Apart = new Apartamento($datos[0], $datos[1], $Area);
            $Est = new Estado($datos[6], $datos[7]);
            $Cue = new Cuenta($datos[4],0, $datos[5],
            0, 0, $Apart, 
            $Est);

            // Cambiar esta línea:
            array_push($this->CuentasLista, $Cue);
        }

        $conexion->cerrar();
    }

    public function consultarPorNombre($nombre){
        $conexion = new Conexion();
        $apartamentoDAO = new ApartamentoDAO();
        $conexion->abrir();
        $conexion->ejecutar($apartamentoDAO->consultarPorNombre($nombre));
        $datos = $conexion->registro();

        if ($datos != null) {
            $propietario = null;
            if ($datos[2] !== null) {
                $propietario = new Propietario($datos[2], $datos[3], $datos[4], $datos[5]);
            }
            $area = new Area($datos[6], $datos[7], $datos[8]); 
            $apartamento = new Apartamento($datos[0], $datos[1], $area, $propietario);
            $conexion->cerrar();
            return $apartamento;
        }

        $conexion->cerrar();
        return null;
    }

    public function tienePropietario($idApartamento){
    $conexion = new Conexion();
    $apartamentoDAO = new ApartamentoDAO();
    $conexion->abrir();

    $conexion->ejecutar($apartamentoDAO->tienePropietario($idApartamento));
    $tiene = $conexion->filas() > 0;

    $conexion->cerrar();

    return $tiene;
}




    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function getPropietario()
    {
        return $this->propietario;
    }

    public function ListaApartamentos($idPropietario)
    {
        $conexion = new Conexion();
        $Apartamento  = new Apartamento();
        $Apartamentodao = new ApartamentoDAO();
        $consulta = $Apartamentodao ->  ApartamentoPropietario($idPropietario);
        $conexion -> abrir();
        $conexion -> ejecutar($consulta);
        $listaApartamentos = $conexion -> getResultado();
        
        
    }
}
