<?php
class Categoria {
    public $idCategoria;
    public $idtorneo;
    public $sexo;
    public $peso;
    public $edad;
    public $modalidad;
    public $estado;

    public function __construct($idCategoria, $idtorneo, $sexo, $peso, $edad, $modalidad, $estado) {
        $this->idCategoria = $idCategoria;
        $this->idtorneo = $idtorneo;
        $this->sexo = $sexo;
        $this->peso = $peso;
        $this->edad = $edad;
        $this->modalidad = $modalidad;
        $this->estado = $estado;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
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

    public function getEstado() {
        return $this->estado;
    }

    public function setIdCategoria($idCategoria): void {
        $this->idCategoria = $idCategoria;
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

    public function setEstado($estado): void {
        $this->estado = $estado;
    }


}
