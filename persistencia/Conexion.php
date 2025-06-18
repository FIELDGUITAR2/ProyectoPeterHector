<?php

class Conexion
{
    private $conexion;
    private $resultado;
    public function extraer()
{
    return $this->resultado ? $this->resultado->fetch_assoc() : null;
}


    public function abrir()
    {
        $this->conexion = new mysqli("localhost", "root", "", "Conjuntos");
    }

    public function cerrar()
    {
        $this->conexion->close();
    }

    public function ejecutar($sql)
    {
        $this->resultado = $this->conexion->query($sql);

        if (!$this->resultado) {
            error_log("Error SQL: " . $this->conexion->error);
        }
    }


    public function registro()
    {
        if (!$this->resultado) {
            return null;
        }

        return $this->resultado->fetch_row();
    }


    public function filas()
    {
        if (!$this->resultado) {
            
            return 0;
        }

        if ($this->resultado instanceof mysqli_result) {
            return $this->resultado->num_rows;
        }

        
        return 0;
    }

    public function getResultado()
    {
        return $this->resultado;
    }

    public function getConexion()
    {
        return $this->conexion;
    }
}
