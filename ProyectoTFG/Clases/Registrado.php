<?php
class Registrado {
    public $idRegistro;
    public $dnicompetidor;
    public $idtorneo;
    public $sexo;
    public $peso;
    public $edad;
    public $modalidad;

    public function __construct($idRegistro, $dnicompetidor, $idtorneo, $sexo, $peso, $edad, $modalidad) {
        $this->idRegistro = $idRegistro;
        $this->dnicompetidor = $dnicompetidor;
        $this->idtorneo = $idtorneo;
        $this->sexo = $sexo;
        $this->peso = $peso;
        $this->edad = $edad;
        $this->modalidad = $modalidad;
    }
    public function getIdRegistro() {
        return $this->idRegistro;
    }

    public function getDnicompetidor() {
        return $this->dnicompetidor;
    }

    public function getIdtorneo() {
        return $this->idtorneo;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function getEdad() {
        return $this->edad;
    }

    public function getModalidad() {
        return $this->modalidad;
    }

    public function setIdRegistro($idRegistro): void {
        $this->idRegistro = $idRegistro;
    }

    public function setDnicompetidor($dnicompetidor): void {
        $this->dnicompetidor = $dnicompetidor;
    }

    public function setIdtorneo($idtorneo): void {
        $this->idtorneo = $idtorneo;
    }

    public function setSexo($sexo): void {
        $this->sexo = $sexo;
    }

    public function setPeso($peso): void {
        $this->peso = $peso;
    }

    public function setEdad($edad): void {
        $this->edad = $edad;
    }

    public function setModalidad($modalidad): void {
        $this->modalidad = $modalidad;
    }


}
