<?php
include_once 'ModeloBD.php';
include_once '../Clases/Torneo.php';

class ModeloTorneo {
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Obtener torneo por id
    public function obtenerTorneoPorId($idtorneo) {
        $sql = "SELECT * FROM torneo WHERE idtorneo = '$idtorneo'";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();

        if ($rows !== null && count($rows) === 1) {
            $datos = $rows[0];
            $torneo = new Torneo(
                $datos['idtorneo'],
                $datos['fechainscripcion'],
                $datos['fechatorneo'],
                $datos['descripcion'],
                $datos['estado'],
                $datos['finalizado'],
                $datos['plazas'] 
            );
            return $torneo;
        } else {
            return null;
        }
    }  
    
    //Obtener todos los torneos
    public function obtenerTorneos() {
        $sql = "SELECT * FROM torneo";
        $this->modeloBD->open_connection();
        $listaTorneos = array();
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            foreach ($rows as $row) {
                $listaTorneos[] = new Torneo(
                    $row['idtorneo'],
                    $row['fechainscripcion'],
                    $row['fechatorneo'],
                    $row['descripcion'],
                    $row['estado'],
                    $row['finalizado'],
                    $row['plazas'] 
                );
            }
        }
        return $listaTorneos;
    }
    //Obtener torneos no finalizados
    public function obtenerTorneosNoFinalizados() {
        $sql = "SELECT * FROM torneo WHERE finalizado = 0";
        $this->modeloBD->open_connection();
        $listaTorneos = array();
        if ($this->modeloBD->get_results_from_query($sql)) {
            $rows = $this->modeloBD->get_rows();
            foreach ($rows as $row) {
                $listaTorneos[] = new Torneo(
                    $row['idtorneo'],
                    $row['fechainscripcion'],
                    $row['fechatorneo'],
                    $row['descripcion'],
                    $row['estado'],
                    $row['finalizado'],
                    $row['plazas']
                );
            }
        }
        return $listaTorneos;
    }
    //Insertar torneo
    public function insertarTorneo(Torneo $torneo) {
        $sql = "INSERT INTO torneo (fechainscripcion, fechatorneo, descripcion, estado, finalizado, plazas) VALUES ('" .
               $torneo->getFechaInscripcion() . "', '" .
               $torneo->getFechatorneo() . "', '" .
               $torneo->getDescripcion() . "', " .
               $torneo->getEstado() . ", " .
               $torneo->getFinalizado() . ", " .
               $torneo->getPlazas() . ")";

        $lastInsertedId = $this->modeloBD->execute_insert_query($sql);
        if ($lastInsertedId !== false) {
            return $lastInsertedId; // Devolver el ID del torneo insertado
        } else {
            return false; // Devolver false en caso de error
        }
    }
    //Modificar torneo
    public function modificarTorneo(Torneo $torneo) {
        $sql = "UPDATE torneo SET " .
               "fechainscripcion = '" . $torneo->getFechaInscripcion() . "', " .
               "fechatorneo = '" . $torneo->getFechatorneo() . "', " .
               "descripcion = '" . $torneo->getDescripcion() . "', " .
               "estado = " . $torneo->getEstado() . ", " .
               "finalizado = " . $torneo->getFinalizado() . ", " .
               "plazas = " . $torneo->getPlazas() . " WHERE idtorneo = '" . $torneo->getIdtorneo() . "'";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    //Eliminar torneo
    public function eliminarTorneo(Torneo $torneo) {
        $idtorneo=$torneo->getIdtorneo();
        $sql = "DELETE FROM torneo WHERE idtorneo = '$idtorneo'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
