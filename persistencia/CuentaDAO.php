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

    public function MostrarTodos()
    {
        $Consulta = "select c.idCuenta as ID_Cuenta, a.idApartamento as ID_Apartamento , 
        a.nombre as Nombre_Apartamento, p.idPropietario as ID_Propietario , 
        p.nombre as Nombre_Propietario, p.apellido as Apellido_Propietario, 
        p.telefono as Telefono 
        from Cuenta c 
        join Apartamento a on c.Apartamento_idApartamento = a.idApartamento 
        join Propietario p on a.Propietario_idPropietario = p.idPropietario 
        ORDER by idCuenta";  
        return $Consulta;      
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
