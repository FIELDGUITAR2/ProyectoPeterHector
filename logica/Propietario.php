<?php
require_once("logica/Persona.php");
require_once("persistencia/Conexion.php"); // Necesario para la clase Conexion
require_once("persistencia/PropietarioDAO.php");

class Propietario extends Persona
{
    private $fechaIngreso;
    private $PropietariosLista; // Si no lo usas, puedes eliminar esta propiedad

    public function __construct($id = "", $nombre = "", $apellido = "", $telefono = "", $clave = "", $fechaIngreso = "", $correo = "")
    {
        parent::__construct($id, $nombre, $apellido, $telefono, $clave, $correo);
        $this->fechaIngreso = $fechaIngreso;
    }

    public function getFecha()
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;
    }

    public function consultar2()
    {
        $conexion = new Conexion();
        $propietarioDAO = new PropietarioDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($propietarioDAO->consultar2());
        $propietarios = array();
        while (($datos = $conexion->registro()) != null) {
            // Asegúrate que los índices de $datos coincidan con el SELECT de consultar2 en PropietarioDAO
            $propietario = new Propietario($datos[0], $datos[1], $datos[2], "", "", $datos[3]);
            array_push($propietarios, $propietario);
        }
        $conexion->cerrar();
        return $propietarios;
    }

    public function consultar()
    {
        $conexion = new Conexion();
        $propietarioDAO = new PropietarioDAO($this->id);
        $conexion->abrir();
        $conexion->ejecutar($propietarioDAO->consultar());
        $datos = $conexion->registro(); // Usa registro() o extraer() según lo que esperes
        if ($datos) {
            $this->id = $datos[0]; // Actualizar el ID de la instancia
            $this->setNombre($datos[1]);
            $this->setApellido($datos[2]);
            $this->setTelefono($datos[3]);
            $this->setClave($datos[4]);
            $this->setFechaIngreso($datos[5]);
            $this->setCorreo($datos[6]);
        }
        $conexion->cerrar();
    }

    public function actualizar()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        // Uso de addslashes en lugar de escapar para compatibilidad
        $idSanitizado = addslashes($this->id);
        $nombreSanitizado = addslashes($this->getNombre());
        $apellidoSanitizado = addslashes($this->getApellido());
        $telefonoSanitizado = addslashes($this->getTelefono());
        $claveSanitizada = addslashes($this->getClave());
        $correoSanitizado = addslashes($this->getCorreo());

        $propietarioDAO = new PropietarioDAO(
            $idSanitizado,
            $nombreSanitizado,
            $apellidoSanitizado,
            $telefonoSanitizado,
            $claveSanitizada,
            $this->getFecha(), // Asumiendo que la fecha no necesita sanitizar si ya es un formato válido
            $correoSanitizado
        );
        $conexion->ejecutar($propietarioDAO->actualizar());
        $resultado = $conexion->getConexion()->affected_rows > 0; // Verifica filas afectadas
        $conexion->cerrar();
        return $resultado;
    }

    public function insertar()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        // Uso de addslashes en lugar de escapar para compatibilidad
        $nombreSanitizado = addslashes($this->getNombre());
        $apellidoSanitizado = addslashes($this->getApellido());
        $telefonoSanitizado = addslashes($this->getTelefono());
        $claveHasheadaSanitizada = md5(addslashes($this->getClave())); // Hashear y sanitizar
        $correoSanitizado = addslashes($this->getCorreo());

        $propietarioDAO = new PropietarioDAO("", $nombreSanitizado, $apellidoSanitizado, $telefonoSanitizado, $claveHasheadaSanitizada, $this->getFecha(), $correoSanitizado);
        $conexion->ejecutar($propietarioDAO->insertar());

        $idInsertado = $conexion->getConexion()->insert_id; // Obtener el ID del último insert
        $conexion->cerrar();
        return $idInsertado;
    }

    public function consultarTodos()
    {
        $propietarios = array();
        $conexion = new Conexion();
        $conexion->abrir();

        $propietarioDAO = new PropietarioDAO();
        // Llama al método consultarTodos del DAO que ahora ejecuta la consulta y devuelve los resultados
        $resultadosDAO = $propietarioDAO->consultarTodos($conexion->getConexion());

        foreach ($resultadosDAO as $registro) {
            // Los resultados ya son asociativos desde el DAO
            $propietarios[] = $registro;
        }
        $conexion->cerrar();
        return $propietarios;
    }

    // **MÉTODO CORREGIDO para asegurar arrays asociativos directamente**
    public function consultarActivos($excluirId = null)
    {
        $conexion = new Conexion();
        $conexion->abrir();

        // Uso de addslashes en lugar de escapar para compatibilidad
        $excluirIdSanitizado = addslashes($excluirId);

        $query = "SELECT idPropietario, nombre, apellido, telefono FROM Propietario WHERE activo = 1";
        if ($excluirIdSanitizado) {
            $query .= " AND idPropietario != '$excluirIdSanitizado'";
        }

        error_log("DEBUG - Consulta SQL en Propietario::consultarActivos: " . $query);
        $conexion->ejecutar($query); // Ejecuta la consulta y guarda el resultado en $conexion->resultado

        $propietarios = [];
        // Ahora usamos fetch_assoc() directamente del objeto mysqli_result
        if ($conexion->getResultado() instanceof mysqli_result) {
            while (($registro = $conexion->getResultado()->fetch_assoc()) !== null) {
                error_log("DEBUG - Registro propietario activo extraído (de Propietario::consultarActivos - asociativo): " . print_r($registro, true));
                $propietarios[] = $registro; // Añadimos el array asociativo directamente
            }
        } else {
            error_log("DEBUG - Error: El resultado de la consulta no es un objeto mysqli_result en Propietario::consultarActivos.");
        }

        $conexion->cerrar();
        error_log("DEBUG - Propietarios disponibles obtenidos (final): " . print_r($propietarios, true));
        return $propietarios;
    }


    public function eliminar()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        // Uso de addslashes en lugar de escapar para compatibilidad
        $idSanitizado = addslashes($this->id);
        $propietarioDAO = new PropietarioDAO();

        try {
            // Obtener la cadena SQL del DAO y ejecutarla
            $sql = $propietarioDAO->eliminarPropietario($conexion, $idSanitizado);
            if ($sql === null) { // Si el DAO devuelve null por ID inválido
                throw new Exception("ID de propietario inválido para eliminar.");
            }
            $conexion->ejecutar($sql);

            // Verificar si la operación fue exitosa
            if ($conexion->getConexion()->affected_rows > 0) {
                $conexion->cerrar();
                return true;
            } else {
                error_log("DEBUG - No se afectaron filas al eliminar propietario (ID: $idSanitizado). Podría no existir o ya estar inactivo.");
                $conexion->cerrar();
                return false;
            }
        } catch (Exception $e) {
            $conexion->cerrar();
            error_log("ERROR - Error en Propietario::eliminar: " . $e->getMessage());
            throw new Exception("Error al eliminar propietario: " . $e->getMessage());
        }
    }

    public function restaurar()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        // Uso de addslashes en lugar de escapar para compatibilidad
        $idSanitizado = addslashes($this->id);
        $propietarioDAO = new PropietarioDAO();

        try {
            // Llama al método restaurar del DAO que ahora ejecuta la consulta directamente
            $resultadoRestaurar = $propietarioDAO->restaurar($conexion->getConexion(), $idSanitizado);

            if ($resultadoRestaurar) { // Si devuelve true (éxito)
                // En MySQLi, after a successful UPDATE using execute(), affected_rows is available
                // if ($conexion->getConexion()->affected_rows > 0) { // This might not be reliable if DAO handles execute
                $conexion->cerrar();
                return true;
                // }
            } else {
                error_log("DEBUG - Fallo al ejecutar restaurar en PropietarioDAO (ID: $idSanitizado). Podría no existir o ya estar activo.");
                $conexion->cerrar();
                return false;
            }
        } catch (Exception $e) {
            $conexion->cerrar();
            error_log("ERROR - Error en Propietario::restaurar: " . $e->getMessage());
            throw new Exception("Error al restaurar propietario: " . $e->getMessage());
        }
    }

    public function reasignarApartamentosAPropietarioActivo()
    {
        $conexion = new Conexion();
        $conexion->abrir();

        // Uso de addslashes en lugar de escapar para compatibilidad
        $idSanitizado = addslashes($this->id);

        // Buscar apartamentos del propietario actual
        $consulta = "SELECT idApartamento FROM Apartamento WHERE Propietario_idPropietario = '$idSanitizado'";
        $conexion->ejecutar($consulta);

        $apartamentos = [];
        while ($registro = $conexion->extraer()) {
            $apartamentos[] = $registro[0];
        }

        if (empty($apartamentos)) {
            $conexion->cerrar();
            return "Este propietario no tiene apartamentos asignados.";
        }

        // Buscar nuevo propietario activo distinto al actual
        $nuevoPropQuery = "SELECT idPropietario FROM Propietario WHERE activo = 1 AND idPropietario != '$idSanitizado' LIMIT 1";
        $conexion->ejecutar($nuevoPropQuery);
        $nuevoPropietario = $conexion->extraer();

        if (!$nuevoPropietario) {
            $conexion->cerrar();
            return "No hay otro propietario activo disponible para reasignar.";
        }

        $nuevoId = $nuevoPropietario[0];
        // Uso de addslashes para el nuevo ID
        $nuevoIdSanitizado = addslashes($nuevoId);

        // Reasignar los apartamentos al nuevo propietario
        foreach ($apartamentos as $idApartamento) {
            // Uso de addslashes para el ID de apartamento
            $idApartamentoSanitizado = addslashes($idApartamento);
            $updateQuery = "UPDATE Apartamento SET Propietario_idPropietario = '$nuevoIdSanitizado' WHERE idApartamento = '$idApartamentoSanitizado'";
            $conexion->ejecutar($updateQuery);
        }

        $conexion->cerrar();
        return "Reasignación exitosa al propietario con ID: $nuevoId.";
    }

    public function autenticar($correo, $clave) { //
    $conexion = new Conexion(); //
    $conexion->abrir(); //

    $correoSanitizado = addslashes($correo); //
    $claveHasheadaSanitizada = md5(addslashes($clave)); //

    // Registros de depuración
    error_log("Attempting authentication for email: " . $correoSanitizado);
    error_log("Generated MD5 hash for password: " . $claveHasheadaSanitizada);

    $propietarioDAO = new PropietarioDAO(
        "", "", "", "",
        $claveHasheadaSanitizada,
        "",
        $correoSanitizado
    ); //

    $sql = $propietarioDAO->autenticar($correo, $clave); //

    // Depurando la consulta SQL real
    error_log("SQL Query for authentication: " . $sql);


    $conexion->ejecutar($sql); //
    if ($conexion->filas() == 1) { //
        $this->id = $conexion->registro()[0]; //
        $conexion->cerrar(); //
        error_log("Authentication SUCCESS for ID: " . $this->id);
        return true; //
    } else {
        $conexion->cerrar(); //
        error_log("Authentication FAILED for email: " . $correoSanitizado . ". No rows found or more than one.");
        return false; //
    }
}

    public function getPropietariosLista()
    {
        return $this->PropietariosLista;
    }

    public function obtenerPropietariosConApartamentos()
    {
        return "SELECT p.idPropietario, p.nombre, p.apellido, p.telefono, p.correo, a.nombre AS apartamento
                        FROM Propietario p
                        LEFT JOIN Apartamento a ON p.idPropietario = a.Propietario_idPropietario
                        ORDER BY p.idPropietario, a.nombre";
    }
}
