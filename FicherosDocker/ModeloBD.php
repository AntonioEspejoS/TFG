<?php
class ModeloBD {
    private static $db_host = 'db';
    private static $db_user = 'root';
    private static $db_pass = '';
    protected $db_name = 'proyectotfg';
    protected $rows = array();
    private $conexion;
    #Constructor

    function __construct() {
    }
    # Conectar a la base de datos   
    public function open_connection() {
        $this->conexion = new mysqli(self::$db_host, self::$db_user, self::$db_pass, $this->db_name);
        $this->conexion->query("SET NAMES 'utf8'");
    }

    # Desconectar la base de datos
    public function close_connection() {
        $this->conexion->close();
    }
    # Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
    public function execute_single_query($query) {
        $this->open_connection();
        $this->conexion->query($query);
        $this->close_connection();
    }
    #Ejecutar una cosulta de insert y que me devuelva el id del insertado
   public function execute_insert_query($query) {
    $this->open_connection();
    $result = $this->conexion->query($query);
    if ($result === true) {
        // La inserción fue exitosa, obtener el último ID insertado
        $lastInsertedId = $this->conexion->insert_id;
        $this->close_connection();
        return $lastInsertedId; // Devolver el ID del último registro insertado
    } else {
        // La inserción falló, opcionalmente puedes manejar o registrar el error aquí
        $this->close_connection();
        return false;
    }
}
/*
Nueva para que no me vuelva a mandar lo de antes si está vacío
*/
public function get_results_from_query($query) {
    $this->open_connection();
    $result = $this->conexion->query($query);
    $this->rows = array(); // Asegurarse de que siempre se reinicia
    $hasResults = false; // Inicializa como falso
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $this->rows[] = $row;
            $hasResults = true; // Hay resultados, cambiar a verdadero
        }
        $result->close();
    }
    $this->close_connection();
    return $hasResults; // Devuelve true si hay resultados, false en caso contrario
}
/*
    # Almacenar resultados de una consulta en un Array
    public function get_results_from_query($query) {
        $this->open_connection();
        $result = $this->conexion->query($query);
        $filas = $result->num_rows;
        if($filas>0){
            //error_log("Hay resultados");
            // Vacío el array para que no se me acumulen los valores
            //unset($this->rows);
            $this->rows = array();
            for ($i = 0; $i < $filas; $i++) {
                $this->rows[] = $result->fetch_assoc();
            }
            if ($result != null){
                $result->close();
            }
            $this->close_connection();
            return true;
        }else{
            //error_log("No hay resultados");
            $this->close_connection();
            return false;
        }
    }
*/
    # Comprueba si el resultado de una consulta da alguna fila.
    public function exist_some_row($query) {
        $this->open_connection();
        $result = $this->conexion->query($query);
        $filas = $result->num_rows;
        $this->close_connection();
        if ($filas > 0){
            return true;
        }     
        return false;
    }

    #Devuelve el número de filas de la última consulta realizada

    public function num_rows_cursor() {
        if (isset($this->rows)){
            return count($this->rows); 
        }
        else{
          return 0;  
        } 
    }

    #Devuelve un array asociativo con las filas de la última consulta

    public function get_rows() {
        return $this->rows;
    }

}


