<?php
class PropietarioDAO {
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $clave;
    private $fechaIngreso;
    private $correo;

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $fechaIngreso = "", $correo="") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->clave = $clave;
        $this->fechaIngreso = $fechaIngreso;
        $this->correo = $correo;
    }

    public function getId() {
        return $this->id;
    }


    public function autenticar() {


    return "SELECT idPropietario 
            FROM Propietario 
            WHERE correo = '" . $this->correo . "' AND clave = '" . $this->clave . "'";
    }

    public function consultar2() {
        return "SELECT idPropietario, nombre, apellido, fechaIngreso FROM Propietario";
    }

    public function consultar()
    {
        return "SELECT idPropietario, nombre, apellido, telefono, clave, fechaIngreso, correo FROM Propietario WHERE idPropietario = '" . $this->id . "'";
    }

    public function actualizar()
    {
        return "UPDATE propietario SET nombre = '{$this->nombre}', apellido = '{$this->apellido}', telefono = '{$this->telefono}', clave = '{$this->clave}', correo = '{$this->correo}' WHERE idPropietario = {$this->id}";
       
    }

    public function consultarApartamento()
    {
          return "SELECT a.idApartamento, a.nombre AS nombreApartamento, ar.metrosCuadrados,
                               p.nombre AS nombrePropietario, p.apellido, p.telefono
                        FROM Apartamento a
                        INNER JOIN Propietario p ON a.Propietario_idPropietario = p.idPropietario
                        INNER JOIN Area ar ON a.Area_idArea = ar.idArea
                        WHERE p.idPropietario = getId()
                        ORDER BY a.nombre";
    }


}
