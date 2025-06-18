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

    public function consultar() {
        return "SELECT idPropietario, nombre, apellido, telefono, clave, fechaIngreso, correo FROM Propietario WHERE idPropietario = '" . $this->id . "'";
    }

    public function actualizar() {
        return "UPDATE propietario SET nombre = '{$this->nombre}', apellido = '{$this->apellido}', telefono = '{$this->telefono}', clave = '{$this->clave}', correo = '{$this->correo}' WHERE idPropietario = {$this->id}";
    }

    // MÉTODO CORREGIDO - Opción 1: Usando parámetro
    public function consultarApartamento($idPropietario) {
        return "SELECT a.idApartamento, a.nombre AS nombreApartamento, ar.metrosCuadrados,
                       p.nombre AS nombrePropietario, p.apellido, p.telefono
                FROM Apartamento a
                INNER JOIN Propietario p ON a.Propietario_idPropietario = p.idPropietario
                INNER JOIN Area ar ON a.Area_idArea = ar.idArea
                WHERE p.idPropietario = " . $idPropietario . "
                ORDER BY a.nombre";
    }

    // MÉTODO ALTERNATIVO - Opción 2: Usando la propiedad de clase
    public function consultarApartamentoPropio() {
        return "SELECT a.idApartamento, a.nombre AS nombreApartamento, ar.metrosCuadrados,
                       p.nombre AS nombrePropietario, p.apellido, p.telefono
                FROM Apartamento a
                INNER JOIN Propietario p ON a.Propietario_idPropietario = p.idPropietario
                INNER JOIN Area ar ON a.Area_idArea = ar.idArea
                WHERE p.idPropietario = " . $this->id . "
                ORDER BY a.nombre";
    }

    public function insertar() {
        return "insert into Propietario (nombre, apellido, telefono, clave, fechaIngreso, correo) 
                VALUES (
                '" . $this->nombre . "', 
                '" . $this->apellido . "', 
                '" . $this->telefono . "', 
                '" . $this->clave . "', 
                '" . $this->fechaIngreso . "', 
                '" . $this->correo . "')";
    }

        public function consultarTodos($conexion) {
        $propietarios = array();

        try {
        $sentenciaSQL = "SELECT idPropietario, nombre, apellido, telefono, correo, fechaIngreso 
                    FROM Propietario 
                    WHERE activo = 1 
                    ORDER BY nombre, apellido";
    
        $sentencia = $conexion->prepare($sentenciaSQL);
        $sentencia->execute();
    
        // Para MySQLi usar get_result() y fetch_assoc()
        $resultado = $sentencia->get_result();
        while ($fila = $resultado->fetch_assoc()) {
            // Cambiar la clave 'idPropietario' por 'id' para consistencia
            $fila['id'] = $fila['idPropietario'];
            unset($fila['idPropietario']);
            $propietarios[] = $fila;
        }
    
        $sentencia->close();
        } catch (Exception $e) {
        throw new Exception("Error al consultar propietarios: " . $e->getMessage());
        }

         return $propietarios;
}


        public function eliminarPropietario($conexion, $id) {
        if (empty($id) || $id === 'undefined') {
        throw new Exception("ID de propietario inválido");
        }
    
        return "UPDATE Propietario SET activo = 0 WHERE idPropietario = $id";
}

public function restaurar($conexion, $id) {
    try {
        $sentenciaSQL = "UPDATE Propietario SET activo = 1 WHERE id = ?";
        $sentencia = $conexion->prepare($sentenciaSQL);
        $sentencia->bindParam(1, $id);
        
        return $sentencia->execute();
    } catch (PDOException $e) {
        throw new Exception("Error al restaurar propietario: " . $e->getMessage());
    }
}

    public function eliminar() {
        return "DELETE FROM Propietario WHERE idPropietario = {$this->id}";
    }
}
?>