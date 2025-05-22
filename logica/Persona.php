<?php
abstract class Persona
{

    protected $id;
    protected $nombre;
    protected $apellido;
    protected $telefono;
    protected $clave;

    public function __construct($id = "", $nombre = "", $apellido = "",$telefono="" , $clave = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this ->telefono = $telefono;
        $this->clave = $clave;
    }

    public function getId()
    {
        return $this->id;
    }
     
    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setId($id){
        $this -> id = $id;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }
}
