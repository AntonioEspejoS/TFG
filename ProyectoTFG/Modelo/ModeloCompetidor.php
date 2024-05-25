<?php
include_once 'ModeloBD.php';
include_once '../Clases/Competidor.php';

class ModeloCompetidor {
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Comprobar credenciales del competidor
    public function verificarCredenciales($dni, $contrasena) {
        $sql = "SELECT dni FROM competidores WHERE dni = '$dni' AND contrasena = '$contrasena' AND estado = 3";
        $this->modeloBD->get_results_from_query($sql);
        return $this->modeloBD->num_rows_cursor() == 1;
    }
    //Obtener competidor por DNI
    public function obtenerCompetidorPorDNI($dni) {
        $sql = "SELECT * FROM competidores WHERE dni = '$dni'";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        if($rows !== null){
            if (count($rows) === 1){
                $datos = $rows[0];
                $competidor = new Competidor($datos['dni'],$datos['nombre'],$datos['contrasena'],$datos['correo'],$datos['fech_nac'],$datos['licencia'],$datos['club'],$datos['peso'],$datos['sexo'],$datos['estado'],$datos['img']);
                //error_log(print_r($competidor, true));
                return $competidor; 
            } else {
                return null;
            } 
        }else{
            return null;
        }
           
    }

    //Obtener competidores por club
    public function obtenerCompetidoresPorClub($nombreClub) {
        $sql = "SELECT * FROM competidores WHERE club = '$nombreClub'";
        $this->modeloBD->get_results_from_query($sql);
        $competidores = array();
        foreach ($this->modeloBD->get_rows() as $row) {
            $competidores[] = new Competidor($row['dni'],$row['nombre'],$row['contrasena'],$row['correo'],$row['fech_nac'],$row['licencia'],$row['club'],$row['peso'],$row['sexo'],$row['estado'],$row['img'] 
            );
        }
        return $competidores;
    }

    //Obtener todos los competidores
    public function obtenerCompetidores() {
        $sql = "SELECT * FROM competidores";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $listaCompetidores = array();

        foreach ($this->modeloBD->get_rows() as $row) {
            $listaCompetidores[] = new Competidor(
                $row['dni'],
                $row['nombre'],
                $row['contrasena'],
                $row['correo'],
                $row['fech_nac'],
                $row['licencia'],
                $row['club'],
                $row['peso'],
                $row['sexo'],
                $row['estado'],
                $row['img'] 
            );
        }

        return $listaCompetidores;
    }

    
    
    //Insertar competidor
    public function insertarCompetidor(Competidor $competidor) {
        error_log(var_export($competidor,true));
        $insertarCompetidor = "INSERT INTO competidores (dni, nombre, contrasena, correo, fech_nac, Catedad, licencia, club, peso, sexo, estado, img) VALUES (" . 
                              "'" . $competidor->getDni() . "', " . 
                              "'" . $competidor->getNombre() . "', " . 
                              "'" . $competidor->getContrasena() . "', " . 
                              "'" . $competidor->getCorreo() . "', " . 
                              "'" . $competidor->getFech_nac() . "', " . 
                              "'" . $competidor->getCatedad() . "', " . 
                              $competidor->getLicencia() . ", " . 
                              "'" . $competidor->getClub() . "', " . 
                              $competidor->getPeso() . ", " . 
                              "'" . $competidor->getSexo() . "', " . 
                              $competidor->getEstado() . ", " . 
                              "'" . $competidor->getImg() . "')";
        try {
            $this->modeloBD->execute_single_query($insertarCompetidor);
            return true; // Devuelve true si la inserción fue exitosa
        } catch (Exception $e) {
            error_log(var_export($e,true));
            return false; // Devuelve false si hubo un error
        }
    }
    
    //Modificar competidor
    public function modificarCompetidor(Competidor $competidor) {
        error_log(var_export($competidor,true));
        $sql = "UPDATE competidores SET " .
                "nombre = '" . $competidor->getNombre() . "', " .
                "contrasena = '" . $competidor->getContrasena() . "', " .
                "correo = '" . $competidor->getCorreo() . "', " .
                "fech_nac = '" . $competidor->getFech_nac() . "', " .
                "Catedad = '" . $competidor->getCatedad() . "', " .
                "licencia = " . $competidor->getLicencia() . ", " . 
                "club = '" . $competidor->getClub() . "', " .
                "peso = " . $competidor->getPeso() . ", " . 
                "sexo = '" . $competidor->getSexo() . "', " .
                "estado = " . $competidor->getEstado() . ", " . 
                "img = '" . $competidor->getImg() . "' " . 
                "WHERE dni = '" . $competidor->getDni() . "'";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true; // Devuelve true si la actualización fue exitosa
        } catch (Exception $e) {
                                error_log(var_export($e,true));

            return false; // Devuelve false si hubo un error
        }
     }

     //Eliminar competidor
    public function eliminarCompetidor(Competidor $competidor) {
        $dni=$competidor->getDni();
        $sql = "DELETE FROM competidores WHERE dni = '$dni'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true; // Devuelve true si la eliminación fue exitosa
        } catch (Exception $e) {
            return false; // Devuelve false si hubo un error
        }
    }

    
    
}
