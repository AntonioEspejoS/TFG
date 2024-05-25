<?php
include_once 'ModeloBD.php';
include_once '../Clases/Coach.php';

class ModeloCoach{
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Comprobar credenciales del coach
    public function verificarCredenciales($dni, $contrasena) {
        $sql = "SELECT dni FROM coach WHERE dni = '$dni' AND contrasena = '$contrasena' AND estado = 1";
        $this->modeloBD->get_results_from_query($sql);
        return $this->modeloBD->num_rows_cursor() == 1;
    }
    //Obtener coach por DNI
    public function obtenerCoachPorDNI($dni) {
        $sql = "SELECT * FROM coach WHERE dni = '$dni'";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        if($rows !== null){
            if (count($rows) === 1){
                $datos = $rows[0];
                $coach = new Coach($datos['dni'], $datos['nombre'], $datos['contrasena'], $datos['correo'], $datos['club'], $datos['licencia'], $datos['estado'],$datos['img']);
                return $coach;
            } else {
                return null;
            }
        }else{
            return null;
        } 
    }
        //Obtener coaches por club
        public function obtenerCoachesPorClub($club) {
            $sql = "SELECT * FROM coach WHERE club = '$club'";
            $this->modeloBD->open_connection();
            $this->modeloBD->get_results_from_query($sql);
            $coaches = array();
            foreach ($this->modeloBD->get_rows() as $row) {
                $coaches[] = new Coach($row['dni'],$row['nombre'],$row['contrasena'],$row['correo'],$row['club'],$row['licencia'],$row['estado'],$row['img']);
            }
            return $coaches;
        }
        
        //Obtener todos los coaches
        public function obtenerCoaches() {
            $sql = "SELECT * FROM coach";
            $this->modeloBD->open_connection();
            $this->modeloBD->get_results_from_query($sql);
            $listaCoaches = array();
            foreach ($this->modeloBD->get_rows() as $row) {
                $listaCoaches[] = new Coach(
                    $row['dni'],
                    $row['nombre'],
                    $row['contrasena'],
                    $row['correo'],
                    $row['club'],
                    $row['licencia'],
                    $row['estado'],
                    $row['img']
                );
            }

            return $listaCoaches;
        }
        //Insertar coach
     public function insertarCoach(Coach $coach) {
        $insertarCoach = "INSERT INTO coach (dni, nombre, contrasena, correo, club, licencia, estado, img) VALUES ('" . 
                              $coach->getDni() . "', '" . 
                              $coach->getNombre() . "', '" . 
                              $coach->getContrasena() . "', '" . 
                              $coach->getCorreo() . "', '" . 
                              $coach->getClub() . "', " . 
                              $coach->getLicencia() . ", " . 
                              $coach->getEstado() . ", '" .
                              $coach->getImg() ."')";

        try {
            $this->modeloBD->execute_single_query($insertarCoach);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //Modificar coach
    public function modificarCoach(Coach $coach) {
        $sql = "UPDATE coach SET " .
               "nombre = '" . $coach->getNombre() . "', " .
               "contrasena = '" . $coach->getContrasena() . "', " .
               "correo = '" . $coach->getCorreo() . "', " .
               "club = '" . $coach->getClub() . "', " .
               "licencia = " . $coach->getLicencia() . ", " .
               "estado = " . $coach->getEstado() . ", " .
               "img = '" . $coach->getImg() . "' " .
               "WHERE dni = '" . $coach->getDni() . "'";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //Eliminar coach
    public function eliminarCoach(Coach $coach) {
        $dni=$coach->getDni();
        $sql = "DELETE FROM coach WHERE dni = '$dni'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true; 
        } catch (Exception $e) {
            return false; 
        }
    }


}

