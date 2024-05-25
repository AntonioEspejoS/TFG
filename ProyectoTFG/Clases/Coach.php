<?php
include_once 'Usuario.php';

class Coach extends Usuario {
    public $licencia;
    public $club;
    public $estado;
    public $img;
    
    public function __construct($dni, $nombre, $contrasena, $correo, $club, $licencia, $estado, $img = null) {
        parent::__construct($dni, $nombre, $contrasena, $correo);
        $this->licencia = $licencia;
        $this->club = $club;
        $this->estado = $estado;
        $this->img = $img;
    }
    public function getLicencia() {
        return $this->licencia;
    }

    public function getClub() {
        return $this->club;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setLicencia($licencia): void {
        $this->licencia = $licencia;
    }

    public function setClub($club): void {
        $this->club = $club;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }

    public function getImg() {
        return $this->img;
    }

    public function setImg($img): void {
        $this->img = $img;
    }


    
   

}