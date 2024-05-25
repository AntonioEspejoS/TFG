<?php
include_once 'Usuario.php';

class AdminFed extends Usuario {
    public $estado;

    public function __construct($dni, $nombre, $contrasena, $correo, $estado) {
        parent::__construct($dni, $nombre, $contrasena, $correo);
        $this->estado = $estado;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }


}


