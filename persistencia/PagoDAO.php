<?php
class PagoDAO
{
    private $id;
    private $fecha;
    private $cuenta;

    public function __construct($id = "", $fecha = "", $cuenta = "")
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->cuenta = $cuenta;
    }

    public function consultar()
    {
        return "SELECT idPago, fechaPago, Cuenta_idCuenta 
                FROM Pagos 
                WHERE idPago = $this->id";
    }

    public function consultarTodos()
    {
        return "SELECT p.idPago, p.fechaPago,
                c.idCuenta, c.numeroFactura, c.valorFactura, c.fechaVencimiento,
                a.idApartamento, a.nombre nombreApartamento,
                pr.idPropietario, pr.nombre nombrePropietario, pr.apellido apellidoPropietario
                FROM Pagos p
                JOIN Cuenta c ON p.Cuenta_idCuenta = c.idCuenta
                JOIN Apartamento a ON c.Apartamento_idApartamento = a.idApartamento
                LEFT JOIN Propietario pr ON a.Propietario_idPropietario = pr.idPropietario
                ORDER BY p.fechaPago DESC";
    }

    public function consultarPorCuenta($idCuenta)
    {
        return "SELECT p.idPago, p.fechaPago, p.Cuenta_idCuenta,
                c.numeroFactura, c.valorFactura, c.fechaVencimiento
                FROM Pagos p
                JOIN Cuenta c ON p.Cuenta_idCuenta = c.idCuenta
                WHERE p.Cuenta_idCuenta = $idCuenta
                ORDER BY p.fechaPago DESC";
    }

    public function consultarPorFecha($fechaInicio, $fechaFin)
    {
        if ($fechaInicio !== null && $fechaFin !== null && 
            trim($fechaInicio) !== "" && trim($fechaFin) !== "") {
            
            $fechaInicioEscapada = addslashes($fechaInicio);
            $fechaFinEscapada = addslashes($fechaFin);

            $sentencia = "SELECT p.idPago, p.fechaPago,
                         c.idCuenta, c.numeroFactura, c.valorFactura,
                         a.nombre nombreApartamento,
                         pr.nombre nombrePropietario, pr.apellido apellidoPropietario
                         FROM Pagos p
                         JOIN Cuenta c ON p.Cuenta_idCuenta = c.idCuenta
                         JOIN Apartamento a ON c.Apartamento_idApartamento = a.idApartamento
                         LEFT JOIN Propietario pr ON a.Propietario_idPropietario = pr.idPropietario
                         WHERE p.fechaPago BETWEEN '$fechaInicioEscapada' AND '$fechaFinEscapada'
                         ORDER BY p.fechaPago DESC";

            return $sentencia;
        } else {
            return null;
        }
    }

    public function existePagoCuenta($idCuenta)
    {
        return "SELECT COUNT(*) FROM Pagos WHERE Cuenta_idCuenta = $idCuenta";
    }

    public function pagosPorPropietario($idPropietario)
    {
        $consulta = "SELECT p.idPago, p.fechaPago, c.numeroFactura, c.valorFactura, a.nombre as Numero_Apartamento
                    FROM Pagos p 
                    JOIN Cuenta c ON p.Cuenta_idCuenta = c.idCuenta
                    JOIN Apartamento a ON c.Apartamento_idApartamento = a.idApartamento
                    WHERE a.Propietario_idPropietario = $idPropietario
                    ORDER BY p.fechaPago DESC";
        return $consulta;
    }

    public function verificarPagoMes($idCuenta, $año, $mes)
    {
        return "SELECT COUNT(*) FROM Pagos p
                JOIN Cuenta c ON p.Cuenta_idCuenta = c.idCuenta
                WHERE p.Cuenta_idCuenta = $idCuenta 
                AND YEAR(p.fechaPago) = $año 
                AND MONTH(p.fechaPago) = $mes";
    }

    public function totalPagosPorApartamento($idApartamento)
    {
        return "SELECT COUNT(p.idPago) as totalPagos, SUM(c.valorFactura) as totalMonto
                FROM Pagos p
                JOIN Cuenta c ON p.Cuenta_idCuenta = c.idCuenta
                WHERE c.Apartamento_idApartamento = $idApartamento";
    }
}