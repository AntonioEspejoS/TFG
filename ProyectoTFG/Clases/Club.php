<?php

class Club {
    public $idclub;
    public $nombre;
    public $localidad;
    public $img;
    public $latitud; 
    public $longitud; 

    public function __construct($idclub, $nombre, $localidad, $img, $latitud = null, $longitud = null) {
        $this->idclub = $idclub;
        $this->nombre = $nombre;
        $this->localidad = $localidad;
        $this->img = $img;
        $this->latitud = $latitud; 
        $this->longitud = $longitud; 
    }
    public function getIdclub() {
        return $this->idclub;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getLocalidad() {
        return $this->localidad;
    }

    public function getImg() {
        return $this->img;
    }

    public function setIdclub($idclub): void {
        $this->idclub = $idclub;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setLocalidad($localidad): void {
        $this->localidad = $localidad;
    }

    public function setImg($img): void {
        $this->img = $img;
    }
    public function getLatitud() {
        return $this->latitud;
    }

    public function getLongitud() {
        return $this->longitud;
    }

    public function setLatitud($latitud): void {
        $this->latitud = $latitud;
    }

    public function setLongitud($longitud): void {
        $this->longitud = $longitud;
    }



}
