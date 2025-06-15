<?php
    class Estado{
        private $idEstado;
        private $Nombre;
        
        public function __construct($idEstado = "", $Nombre = "")
        {
            $this->idEstado = $idEstado;
            $this->Nombre = $Nombre;
        }
        /**
         * Get the value of idEstado
         */ 
        public function getIdEstado()
        {
                return $this->idEstado;
        }
        /**
         * Get the value of Nombre
         */ 
        public function getNombre()
        {
                return $this->Nombre;
        }
    }
?>