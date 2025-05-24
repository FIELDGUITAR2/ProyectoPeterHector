<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/CuentaDAO.php");

class Cuenta
{
    private $id;
    private $fechaLimite;
    private $cantidad;
    private $saldoAnterior;
    private $idAdmin;
    private $idApartamento;
    private $idEstadoPago;
    private $CuentasLista;

    public function __construct($id = "", $fechaLimite = "", $cantidad = 0.0, $saldoAnterior = 0.0, $idAdmin = "", $idApartamento = "", $idEstadoPago = "")
    {
        $this->id = $id;
        $this->fechaLimite = $fechaLimite;
        $this->cantidad = $cantidad;
        $this->saldoAnterior = $saldoAnterior;
        $this->idAdmin = $idAdmin;
        $this->idApartamento = $idApartamento;
        $this->idEstadoPago = $idEstadoPago;
    }

    public function consultar()
    {
        $conexion = new Conexion();
        $cuentaDAO = new CuentaDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($cuentaDAO->consultar());
        $this->CuentasLista = array();
        if ($datos = $conexion->registro() != null) {
            $datosCuenta = new Cuenta($this->id, 
            $this->$datos[1], 
            $this->$datos[2], 
            $this->$datos[3], 
            $this->$datos[4], 
            $this->$datos[5], 
            $this->$datos[6]);
            array_push($CuentasLista,$datosCuenta);
        }
        $conexion->cerrar();
    }

    public function insertar()
    {
        $conexion = new Conexion();
        $cuentaDAO = new CuentaDAO($this->id, $this->fechaLimite, $this->cantidad, $this->saldoAnterior, $this->idAdmin, $this->idApartamento, $this->idEstadoPago);
        $conexion->abrir();
        $respuesta = $cuentaDAO->insertar();
        $conexion->ejecutar($respuesta);
        $resultado = $conexion->filas();
        $conexion->cerrar();

        return $resultado;
    }

    public function actualizarSaldoAnterior($idCuentaAnterior, $saldoAnterior)
    {
        $conexion = new Conexion();
        $cuentaDAO = new CuentaDAO();  // no necesitas pasarle datos si solo vas a usar el método de actualización
        $conexion->abrir();

        $conexion->ejecutar($cuentaDAO->actualizarSaldoAnterior($idCuentaAnterior, $saldoAnterior));
        $resultado = $conexion->filas();
        $conexion->cerrar();

        return $resultado;
    }



    public function consultarPorApartamento($idApartamento)
    {
        $conexion = new Conexion();
        $conexion->abrir();

        $cuentaDAO = new CuentaDAO("", "", 0, 0, "", $idApartamento, "");
        $conexion->ejecutar($cuentaDAO->consultarPorApartamento());
        $datos = $conexion->registro();

        if ($datos) {
            $cuenta = new Cuenta(
                $datos[0], 
                $datos[1],
                $datos[2],
                $datos[3],
                $datos[4],
                $datos[5],
                $datos[6]
            );
            $conexion->cerrar();
            return $cuenta;
        } else {
            $conexion->cerrar();
            return null;
        }
    }

    public function existeCuentaEnFecha($idApartamento, $fecha)
    {
        $anio = date('Y', strtotime($fecha));
        $mes = date('m', strtotime($fecha));

        $conexion = new Conexion();
        $conexion->abrir();

        $cuentaDAO = new CuentaDAO();
        $sql = $cuentaDAO->existeCuentaEnFecha($idApartamento, $anio, $mes);

        $conexion->ejecutar($sql);
        $registro = $conexion->registro();

        $conexion->cerrar();

        return $registro[0] > 0;
    }




    public function getId()
    {
        return $this->id;
    }
    public function getFechaLimite()
    {
        return $this->fechaLimite;
    }
    public function getCantidad()
    {
        return $this->cantidad;
    }
    public function getSaldoAnterior()
    {
        return $this->saldoAnterior;
    }
    public function getIdAdmin()
    {
        return $this->idAdmin;
    }
    public function getIdApartamento()
    {
        return $this->idApartamento;
    }
    public function getIdEstadoPago()
    {
        return $this->idEstadoPago;
    }

    /**
     * Get the value of CuentasLista
     */ 
    public function getCuentasLista()
    {
        return $this->CuentasLista;
    }

    /**
     * Set the value of CuentasLista
     *
     * @return  self
     */ 
    public function setCuentasLista($CuentasLista)
    {
        $this->CuentasLista = $CuentasLista;

        return $this;
    }
}
