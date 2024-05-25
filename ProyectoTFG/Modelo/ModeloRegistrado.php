<?php
include_once 'ModeloBD.php';
include_once '../Clases/Competidor.php';
include_once '../Clases/Registrado.php';
include_once '../Clases/Torneo.php';

class ModeloRegistrado {
    private $modeloBD;

    public function __construct() {
        $this->modeloBD = new ModeloBD();
    }
    //Obtener los registros a los torneos de un competidor
    public function obtenerRegistrosPorDni($dniCompetidor) {
        $sql = "SELECT * FROM registrado WHERE dnicompetidor = '$dniCompetidor'";
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();

        $torneosRegistrados = array();
        if ($rows !== null) {
            foreach ($rows as $row) {
                $torneosRegistrados[] = new Registrado(
                    $row['idRegistro'],
                    $row['dnicompetidor'],
                    $row['idtorneo'],
                    $row['sexo'],
                    $row['peso'],
                    $row['edad'],
                    $row['modalidad']
                );
            }
        }
        return $torneosRegistrados;
    }
    //Contar registros en una categoría
    public function contarRegistrosPorModalidadYCompetidor($idTorneo, $competidor, $modalidad) {
        $sexo = $competidor->getSexo();
        $peso = $competidor->getPeso();
        $edad = $competidor->getCatedad();

        $sql = "SELECT COUNT(*) as total FROM registrado 
                WHERE idtorneo = '$idTorneo' AND 
                      sexo = '$sexo' AND 
                      peso = $peso AND 
                      edad = '$edad' AND 
                      modalidad = '$modalidad'";
        
        $this->modeloBD->open_connection();
        $this->modeloBD->get_results_from_query($sql);
        $rows = $this->modeloBD->get_rows();

        if ($rows !== null && count($rows) > 0) {
            return $rows[0]['total'];
        }
        return 0;
    }
    //Contar registros de fullcontact de una categoría
    public function contarFullContact($idTorneo, $competidor) {
        return $this->contarRegistrosPorModalidadYCompetidor($idTorneo, $competidor, 'fullcontact');
    }
    //Contar registros de lowkick de una categoría
    public function contarLowKick($idTorneo, $competidor) {
        return $this->contarRegistrosPorModalidadYCompetidor($idTorneo, $competidor, 'lowkick');
    } 
    
    
    //Insertar registro
    public function insertarRegistrado(Registrado $registrado) {
     
        $sql = "INSERT INTO registrado (dnicompetidor, idtorneo, sexo, peso, edad, modalidad) VALUES (" .
               "'" . $registrado->getDnicompetidor() . "', " .
               "'" . $registrado->getIdtorneo() . "', " .
               "'" . $registrado->getSexo() . "', " .
               $registrado->getPeso() . ", " .
               "'" . $registrado->getEdad() . "', " .
               "'" . $registrado->getModalidad() . "')";

        $this->modeloBD->open_connection();
        try {
            $this->modeloBD->execute_single_query($sql);
            return true; 
        } catch (Exception $e) {
            // Opcional: Manejar o registrar el error
            return false; 
        }
    }
    
    
    
 //Obtener lista de competidores registrados en una categoría en un torneo
   public function obtenerListaCompetidoresRegistrados($idTorneo, $peso, $sexo, $edad, $modalidad) {
    // Construcción de la consulta SQL utilizando concatenación de strings
    $sql = "SELECT c.* FROM registrado r " .
           "INNER JOIN competidores c ON r.dnicompetidor = c.dni " .
           "WHERE r.idtorneo = '" . $idTorneo .
           "' AND r.peso = '" . $peso .
           "' AND r.sexo = '" . $sexo .
           "' AND r.edad = '" . $edad .
           "' AND r.modalidad = '" . $modalidad . "'";

    // Ejecución de la consulta
    $this->modeloBD->get_results_from_query($sql);
    $rows = $this->modeloBD->get_rows();
    $competidores = array();
    
    // Comprobación de si existen filas y creación de objetos Competidor
    if ($rows !== null) {
        foreach ($rows as $row) {
            $competidor = new Competidor(
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
            $competidores[] = $competidor;
        }
    }
      error_log(var_export($competidores, true));

    return $competidores;
}
 //Obtener lista de competidores registrados en un torneo
    public function obtenerListaCompetidoresRegistradosTorneo($idTorneo) {
    $sql = "SELECT c.*, r.edad, r.modalidad, r.sexo AS sexoInscripcion, r.peso AS pesoInscripcion 
            FROM registrado r 
            INNER JOIN competidores c ON r.dnicompetidor = c.dni 
            WHERE r.idtorneo = '$idTorneo'";
    $this->modeloBD->open_connection();
    $this->modeloBD->get_results_from_query($sql);
    $listaCompetidores = array(); 
    $rows = $this->modeloBD->get_rows();
    if ($rows) {
        foreach ($rows as $row) {
            $competidor = new Competidor($row['dni'], $row['nombre'], $row['contrasena'], $row['correo'], $row['fech_nac'], $row['licencia'], $row['club'], $row['peso'], $row['sexo'], $row['estado'], $row['img']);
            $detallesInscripcion = [
                'edad' => $row['edad'],
                'modalidad' => $row['modalidad'],
                'sexoInscripcion' => $row['sexoInscripcion'],
                'pesoInscripcion' => $row['pesoInscripcion']
            ];   
            $listaCompetidores[] = [
                'competidor' => $competidor,
                'detallesInscripcion' => $detallesInscripcion
            ];
        }
    }
    return $listaCompetidores;
}
    //Eliminar registros de un torneo
    public function eliminarRegistradoPorTorneo(Torneo $torneo) {
        $idTorneo=$torneo->getIdtorneo();
        $sql = "DELETE FROM registrado WHERE idTorneo = '" . $idTorneo . "'";
        try {
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    //Eliminar competidor registrado en un torneo
    public function eliminarCompetidorRegistrado($dniCompetidor, $idTorneo, $modalidad) {
        $sql = "DELETE FROM registrado WHERE dnicompetidor = '$dniCompetidor' AND idtorneo = '$idTorneo' AND modalidad = '$modalidad'";
        $this->modeloBD->open_connection();
        try {
            // Ejecuta la consulta
            $this->modeloBD->execute_single_query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
}
