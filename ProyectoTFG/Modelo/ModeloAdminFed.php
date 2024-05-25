<?php
include_once 'ModeloBD.php';
include_once '../Clases/AdminFed.php';

class ModeloAdminFed{
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Comprobar credenciales del administrador de la federación
    public function verificarCredenciales($dni, $contrasena) {
        $sql = "SELECT dni FROM adminfed WHERE dni = '$dni' AND contrasena = '$contrasena' AND estado = 1";
        $this->modeloBD->get_results_from_query($sql);
        return $this->modeloBD->num_rows_cursor() == 1;
    }
    //Obtener administrador por DNI
    public function obtenerAdminFedPorDNI($dni) {
        $sql = "SELECT * FROM adminfed WHERE dni = '$dni'";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        if($rows !== null){
            if (count($rows) === 1){
                $datos = $rows[0];
                $adminFed = new AdminFed($datos['dni'], $datos['nombre'], $datos['contrasena'], $datos['correo'], $datos['estado']);
                return $adminFed;
            } else {
                return null;
            }
        }else{
            return null;
        } 
    }
    
    
    //Obtener todos los administradores
    public function obtenerAdminsFed() {
        $sql = "SELECT * FROM adminfed";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $listaAdminsFed = array();

        foreach ($this->modeloBD->get_rows() as $row) {
            $listaAdminsFed[] = new AdminFed(
                $row['dni'],
                $row['nombre'],
                $row['contrasena'],
                $row['correo'],
                $row['estado']
            );
        }

        return $listaAdminsFed;
    }
    //Modificar información del administrador
    public function modificarAdminFed(AdminFed $adminFed) {
        $sql = "UPDATE adminfed SET " .
               "nombre = '" . $adminFed->getNombre() . "', " .
               "contrasena = '" . $adminFed->getContrasena() . "', " .
               "correo = '" . $adminFed->getCorreo() . "', " .
               "estado = " . $adminFed->getEstado() .
               " WHERE dni = '" . $adminFed->getDni() . "'";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true; // Devuelve true si la actualización fue exitosa
        } catch (Exception $e) {
            return false; // Devuelve false si hubo un error
        }
    }

    
    //Insertar administrador de la federación
     public function insertarAdminFed(AdminFed $adminFed) {
        $insertarAdminFed = "INSERT INTO adminFed (dni, nombre, contrasena, correo, estado) VALUES ('" . 
                              $adminFed->getDni() . "', '" . 
                              $adminFed->getNombre() . "', '" . 
                              $adminFed->getContrasena() . "', '" . 
                              $adminFed->getCorreo() . "', " . 
                              $adminFed->getEstado() .")";
        
        
        try {
            $this->modeloBD->execute_single_query($insertarAdminFed);
            return true; // Devuelve true si la inserción fue exitosa
        } catch (Exception $e) {
            return false; // Devuelve false si hubo un error
        }
    }
     
    //Eliminar administrador de la federación
    public function eliminarAdminFed(AdminFed $adminFed) {
        $dni=$adminFed->getDni();
        $sql = "DELETE FROM adminfed WHERE dni = '$dni'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true; // Devuelve true si la eliminación fue exitosa
        } catch (Exception $e) {
            return false; // Devuelve false si hubo un error
        }
    }   
}

