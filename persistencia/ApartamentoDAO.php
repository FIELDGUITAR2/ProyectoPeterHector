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
        return "select idApartamento, nombre, Area_idArea, Propietario_idPropietario 
        from Apartamento 
        where idApartamento = $this->id";
    }

    public function consultarTodos()
    {
        return "select a.idApartamento, a.nombre nombreApartamento,
        p.idPropietario, p.nombre nombrePropietario, p.apellido apellidoPropietario, p.telefono,
        ar.idArea, ar.metrosCuadrados, ar.valorArriendo
        from Apartamento a
        left join Propietario p on a.Propietario_idPropietario = p.idPropietario
        join Area ar on a.Area_idArea = ar.idArea
        order by p.apellido, p.nombre;";
    }

    public function consultarPorNombre($nombre)
    {
        if ($nombre !== null && trim($nombre) !== "") {
            $nombreEscapado = addslashes($nombre);

            $sentencia = "select a.idApartamento, a.nombre nombreApartamento,
            p.idPropietario, p.nombre nombrePropietario, p.apellido apellidoPropietario, p.telefono,
            ar.idArea, ar.metrosCuadrados, ar.valorArriendo
            from Apartamento a
            left join Propietario p on a.Propietario_idPropietario = p.idPropietario
            join Area ar ON a.Area_idArea = ar.idArea
            WHERE a.nombre = '$nombreEscapado'";

            return $sentencia;
        } else {
            return null;
        }
    }

    public function ApartamentoPropietario($idPropietario)
    {
        $consulta = "select ap.idApartamento as ID_Apartamento, ar.metrosCuadrados as Metros_Cuadrados, ap.nombre as Numero_Apartamento 
        from Apartamento ap join Area ar on ap.Area_idArea = ar.idArea 
        where ap.Propietario_idPropietario = $idPropietario ";
        return $consulta;
    }
    public function tienePropietario($idApartamento)
    {
        return "SELECT Propietario_idPropietario FROM Apartamento WHERE idApartamento = '$idApartamento' AND Propietario_idPropietario IS NOT NULL";
    }
}
