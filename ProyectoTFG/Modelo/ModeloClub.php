<?php
include_once 'ModeloBD.php';
include_once '../Clases/Club.php';

class ModeloClub {
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Obtener todos los clubes
    public function obtenerClubes() {
        $this->modeloBD->get_results_from_query("SELECT * FROM club");
        $listaClubes = array();
        
        foreach ($this->modeloBD->get_rows() as $row) {
            $listaClubes[] = new Club(
                $row['idclub'],
                $row['nombre'],
                $row['localidad'],
                $row['img'], 
                $row['latitud'], 
                $row['longitud'] 
            );
        }
        
        return $listaClubes;
    }
    //Obtener club por id
    public function obtenerClubPorId($idclub) {
        $sql = "SELECT * FROM club WHERE idclub = '$idclub'";
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        if (!empty($rows)) {
            $datos = $rows[0];
            $club = new Club(
                $datos['idclub'], 
                $datos['nombre'], 
                $datos['localidad'], 
                $datos['img'],
                $datos['latitud'], 
                $datos['longitud']
            ); 
            return $club;
        } else {
            return null;
        }
    }
    //Obtener club por nombre del club
    public function obtenerClubPorNombre($nombre) {
        $sql = "SELECT * FROM club WHERE nombre = '$nombre'";
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        
        if (!empty($rows)) {
            $datos = $rows[0];
            $club = new Club(
                $datos['idclub'], 
                $datos['nombre'], 
                $datos['localidad'], 
                $datos['img'], 
                $datos['latitud'], 
                $datos['longitud'] 
            ); 
            return $club;
        } else {
            return null;
        }
    }
    //Insertar club
    public function insertarClub(Club $club) {
        $insertarClub = "INSERT INTO club (nombre, localidad, img, latitud, longitud) VALUES ('" . 
                  $club->getNombre() . "', '" . 
                  $club->getLocalidad() . "', '" . 
                  $club->getImg() . "', " . 
                  (is_null($club->getLatitud()) ? "NULL" : "'" . $club->getLatitud() . "'") . ", " . 
                  (is_null($club->getLongitud()) ? "NULL" : "'" . $club->getLongitud() . "'") . ")";
        try {
            $this->modeloBD->execute_single_query($insertarClub);
            return true;
        } catch (Exception $e) {
            error_log("Error al insertar el club: " . $e->getMessage());
            return false;
        }
    }
    //Modificar club
    public function modificarClub(Club $club) {
        $sql = "UPDATE club SET " .
               "nombre = '" . $club->getNombre() . "', " .
               "localidad = '" . $club->getLocalidad() . "', " .
               "img = '" . $club->getImg() . "', " . 
               "latitud = '" . $club->getLatitud() . "', " . 
               "longitud = '" . $club->getLongitud() . "' " . 
               "WHERE idclub = '" . $club->getIdClub() . "'";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            error_log("Error al modificar el club: " . $e->getMessage());
            return false;
        }
    }
    //Eliminar club
    public function eliminarClub(Club $club) {
        $idClub=$club->getIdClub();
        $sql = "DELETE FROM club WHERE idclub = '$idClub'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            error_log("Error al eliminar el club: " . $e->getMessage());
            return false;
        }
    }     
}
