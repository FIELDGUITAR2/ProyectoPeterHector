<?php
class AdminDAO {
    private $id;
    private $nombre;
    private $apellido;
    private $telefono;
    private $clave;
    private $correo;

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $correo = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->clave = $clave;
        $this->correo = $correo;
    }

    public function getId() {
        return $this->id;
    }

    public function autenticar() {
        return "SELECT idAdmin FROM Admin WHERE correo = '" . $this->correo . "' AND clave = '" . $this->clave . "'";
    }

    public function consultar2() {
        return "SELECT idAdmin, nombre, apellido FROM Admin WHERE activo = 1";
    }

    public function consultar() {
        return "SELECT idAdmin, nombre, apellido, telefono, clave, correo FROM Admin WHERE idAdmin = '" . $this->id . "'";
    }

    public function actualizar() {
        return "UPDATE Admin SET nombre = '{$this->nombre}', apellido = '{$this->apellido}', telefono = '{$this->telefono}', clave = '{$this->clave}', correo = '{$this->correo}' WHERE idAdmin = {$this->id}";
    }

    public function insertar() {
        return "INSERT INTO Admin (nombre, apellido, telefono, clave, correo) VALUES ('{$this->nombre}', '{$this->apellido}', '{$this->telefono}', '{$this->clave}', '{$this->correo}')";
    }

    public function consultarTodos($conexion) {
        $administradores = array();
        
        try {
            $sentenciaSQL = "SELECT idAdmin, nombre, apellido, telefono, correo 
                            FROM Admin 
                            WHERE activo = 1 
                            ORDER BY nombre, apellido";
            
            $sentencia = $conexion->prepare($sentenciaSQL);
            $sentencia->execute();
            
            // Para MySQLi usar get_result() y fetch_assoc()
            $resultado = $sentencia->get_result();
            while ($fila = $resultado->fetch_assoc()) {
                // Cambiar la clave 'idAdmin' por 'id' para consistencia
                $fila['id'] = $fila['idAdmin'];
                unset($fila['idAdmin']);
                $administradores[] = $fila;
            }
            
            $sentencia->close();
        } catch (Exception $e) {
            throw new Exception("Error al consultar administradores: " . $e->getMessage());
        }
        
        return $administradores;
    }

    public function eliminarAdmin($conexion, $id) {
        if (empty($id) || $id === 'undefined') {
            throw new Exception("ID de administrador inválido");
        }
        
        return "UPDATE Admin SET activo = 0 WHERE idAdmin = $id";
    }

    public function restaurar($conexion, $id) {
        try {
            $sentenciaSQL = "UPDATE Admin SET activo = 1 WHERE idAdmin = ?";
            $sentencia = $conexion->prepare($sentenciaSQL);
            $sentencia->bind_param("i", $id);
            
            return $sentencia->execute();
        } catch (Exception $e) {
            throw new Exception("Error al restaurar administrador: " . $e->getMessage());
        }
    }

    public function eliminar() {
        return "DELETE FROM Admin WHERE idAdmin = {$this->id}";
    }
}
?>