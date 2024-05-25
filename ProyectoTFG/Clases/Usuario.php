<?php
class Usuario {
    public $dni;
    public $nombre;
    public $contrasena;
    public $correo;
    
    
    public function __construct($dni, $nombre, $contrasena, $correo) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
        $this->correo = $correo;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setDni($dni): void {
        $this->dni = $dni;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setContrasena($contrasena): void {
        $this->contrasena = $contrasena;
    }

    public function setCorreo($correo): void {
        $this->correo = $correo;
    }


}

