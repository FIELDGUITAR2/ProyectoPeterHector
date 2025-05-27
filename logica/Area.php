<?php
class Area {
    private $id;
    private $metrosCuadrados;
    private $valorArriendo; // nueva propiedad

    public function __construct($id = "", $metrosCuadrados = "", $valorArriendo = 0) {
        $this->id = $id;
        $this->metrosCuadrados = $metrosCuadrados;
        $this->valorArriendo = $valorArriendo;
    }

    public function getId() {
        return $this->id;
    }

    public function getMetrosCuadrados() {
        return $this->metrosCuadrados;
    }

    public function getValorArriendo() {
        return $this->valorArriendo;
    }

    public function setValorArriendo($valorArriendo) {
        $this->valorArriendo = $valorArriendo;
    }
}
