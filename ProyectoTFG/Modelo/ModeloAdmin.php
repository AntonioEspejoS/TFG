<?php
include_once 'ModeloBD.php';
include_once '../Clases/Admin.php';

class ModeloAdmin{
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Comprobar credenciales del administrador del sistema
    public function verificarCredenciales($dni, $contrasena) {
        $sql = "SELECT dni FROM admin WHERE dni = '$dni' AND contrasena = '$contrasena'";
        $this->modeloBD->get_results_from_query($sql);
        return $this->modeloBD->num_rows_cursor() == 1;
    }
    //Obtener administrador por DNI
    public function obtenerAdminPorDNI($dni) {
        $sql = "SELECT * FROM admin WHERE dni = '$dni'";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();
        if($rows !== null){
            if (count($rows) === 1){
                $datos = $rows[0];
                $admin = new Admin($datos['dni'], $datos['nombre'], $datos['contrasena'], $datos['correo']);
                return $admin;
            } else {
                return null;
            }
        }else{
            return null;
        } 
    }
    
    //Modificar información del administrador del sistema
    public function modificarAdmin(Admin $admin) {
            error_log(var_export($admin,true));
        $sql = "UPDATE admin SET " .
               "nombre = '" . $admin->getNombre() . "', " .
               "contrasena = '" . $admin->getContrasena() . "', " .
               "correo = '" . $admin->getCorreo()  . "' " . 
               " WHERE dni = '" . $admin->getDni() . "'";

        try {
            $this->modeloBD->execute_single_query($sql);
            return true; // Devuelve true si la actualización fue exitosa
        } catch (Exception $e) {
            return false; // Devuelve false si hubo un error
        }
    }
  
}

