<?php
include_once 'ModeloBD.php';
include_once '../Clases/Gestion.php';
include_once '../Clases/Torneo.php';

class ModeloGestion {
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Obtener gestión por id
    public function obtenerGestionPorId($idGestion) {
        $sql = "SELECT * FROM gestion WHERE idGestion = '$idGestion'";
        $this->modeloBD->open_connection();
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            if ($rows !== null && count($rows) === 1) {
                $datos = $rows[0];
                $gestion = new Gestion(
                    $datos['idGestion'],
                    $datos['idTorneo'],
                    $datos['dniArbitro']
                );
                return $gestion;
            }
        }
        return null;
    }
    //Obtener gestiones por torneo
    public function obtenerGestionesPorIdTorneo(Torneo $torneo) {
        $idTorneo=$torneo->getIdtorneo();
        $sql = "SELECT * FROM gestion WHERE idTorneo = '$idTorneo'";
        $this->modeloBD->open_connection();
        $gestiones = array();
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            foreach ($rows as $row) {
                $gestiones[] = new Gestion(
                    $row['idGestion'],
                    $row['idTorneo'],
                    $row['dniArbitro']
                );
            }
        }
        return $gestiones;
    }
    //Obtener gestión por torneo y por árbitro
    public function obtenerGestionPorDniIdTorneo($idTorneo, $dniArbitro) {
    $sql = "SELECT * FROM gestion WHERE idTorneo = '$idTorneo' AND dniArbitro = '$dniArbitro'";
    $this->modeloBD->open_connection();
    if ($this->modeloBD->get_results_from_query($sql)) {
        $rows = $this->modeloBD->get_rows();
        if (!empty($rows)) {
            $datos = $rows[0];
            $gestion = new Gestion(
                $datos['idGestion'],
                $datos['idTorneo'],
                $datos['dniArbitro']
            );
            return $gestion;
        }
    }
    return null;
}

    
    
    
    
    //Comprobar si hay gestion de un torneo por un árbitro
    public function existeGestion($idTorneo, $dniArbitro) {
        $sql = "SELECT COUNT(*) as count FROM gestion WHERE idTorneo = '$idTorneo' AND dniArbitro = '$dniArbitro'";
        $this->modeloBD->open_connection();
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            if (!empty($rows)) {
                $count = $rows[0]['count'];
                return $count > 0;
            }
        }
        return false;
    }
    //Insertar gestión
    public function insertarGestion(Gestion $gestion) {
        $sql = "INSERT INTO gestion (idTorneo, dniArbitro) VALUES ('" .
               $gestion->getIdTorneo() . "', '" .
               $gestion->getDniArbitro() . "')";

        $lastInsertedId = $this->modeloBD->execute_insert_query($sql);
        return $lastInsertedId !== false ? $lastInsertedId : false;
    }
    //Eliminar una gestion
    public function eliminarGestion(Gestion $gestion) {
        // Utilizar las propiedades del objeto Gestion para la consulta
        $idGestion = $gestion->getIdGestion();

        $sql = "DELETE FROM gestion WHERE idGestion = '$idGestion'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

