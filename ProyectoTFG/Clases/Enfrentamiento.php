<?php
class Enfrentamiento {
    public $idEnfrentamiento;
    public $dni1;
    public $dni2;
    public $puntos1;
    public $puntos2;
    public $ronda;
    public $idTorneo;
    public $peso; 
    public $sexo;
    public $edad;
    public $modalidad;

    public function __construct($idEnfrentamiento, $dni1, $dni2, $puntos1, $puntos2, $ronda, $idTorneo, $peso, $sexo, $edad, $modalidad) {
        $this->idEnfrentamiento = $idEnfrentamiento;
        $this->dni1 = $dni1;
        $this->dni2 = $dni2;
        $this->puntos1 = $puntos1;
        $this->puntos2 = $puntos2;
        $this->ronda = $ronda;
        $this->idTorneo = $idTorneo;
        $this->peso = $peso;
        $this->sexo = $sexo;
        $this->edad = $edad;
        $this->modalidad = $modalidad;
    }
    public function getIdEnfrentamiento() {
        return $this->idEnfrentamiento;
    }

    public function getDni1() {
        return $this->dni1;
    }

    public function getDni2() {
        return $this->dni2;
    }

    public function getPuntos1() {
        return $this->puntos1;
    }

    public function getPuntos2() {
        return $this->puntos2;
    }

    public function getRonda() {
        return $this->ronda;
    }

    public function getIdTorneo() {
        return $this->idTorneo;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getEdad() {
        return $this->edad;
    }

    public function getModalidad() {
        return $this->modalidad;
    }

    public function setIdEnfrentamiento($idEnfrentamiento): void {
        $this->idEnfrentamiento = $idEnfrentamiento;
    }

    public function setDni1($dni1): void {
        $this->dni1 = $dni1;
    }

    public function setDni2($dni2): void {
        $this->dni2 = $dni2;
    }

    public function setPuntos1($puntos1): void {
        $this->puntos1 = $puntos1;
    }

    public function setPuntos2($puntos2): void {
        $this->puntos2 = $puntos2;
    }

    public function setRonda($ronda): void {
        $this->ronda = $ronda;
    }

    public function setIdTorneo($idTorneo): void {
        $this->idTorneo = $idTorneo;
    }

    public function setPeso($peso): void {
        $this->peso = $peso;
    }

    public function setSexo($sexo): void {
        $this->sexo = $sexo;
    }

    public function setEdad($edad): void {
        $this->edad = $edad;
    }

    public function setModalidad($modalidad): void {
        $this->modalidad = $modalidad;
    }
}
