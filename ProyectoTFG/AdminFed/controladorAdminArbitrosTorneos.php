<?php
// Controlador para la gestión de árbitros asociados a torneos
include_once '../Modelo/ModeloTorneo.php';
include_once '../Modelo/ModeloArbitro.php';
include_once '../Modelo/ModeloGestion.php';


$torneoModelo = new ModeloTorneo();
if (isset($_POST['accion']) && $_POST['accion'] == 'mostrar') {
    // Maneja la acción 'mostrar' para obtener árbitros no gestionados
    $idTorneo = $_POST['idTorneo'];
    error_log(print_r($idTorneo, true));
    $modeloGestion = new ModeloGestion();
    $modeloTorneo=new ModeloTorneo();
    $torneo=$modeloTorneo->obtenerTorneoPorId($idTorneo);
    $gestiones = $modeloGestion->obtenerGestionesPorIdTorneo($torneo);
    $modeloArbitro = new ModeloArbitro();
    $arbitros = $modeloArbitro->obtenerArbitros();
    $arbitrosNoGestionan = [];

    // Crear un array de DNI de árbitros que ya están en gestiones para el torneo
    $dnisEnGestiones = [];
    foreach ($gestiones as $gestion) {
        $dnisEnGestiones[] = $gestion->getDniArbitro();
    }
    // Verificar cada árbitro para ver si su DNI está en el array de DNI en gestiones
    foreach ($arbitros as $arbitro) {
        if (!in_array($arbitro->getDni(), $dnisEnGestiones)) {
            // Si el árbitro no está en gestiones, agregarlo al array de árbitros no gestionan
            if($arbitro->getEstado()==1){
                            $arbitrosNoGestionan[] = $arbitro;
            }
        }
    }
    // Devolver los árbitros que no están en gestiones como JSON
    error_log(print_r($arbitrosNoGestionan, true));
    echo json_encode($arbitrosNoGestionan, JSON_FORCE_OBJECT);
    
}  else if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    // Maneja la acción 'eliminar' para eliminar un árbitro de un torneo
    $dni=$_POST['dni'];
    $idTorneo=$_POST['idTorneo'];
    include_once '../Modelo/ModeloGestion.php';

    //Eliminar los arbitros del torneo
    $modeloGestion = new ModeloGestion();
    $gestion=$modeloGestion->obtenerGestionPorDniIdTorneo($idTorneo, $dni);
    $resultado = $modeloGestion->eliminarGestion($gestion);      
    
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'insertar') {
// Maneja la acción 'insertar' para añadir un árbitro a un torneo
    
    $dniArbitro = $_POST['dniArbitro'];
    $idTorneo = $_POST['idTorneo'];
    $modeloGestion = new ModeloGestion();
       if (empty($dniArbitro) || empty($idTorneo)) {
        exit; 
    }
    // Verificar si ya existe una gestión con ese DNI de árbitro para el torneo especificado
    if (!$modeloGestion->existeGestion($idTorneo, $dniArbitro)) {
        // Si no existe, insertar la nueva gestión
        $gestion = new Gestion(null, $idTorneo, $dniArbitro); 
        $resultado = $modeloGestion->insertarGestion($gestion);
    }
}else{
    // Redirecciona a la página principal si no se ha enviado ninguna acción válida
    
    header("Location: ../index.php");
}
    
    
    
    
    
    
    
