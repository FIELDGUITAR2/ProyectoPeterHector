<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/ApartamentoDAO.php");
require_once("logica/Propietario.php"); // Asegúrate de incluir Propietario
require_once("logica/Aria.php"); // Asegúrate de incluir Area (si existe y la usas)


class Apartamento
{
    private $id;
    private $nombre;
    private $area;
    private $propietario;

    public function __construct($id = "", $nombre = "", $area = null, $propietario = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->area = $area;
        $this->propietario = $propietario;
    }

    public function consultarTodos()
    {
        $conexion = new Conexion();
        $apartamentoDAO = new ApartamentoDAO();
        $conexion->abrir();
        $conexion->ejecutar($apartamentoDAO->consultarTodos());
        $apartamentos = array();
        while (($datos = $conexion->registro()) != null) {
            $propietario = null;
            if ($datos[2] !== null) {
                // Asegúrate que los índices de $datos coincidan con el SELECT de consultarTodos en ApartamentoDAO
                // Si ApartamentoDAO->consultarTodos() incluye más campos, ajusta esto
                $propietario = new Propietario($datos[2], $datos[3], $datos[4], $datos[5], "", "");
            }
            // Asegúrate que los índices de $datos coincidan con el SELECT de consultarTodos en ApartamentoDAO para Area
            $area = new Area($datos[6], $datos[7], $datos[8]); // Asumiendo que Area se construye con id, metrosCuadrados, valorArriendo
            $apartamento = new Apartamento($datos[0], $datos[1], $area, $propietario);

            array_push($apartamentos, $apartamento);
        }
        $conexion->cerrar();
        return $apartamentos;
    }

    public function consultarPorNombre($nombre)
    {
        $conexion = new Conexion();
        $apartamentoDAO = new ApartamentoDAO();
        $conexion->abrir();
        $conexion->ejecutar($apartamentoDAO->consultarPorNombre($nombre));
        $datos = $conexion->registro();

        if ($datos != null) {
            $propietario = null;
            if ($datos[2] !== null) {
                // Ajustar índices si ApartamentoDAO->consultarPorNombre() trae más campos
                $propietario = new Propietario($datos[2], $datos[3], $datos[4], $datos[5], "", "");
            }
            // Ajustar índices si ApartamentoDAO->consultarPorNombre() trae más campos para Area
            $area = new Area($datos[6], $datos[7], $datos[8]);
            $apartamento = new Apartamento($datos[0], $datos[1], $area, $propietario);
            $conexion->cerrar();
            return $apartamento;
        }

        $conexion->cerrar();
        return null;
    }

    public function tienePropietario($idApartamento)
    {
        $conexion = new Conexion();
        $apartamentoDAO = new ApartamentoDAO();
        $conexion->abrir();

        $conexion->ejecutar($apartamentoDAO->tienePropietario($idApartamento));
        $tiene = $conexion->filas() > 0;

        $conexion->cerrar();

        return $tiene;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function getPropietario()
    {
        return $this->propietario;
    }

    public function ListaApartamentos($idPropietario)
    {
        $conexion = new Conexion();
        $Apartamento  = new Apartamento(); // Esta línea es redundante, ya estás dentro de la clase Apartamento
        $Apartamentodao = new ApartamentoDAO();
        $consulta = $Apartamentodao->ApartamentoPropietario($idPropietario);
        $conexion->abrir();
        $conexion->ejecutar($consulta);
        $listaApartamentos = $conexion->getResultado(); // Asumo que getResultado() obtiene todas las filas
        // Necesitarías devolver $listaApartamentos aquí si la vas a usar
    }

    public function cambiarPropietario($nuevoPropietarioId)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->ejecutar("UPDATE Apartamento SET Propietario_idPropietario = " . ($nuevoPropietarioId ? "'$nuevoPropietarioId'" : "NULL") . " WHERE idApartamento = '$this->id'");
        $conexion->cerrar();
    }

    public function consultarConPropietario($idPropietario)
    {
        $conexion = new Conexion();
        $conexion->abrir();

        // **CORRECCIÓN ANTERIOR MANTENIDA:** Se une con Area para obtener metrosCuadrados
        $sql_query = "SELECT a.idApartamento, a.nombre, ar.metrosCuadrados 
                      FROM Apartamento a
                      JOIN Area ar ON a.Area_idArea = ar.idArea
                      WHERE a.Propietario_idPropietario = '$idPropietario'";

        error_log("DEBUG - Consulta SQL en consultarConPropietario: " . $sql_query);

        $conexion->ejecutar($sql_query);

        $apartamentos = [];
        while (($registro = $conexion->extraer()) != null) {
            error_log("DEBUG - Registro extraído en consultarConPropietario: " . print_r($registro, true));

            // Asegúrate de que los índices numéricos coincidan con las columnas seleccionadas
            if (isset($registro[0], $registro[1], $registro[2])) {
                $apartamentos[] = [
                    'idApartamento' => $registro[0],
                    'nombre' => $registro[1],
                    'metrosCuadrados' => $registro[2]
                ];
            } else {
                error_log("DEBUG - Error: Registro incompleto para apartamento en consultarConPropietario.");
            }
        }
        $conexion->cerrar();

        error_log("DEBUG - Apartamentos afectados obtenidos (final): " . print_r($apartamentos, true));

        return $apartamentos;
    }

    public function consultarActivos($excluirId = null)
    {
        $conexion = new Conexion();
        $conexion->abrir();

        // **CORRECCIÓN PARA EL ERROR 'telefono':** Se agrega 'telefono' a la consulta SQL
        $query = "SELECT idPropietario, nombre, apellido, telefono FROM Propietario WHERE activo = 1"; 
        if ($excluirId) {
            $query .= " AND idPropietario != '$excluirId'";
        }

        error_log("DEBUG - Consulta SQL para propietarios activos: " . $query);

        $conexion->ejecutar($query);

        $propietarios = [];
        while ($registro = $conexion->extraer()) {
            error_log("DEBUG - Registro propietario activo extraído: " . print_r($registro, true));

            // Asegúrate de que los índices numéricos coincidan con las columnas seleccionadas
            // $registro[0] = idPropietario
            // $registro[1] = nombre
            // $registro[2] = apellido
            // $registro[3] = telefono
            if (isset($registro[0], $registro[1], $registro[2], $registro[3])) { 
                $propietarios[] = [
                    'idPropietario' => $registro[0],
                    'nombre' => $registro[1],
                    'apellido' => $registro[2],
                    'telefono' => $registro[3] // Añadido para que la clave 'telefono' exista
                ];
            } else {
                error_log("DEBUG - Error: Registro de propietario activo incompleto o inesperado (faltan campos).");
            }
        }

        $conexion->cerrar();
        error_log("DEBUG - Propietarios disponibles obtenidos (final): " . print_r($propietarios, true));
        return $propietarios;
    }
}