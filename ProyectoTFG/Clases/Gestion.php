<?php
class Gestion {
    public $idGestion;
    public $idTorneo;
    public $dniArbitro;

    // Constructor de la clase
    public function __construct($idGestion, $idTorneo, $dniArbitro) {
        $this->idGestion = $idGestion;
        $this->idTorneo = $idTorneo;
        $this->dniArbitro = $dniArbitro;
    }
    
    public function getIdGestion() {
        return $this->idGestion;
    }

    public function getIdTorneo() {
        return $this->idTorneo;
    }

    public function getDniArbitro() {
        return $this->dniArbitro;
    }

    public function setIdGestion($idGestion): void {
        $this->idGestion = $idGestion;
    }

    public function setIdTorneo($idTorneo): void {
        $this->idTorneo = $idTorneo;
    }

    public function setDniArbitro($dniArbitro): void {
        $this->dniArbitro = $dniArbitro;
    }


}    