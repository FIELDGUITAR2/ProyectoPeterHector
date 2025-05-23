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
        return "SELECT * FROM Cuenta WHERE id = '" . $this->id . "'";
    }

    public function insertar()
    {
        return "INSERT INTO Cuenta (fechaLimite, cantidad, saldoAnterior, idAdmin, idApartamento, idEstadoPago)
                VALUES (
                    '" . $this->fechaLimite . "',
                    " . $this->cantidad . ",
                    " . $this->saldoAnterior . ",
                    '" . $this->idAdmin . "',
                    '" . $this->idApartamento . "',
                    '" . $this->idEstadoPago . "'
                )";
    }

   public function consultarPorApartamento(){
    return "SELECT idCuenta, fechaLimite, cantidad, saldoAnterior, Admin_idAdmin, idApartamento, idEstadoPago 
            FROM Cuenta 
            WHERE idApartamento = '{$this->idApartamento}' 
            ORDER BY fechaLimite DESC LIMIT 1";
}


}
