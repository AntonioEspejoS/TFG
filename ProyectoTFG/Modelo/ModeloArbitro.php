<?php
include_once 'ModeloBD.php';
include_once '../Clases/Arbitro.php';

class ModeloArbitro{
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Comprobar credenciales del arbitro
    public function verificarCredenciales($dni, $contrasena) {
        $sql = "SELECT dni FROM arbitro WHERE dni = '$dni' AND contrasena = '$contrasena' AND estado = 1";
        $this->modeloBD->get_results_from_query($sql);
        return $this->modeloBD->num_rows_cursor() == 1;
    }
    //Obtener árbitro por DNI
        public function obtenerArbitroPorDNI($dni) {
        $sql = "SELECT * FROM arbitro WHERE dni = '$dni'";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        if($rows !== null){
            if (count($rows) === 1){
                $datos = $rows[0];
                $arbitro = new Arbitro($datos['dni'], $datos['nombre'], $datos['contrasena'], $datos['correo'], $datos['estado']);
                return $arbitro;
            } else {
                return null;
            }
        }else{
            return null;
        } 
    }
    
    //Obtener todos los árbitros
    public function obtenerArbitros() {
        $this->modeloBD->get_results_from_query("SELECT * FROM arbitro");
        $listaArbitros = array();
        
        foreach ($this->modeloBD->get_rows() as $row) {
            $listaArbitros[] = new Arbitro(
                $row['dni'],
                $row['nombre'],
                $row['contrasena'],
                $row['correo'],
                $row['estado']
            );
        }
        
        return $listaArbitros;
    }
    //Insertar árbitro
     public function insertarArbitro(Arbitro $arbitro) {
        $insertarArbitro = "INSERT INTO arbitro (dni, nombre, contrasena, correo, estado) VALUES ('" . 
                              $arbitro->getDni() . "', '" . 
                              $arbitro->getNombre() . "', '" . 
                              $arbitro->getContrasena() . "', '" . 
                              $arbitro->getCorreo() ."', ".$arbitro->getEstado() .")";
        
        
        try {
            $this->modeloBD->execute_single_query($insertarArbitro);
            return true; // Devuelve true si la inserción fue exitosa
        } catch (Exception $e) {
            return false; // Devuelve false si hubo un error
        }
    }
    //Modificar información del árbitro
    public function modificarArbitro(Arbitro $arbitro) {
        $sql = "UPDATE arbitro SET " .
               "nombre = '" . $arbitro->getNombre() . "', " .
               "contrasena = '" . $arbitro->getContrasena() . "', " .
               "correo = '" . $arbitro->getCorreo() . "', " .
               "estado = " . $arbitro->getEstado() .
               " WHERE dni = '" . $arbitro->getDni() . "'";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true; // Devuelve true si la actualización fue exitosa
        } catch (Exception $e) {
            return false; // Devuelve false si hubo un error
        }
    }
    //Eliminar árbitro
    public function eliminarArbitro(Arbitro $arbitro) {
        $dni=$arbitro->getDni();
        $sql = "DELETE FROM arbitro WHERE dni = '$dni'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true; // Devuelve true si la eliminación fue exitosa
        } catch (Exception $e) {
            return false; // Devuelve false si hubo un error
        }
    }

}

