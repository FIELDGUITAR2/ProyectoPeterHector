<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/ApartamentoDAO.php");


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
                $propietario = new Propietario($datos[2], $datos[3], $datos[4], $datos[5]);
            }

            $area = new Area($datos[6], $datos[7], $datos[8]);
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
                $propietario = new Propietario($datos[2], $datos[3], $datos[4], $datos[5]);
            }
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
        $Apartamento  = new Apartamento();
        $Apartamentodao = new ApartamentoDAO();
        $consulta = $Apartamentodao->ApartamentoPropietario($idPropietario);
        $conexion->abrir();
        $conexion->ejecutar($consulta);
        $listaApartamentos = $conexion->getResultado();
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

        // Agrega esta línea para ver la consulta SQL exacta
        $sql_query = "SELECT idApartamento, nombre, Area_idArea FROM Apartamento WHERE Propietario_idPropietario = '$idPropietario'";
        error_log("Consulta SQL para apartamentos del propietario " . $idPropietario . ": " . $sql_query); //

        $conexion->ejecutar($sql_query); //

        $apartamentos = [];
        while (($registro = $conexion->extraer()) != null) { //
            // Agrega esta línea para ver lo que se extrae de la base de datos
            error_log("Registro extraído: " . print_r($registro, true));

            // Aquí estás usando índices numéricos (0, 1), lo cual es común.
            // Asegúrate de que tu método extraer() devuelva un array indexado numéricamente.
            // Si extraer() devuelve un array asociativo, necesitarías usar $registro['idApartamento'], $registro['nombre'].
            if (isset($registro[0], $registro[1], $registro[2])) { //
                // Para obtener los metros cuadrados, necesitas unirte con la tabla Area.
                // La consulta actual solo selecciona idApartamento y nombre de Apartamento.
                // Vamos a mejorar la consulta SQL para incluir los metros cuadrados.

                // Temporalmente, si el problema es solo que no los muestra,
                // verifica si al menos idApartamento y nombre se están recuperando.
                $apartamentos[] = [
                    'idApartamento' => $registro[0],
                    'nombre' => $registro[1],
                    'idArea' => $registro[2] // Agregamos el ID del área para luego obtener los metros cuadrados
                ];
            }
        }
        $conexion->cerrar(); //

        // Ahora, si los apartamentos se obtuvieron correctamente, vamos a buscar sus metros cuadrados
        if (!empty($apartamentos)) {
            foreach ($apartamentos as &$apt) {
                $area = new Area($apt['idArea']);
                $area->consultar(); // Asumiendo que Area tiene un método consultar()
                $apt['metrosCuadrados'] = $area->getMetrosCuadrados();
            }
        }

        error_log("Apartamentos afectados obtenidos: " . print_r($apartamentos, true));

        return $apartamentos; //
    }

    public function consultarActivos($excluirId = null)
    {
        $conexion = new Conexion();
        $conexion->abrir();

        $query = "SELECT idPropietario, nombre, apellido FROM Propietario WHERE activo = 1";
        if ($excluirId) {
            $query .= " AND idPropietario != '$excluirId'";
        }

        $resultado = $conexion->ejecutar($query);

        $propietarios = [];
        while ($registro = $conexion->extraer()) {
            $propietarios[] = [
                'id' => $registro[0],
                'nombre' => $registro[1],
                'apellido' => $registro[2]
            ];
        }

        $conexion->cerrar();
        return $propietarios;
    }
}
