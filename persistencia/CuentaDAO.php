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

    public function MostrarTodos($idPropietario)
    {
        if($idPropietario != null || $idPropietario != ""){
            $Consulta = "select c.idCuenta as ID_Cuenta, a.idApartamento as ID_Apartamento , 
            a.nombre as Nombre_Apartamento, p.idPropietario as ID_Propietario , 
            p.nombre as Nombre_Propietario, p.apellido as Apellido_Propietario, 
            p.telefono as Telefono, e.idEstadoPago as ID_Estado , e.valor as Estado 
            from Cuenta c 
            join Apartamento a on c.Apartamento_idApartamento = a.idApartamento 
            join Propietario p on a.Propietario_idPropietario = p.idPropietario 
            join EstadoPago e on c.EstadoPago_idEstadoPago = e.idEstadoPago 
            where p.idPropietario = $idPropietario 
            ORDER by idCuenta";
        }else{
            $Consulta = "select c.idCuenta as ID_Cuenta, 
            a.idApartamento as ID_Apartamento , 
            a.nombre as Nombre_Apartamento, 
            p.idPropietario as ID_Propietario , 
            p.nombre as Nombre_Propietario, 
            p.apellido as Apellido_Propietario, 
            p.telefono as Telefono, 
            e.idEstadoPago as ID_Estado, 
            e.valor as Estado 
            from Cuenta c 
            join Apartamento a on c.Apartamento_idApartamento = a.idApartamento 
            join Propietario p on a.Propietario_idPropietario = p.idPropietario 
            join EstadoPago e on c.EstadoPago_idEstadoPago = e.idEstadoPago
            ORDER by idCuenta"; 
        }
         
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
    public function listarPorPropietario($idPropietario)
    {
        return "SELECT 
                    Cuenta.idCuenta, 
                    Cuenta.fechaLimite, 
                    Cuenta.cantidad, 
                    Cuenta.saldoAnterior, 
                    EstadoPago.valor AS estado, 
                    Apartamento.nombre AS apartamento
                FROM Cuenta 
                INNER JOIN Apartamento ON Cuenta.Apartamento_idApartamento = Apartamento.idApartamento
                INNER JOIN EstadoPago ON Cuenta.EstadoPago_idEstadoPago = EstadoPago.idEstadoPago
                WHERE Apartamento.Propietario_idPropietario = '$idPropietario'
                ORDER BY Cuenta.fechaLimite DESC";
    }
    public function actualizarEstadoPago($idCuenta, $idEstadoPago)
    {
        return "UPDATE Cuenta SET EstadoPago_idEstadoPago = '$idEstadoPago' WHERE idCuenta = '$idCuenta'";
    }


    
}
  