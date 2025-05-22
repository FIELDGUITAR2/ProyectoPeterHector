<?php
class Area {
    private $id;
    private $metrosCuadrados;

    public function __construct($id = "", $metrosCuadrados = "") {
        $this->id = $id;
        $this->metrosCuadrados = $metrosCuadrados;
    }

   
    public function getId() {
        return $this->id;
    }

    public function getMetrosCuadrados() {
        return $this->metrosCuadrados;
    }



}