<?php
class CuentaDAO
{
    private $id;
    private $fechaLimite;
    private $cantidad;
    private $saldoAnterior;
    private $idAdmin;
    private $idApartamento;
    private $idEstadoPago;

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
        return "SELECT * FROM Cuenta WHERE idCuenta = '" . $this->id . "'";
    }

    public function insertar()
    {
        return "insert into Cuenta (fechaLimite, cantidad, saldoAnterior, Admin_idAdmin, Apartamento_idApartamento, EstadoPago_idEstadoPago)
            values ('$this->fechaLimite',$this->cantidad,$this->saldoAnterior,$this->idAdmin,$this->idApartamento,$this->idEstadoPago)";
    }


    public function consultarPorApartamento()
    {
        return "SELECT idCuenta, fechaLimite, cantidad, saldoAnterior, Admin_idAdmin, Apartamento_idApartamento, EstadoPago_idEstadoPago 
            FROM Cuenta 
            WHERE Apartamento_idApartamento = '{$this->idApartamento}' 
            ORDER BY fechaLimite DESC LIMIT 1";
    }

    public function existeCuentaEnFecha($idApartamento, $anio, $mes)
    {
        $idApartamento = intval($idApartamento);
        $anio = intval($anio);
        $mes = intval($mes);

        return "SELECT COUNT(*) AS cuentaExiste FROM Cuenta 
            WHERE Apartamento_idApartamento = $idApartamento
            AND YEAR(fechaLimite) = $anio
            AND MONTH(fechaLimite) = $mes";
    }


    public function actualizarSaldoAnterior($idCuentaAnterior, $saldoAnterior)
    {
        return "UPDATE Cuenta SET saldoAnterior = '$saldoAnterior' WHERE idCuenta = '$idCuentaAnterior';";
    }


}
