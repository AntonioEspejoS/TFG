<?php
// Controlador para la gestión de clubes
include_once '../Modelo/ModeloClub.php';
include_once '../Modelo/ModeloCompetidor.php';
include_once '../Modelo/ModeloCoach.php';
include_once '../Clases/Club.php';

$modeloClub = new ModeloClub();
$modeloCompetidor = new ModeloCompetidor();
$modeloCoach = new ModeloCoach();
if (isset($_POST['accion']) && $_POST['accion'] == 'mostrar') {
    // Maneja la acción 'mostrar' para obtener los datos de un club

    $idClub=$_POST['idClub'];
    $club = $modeloClub->obtenerClubPorId($idClub);
    echo json_encode($club, JSON_FORCE_OBJECT);
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    // Maneja la acción 'editar' para modificar los datos de un club

    $idClub=$_POST['idClub'];
    $localidad=$_POST['localidad'];
    $nombre=$_POST['nombre'];
    $club = $modeloClub->obtenerClubPorId($idClub);
    $club->setNombre($nombre);
    $club->setLocalidad($localidad);  
    //error_log(var_export($club, true));
    $resultado = $modeloClub->modificarClub($club);       
} else if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    // Maneja la acción 'eliminar' para eliminar un club y sus miembros

    $idClub=$_POST['idClub'];
    // Obtenemos los competidores del club y los eliminamos
    $competidores = $modeloCompetidor->obtenerCompetidoresPorClub($idClub);
    foreach ($competidores as $competidor) {
        $modeloCompetidor->eliminarCompetidor($competidor);
    }
    // Obtenemos los coaches del club y los eliminamos
    $coaches = $modeloCoach->obtenerCoachesPorClub($idClub);
    foreach ($coaches as $coach) {
        $modeloCoach->eliminarCoach($coach);
    }
    // Eliminar el club
    $club = $modeloClub->obtenerClubPorId($idClub);
    $resultado = $modeloClub->eliminarClub($club); 
}else{
    // Redirección a la página principal si no se ha enviado ninguna acción válida

    header("Location: ../index.php");
}