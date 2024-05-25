<?php
include_once 'ModeloBD.php';
include_once '../Clases/Enfrentamiento.php';
include_once '../Clases/Torneo.php';

class ModeloEnfrentamiento {
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Insertar enfrentamiento 
    public function insertarEnfrentamiento(Enfrentamiento $enfrentamiento) {
        $dni1 = "NULL";
        $dni2 = "NULL";
        $puntos1 = "NULL";
        $puntos2 = "NULL";
        if ($enfrentamiento->getDni1() !== null) {
            $dni1 = "'" . $enfrentamiento->getDni1() . "'";
        }
        if ($enfrentamiento->getDni2() !== null) {
            $dni2 = "'" . $enfrentamiento->getDni2() . "'";
        }
        if ($enfrentamiento->getPuntos1() !== null) {
            $puntos1 = $enfrentamiento->getPuntos1();
        }
        if ($enfrentamiento->getPuntos2() !== null) {
            $puntos2 = $enfrentamiento->getPuntos2();
        }
        
        $sql = "INSERT INTO enfrentamiento (dni1, dni2, puntos1, puntos2, ronda, idTorneo, peso, sexo, edad, modalidad) VALUES (" .
                $dni1 . ", " .
                $dni2 . ", " .
                $puntos1 . ", " .
                $puntos2 . ", " .
                $enfrentamiento->getRonda() . ", " .
                $enfrentamiento->getIdTorneo() . ", " .
                "'" . $enfrentamiento->getPeso() . "', " .
                "'" . $enfrentamiento->getSexo() . "', " .
                "'" . $enfrentamiento->getEdad() . "', " .
                "'" . $enfrentamiento->getModalidad() . "')";
             error_log(var_export($enfrentamiento->getPuntos1(), true));

        try {
            $this->modeloBD->execute_single_query($sql);
            return true; 
        } catch (Exception $e) {
            // Manejo de errores
            return false;
        }
    }
    //Obtener todos los enfrentamientos
    public function obtenerEnfrentamientos() {
        $sql = "SELECT * FROM enfrentamiento";
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        $enfrentamientos = array();

        if ($rows !== null) {
            foreach ($rows as $row) {
                $enfrentamientos[] = new Enfrentamiento($row['idEnfrentamiento'], $row['dni1'], $row['dni2'], $row['puntos1'], $row['puntos2'], $row['ronda'], $row['idTorneo'], $row['peso'], $row['sexo'], $row['edad'], $row['modalidad']);
            }
        }
        return $enfrentamientos;
    }
    
    //Obtener los enfrentamientos de una categoría en concreto
    public function obtenerEnfrentamientosPorCriterios($idTorneo, $modalidad, $edad, $peso, $sexo) {
        $sql = "SELECT * FROM enfrentamiento WHERE idTorneo = '" . $idTorneo . 
               "' AND modalidad = '" . $modalidad . 
               "' AND edad = '" . $edad . 
               "' AND peso = '" . $peso . 
               "' AND sexo = '" . $sexo . "'";
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        $enfrentamientos = array();
        if ($rows !== null) {
            foreach ($rows as $row) {
                $enfrentamientos[] = new Enfrentamiento($row['idEnfrentamiento'], $row['dni1'], $row['dni2'], $row['puntos1'], $row['puntos2'], $row['ronda'], $row['idTorneo'], $row['peso'], $row['sexo'], $row['edad'], $row['modalidad']);
            }
        }
        return $enfrentamientos;
    }
        //Obtener los enfrentamientos de una categoría en concreto
    public function obtenerEnfrentamientosPorCriteriosAvanzados($idTorneo, $modalidad, $edad, $peso, $sexo, $dni1 = null, $dni2 = null, $ronda = null) {
        $sql = "SELECT * FROM enfrentamiento WHERE idTorneo = '" . $idTorneo . 
               "' AND modalidad = '" . $modalidad . 
               "' AND edad = '" . $edad . 
               "' AND peso = '" . $peso . 
               "' AND sexo = '" . $sexo . "'";

        // Añadir criterios adicionales si están presentes
        if ($dni1 !== null) {
            $sql .= " AND dni1 = '" . $dni1 . "'";
        }
        if ($dni2 !== null) {
            $sql .= " AND dni2 = '" . $dni2 . "'";
        }
        if ($ronda !== null) {
            $sql .= " AND ronda = '" . $ronda . "'";
        }

        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        error_log(var_export($rows, true));
        $enfrentamientos = array();
        if ($rows !== null) {
            foreach ($rows as $row) {
                $enfrentamientos[] = new Enfrentamiento($row['idEnfrentamiento'], $row['dni1'], $row['dni2'], $row['puntos1'], $row['puntos2'], $row['ronda'], $row['idTorneo'], $row['peso'], $row['sexo'], $row['edad'], $row['modalidad']);
            }
        }
        return $enfrentamientos;
    }

    //Modificar enfrentamiento
    public function modificarEnfrentamiento(Enfrentamiento $enfrentamiento) {
        $dni1 = $enfrentamiento->getDni1() !== null ? "'" . $enfrentamiento->getDni1() . "'" : "NULL";
        $dni2 = $enfrentamiento->getDni2() !== null ? "'" . $enfrentamiento->getDni2() . "'" : "NULL";
        $puntos1 = $enfrentamiento->getPuntos1() !== null ? $enfrentamiento->getPuntos1() : "NULL";
        $puntos2 = $enfrentamiento->getPuntos2() !== null ? $enfrentamiento->getPuntos2() : "NULL";
        $ronda = $enfrentamiento->getRonda();
        $idTorneo = $enfrentamiento->getIdTorneo();
        $peso = "'" . $enfrentamiento->getPeso() . "'";
        $sexo = "'" . $enfrentamiento->getSexo() . "'";
        $edad = "'" . $enfrentamiento->getEdad() . "'";
        $modalidad = "'" . $enfrentamiento->getModalidad() . "'";
        $idEnfrentamiento = $enfrentamiento->getIdEnfrentamiento();

        $sql = "UPDATE enfrentamiento SET dni1 = " . $dni1 . ", dni2 = " . $dni2 . ", puntos1 = " . $puntos1 . ", puntos2 = " . $puntos2 . 
               ", ronda = " . $ronda . ", idTorneo = " . $idTorneo . ", peso = " . $peso . ", sexo = " . $sexo . 
               ", edad = " . $edad . ", modalidad = " . $modalidad . " WHERE idEnfrentamiento = " . $idEnfrentamiento;

        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            error_log("Error al modificar el enfrentamiento: " . $e->getMessage());
            return false;
        }
    }

    
    //Eliminar enfrentamiento
    public function eliminarEnfrentamiento(Enfrentamiento $enfrentamiento) {
        $idEnfrentamiento=$enfrentamiento->getIdEnfrentamiento();
        $sql = "DELETE FROM enfrentamiento WHERE idEnfrentamiento = $idEnfrentamiento";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            // Manejo de errores
            return false;
        }
    }
    
    //Eliminar todos los enfrentamientos de un torneo
    public function eliminarEnfrentamientoPorTorneo(Torneo $torneo) {
        $idTorneo=$torneo->getIdtorneo();
        $sql = "DELETE FROM enfrentamiento WHERE idTorneo = '" . $idTorneo . "'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            // Manejo de errores
            return false;
        }
    }
    //Eliminar un enfrentamiento en el cual se ha cambiado la pelea de un adversario
    public function eliminarEnfrentamientosPorDNIs($idTorneo, $modalidad, $edad, $peso, $sexo, $dni1, $dni2, $ronda) {
    $sql = "DELETE FROM enfrentamiento WHERE idTorneo = '" . $idTorneo . 
           "' AND modalidad = '" . $modalidad . 
           "' AND edad = '" . $edad . 
           "' AND peso = '" . $peso . 
           "' AND sexo = '" . $sexo . 
           "' AND ronda = '" . $ronda . 
           "' AND (dni1 = '" . $dni1 . "' OR dni1 = '" . $dni2 . 
           "' OR dni2 = '" . $dni1 . "' OR dni2 = '" . $dni2 . "')";

     try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            // Manejo de errores
            return false;
        }
}

}
