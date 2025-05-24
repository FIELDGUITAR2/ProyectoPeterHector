<?php
class ApartamentoDAO
{
    private $id;
    private $nombre;
    private $idArea;
    private $idPropietario;

    public function __construct($id = "", $nombre = "", $idArea = "", $idPropietario = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->idArea = $idArea;
        $this->idPropietario = $idPropietario;
    }

    public function consultar()
    {
        return "SELECT idApartamento, nombre, Area_idArea, Propietario_idPropietario 
                FROM Apartamento 
                WHERE idApartamento = " . $this->id;
    }

    public function consultarTodos()
    {
        return "SELECT a.idApartamento, a.nombre nombreApartamento,
       p.idPropietario, p.nombre nombrePropietario, p.apellido apellidoPropietario, p.telefono,
       ar.idArea, ar.metrosCuadrados, ar.valorArriendo
       FROM Apartamento a
        LEFT JOIN Propietario p ON a.Propietario_idPropietario = p.idPropietario
        JOIN Area ar ON a.Area_idArea = ar.idArea
        ORDER BY p.apellido, p.nombre;";
    }

    public function consultarPorNombre($nombre)
    {
        if ($nombre !== null && trim($nombre) !== "") {
            $nombreEscapado = addslashes($nombre);

            $sentencia = "SELECT a.idApartamento, a.nombre nombreApartamento,
       p.idPropietario, p.nombre nombrePropietario, p.apellido apellidoPropietario, p.telefono,
       ar.idArea, ar.metrosCuadrados, ar.valorArriendo
       FROM Apartamento a
        LEFT JOIN Propietario p ON a.Propietario_idPropietario = p.idPropietario
        JOIN Area ar ON a.Area_idArea = ar.idArea
                      WHERE a.nombre = '" . $nombreEscapado . "'";
            return $sentencia;
        } else {
            return null;
        }
    }
}
