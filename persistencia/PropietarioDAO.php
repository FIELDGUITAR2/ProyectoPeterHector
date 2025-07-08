<?php
class PropietarioDAO {
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $clave;
    private $fechaIngreso;
    private $correo;

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $fechaIngreso = "", $correo = "") {
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

    public function autenticar($correo, $clave) {
        return "SELECT idPropietario FROM Propietario WHERE correo = '$correo' AND clave = '$clave'";
    }

    public function consultar() {
        return "SELECT idPropietario, nombre, apellido, telefono, clave, fechaIngreso, correo 
                FROM Propietario WHERE idPropietario = '{$this->id}'";
    }

    public function actualizar() {
        return "UPDATE Propietario 
                SET nombre = '{$this->nombre}', apellido = '{$this->apellido}', clave = '{$this->clave}', 
                    telefono = '{$this->telefono}', correo = '{$this->correo}' 
                WHERE idPropietario = '{$this->id}'";
    }

    public function consultarApartamento($idPropietario) {
        return "SELECT a.idApartamento, a.nombre AS nombreApartamento, ar.metrosCuadrados,
                       p.nombre AS nombrePropietario, p.apellido, p.telefono
                FROM Apartamento a
                INNER JOIN Propietario p ON a.Propietario_idPropietario = p.idPropietario
                INNER JOIN Area ar ON a.Area_idArea = ar.idArea
                WHERE p.idPropietario = $idPropietario
                ORDER BY a.nombre";
    }

    public function insertar() {
        return "INSERT INTO Propietario (nombre, apellido, telefono, clave, fechaIngreso, correo)
                VALUES ('{$this->nombre}', '{$this->apellido}', '{$this->telefono}', '{$this->clave}', 
                        '{$this->fechaIngreso}', '{$this->correo}')";
    }

    public function consultarTodos($conexion) {
        $propietarios = [];
        $sentenciaSQL = "SELECT idPropietario, nombre, apellido, correo, telefono, activo AS estado, fechaIngreso
                         FROM Propietario WHERE activo = 1 ORDER BY nombre, apellido";
        $sentencia = $conexion->prepare($sentenciaSQL);
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        while ($fila = $resultado->fetch_assoc()) {
            $fila['id'] = $fila['idPropietario'];
            unset($fila['idPropietario']);
            $propietarios[] = $fila;
        }

        $sentencia->close();
        return $propietarios;
    }

    public function eliminarPropietario($conexion, $id) {
        return "UPDATE Propietario SET activo = 0 WHERE idPropietario = $id";
    }

    public function restaurar($conexion, $id) {
        $sentenciaSQL = "UPDATE Propietario SET activo = 1 WHERE idPropietario = ?";
        $sentencia = $conexion->prepare($sentenciaSQL);
        $sentencia->bind_param("i", $id);
        return $sentencia->execute();
    }

    public function eliminar() {
        return "DELETE FROM Propietario WHERE idPropietario = {$this->id}";
    }
}
?>
