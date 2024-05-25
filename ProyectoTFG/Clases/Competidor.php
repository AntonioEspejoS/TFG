<?php
include_once 'Usuario.php';

class Competidor extends Usuario {
    public $fech_nac;
    public $Catedad;
    public $licencia;
    public $club;
    public $peso;
    public $sexo;
    public $estado;//0=inactivo, 1 activo por el admin, 2 activo por el coach y 3 activo por ambos 
    public $img;

    public function __construct($dni, $nombre, $contrasena, $correo, $fech_nac, $licencia, $club, $peso, $sexo, $estado, $img = null) {
        parent::__construct($dni, $nombre, $contrasena, $correo);
        $this->fech_nac = $fech_nac;
        $this->licencia = $licencia;
        $this->club = $club;
        $this->peso = $peso;
        $this->sexo = $sexo;
        $this->estado = $estado;
        $this->img = $img;
        $this->Catedad = $this->calcularCategoriaEdad($fech_nac);
    }

    public function calcularCategoriaEdad($fech_nac) {
        $fechaNacimiento = new DateTime($fech_nac);
        $fechaActual = new DateTime('now');
        $edad = $fechaActual->diff($fechaNacimiento)->y;

        if ($edad >= 5 && $edad < 19) {
            return 'junior';
        } else if ($edad >= 19) {
            return 'senior';
        } else {
            return 'No Aplica'; // Para edades fuera de los rangos especificados
        }
    }

    public function getFech_nac() {
        return $this->fech_nac;
    }

    public function getCatedad() {
        return $this->Catedad;
    }

    public function getLicencia() {
        return $this->licencia;
    }

    public function getClub() {
        return $this->club;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setFech_nac($fech_nac): void {
        $this->fech_nac = $fech_nac;
        $this->Catedad = $this->calcularCategoriaEdad($fech_nac);

    }

    public function setCatedad($Catedad): void {
        $this->Catedad = $Catedad;
    }

    public function setLicencia($licencia): void {
        $this->licencia = $licencia;
    }

    public function setClub($club): void {
        $this->club = $club;
    }

    public function setPeso($peso): void {
        $this->peso = $peso;
    }

    public function setSexo($sexo): void {
        $this->sexo = $sexo;
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


