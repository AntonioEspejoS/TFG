<?php
include_once 'Usuario.php';

class Admin extends Usuario {

    public function __construct($dni, $nombre, $contrasena, $correo) {
        parent::__construct($dni, $nombre, $contrasena, $correo);
    }
}


