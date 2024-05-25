<?php
class Torneo {
    public $idtorneo;
    public $fechainscripcion; 
    public $fechatorneo;
    public $descripcion;
    public $estado;
    public $finalizado;
    public $plazas; // Nueva propiedad


    public function __construct($idtorneo, $fechainscripcion, $fechatorneo, $descripcion, $estado, $finalizado, $plazas) {
        $this->idtorneo = $idtorneo;
        $this->fechainscripcion = $fechainscripcion;
        $this->fechatorneo = $fechatorneo;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->finalizado = $finalizado;
        $this->plazas = $plazas;
    }

    public function getIdtorneo() {
        return $this->idtorneo;
    }

    public function getFechatorneo() {
        return $this->fechatorneo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getFinalizado() {
        return $this->finalizado;
    }

    public function getFechaInscripcion() { 
        return $this->fechainscripcion;
    }
    public function getPlazas() {
        return $this->plazas;
    }
    public function setIdtorneo($idtorneo): void {
        $this->idtorneo = $idtorneo;
    }

    public function setFechatorneo($fechatorneo): void {
        $this->fechatorneo = $fechatorneo;
    }

    public function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }

    public function setFinalizado($finalizado): void {
        $this->finalizado = $finalizado;
    }

    public function setFechainscripcion($fechaInscripcion): void { 
        $this->fechaInscripcion = $fechaInscripcion;
    }
    public function setPlazas($plazas): void {
        $this->plazas = $plazas;
    }
}

