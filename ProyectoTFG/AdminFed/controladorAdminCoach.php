<?php
// Controlador para la gestión de coaches

include_once '../Modelo/ModeloCoach.php';
include_once '../Clases/Coach.php';

$coachModelo = new ModeloCoach();
if (isset($_POST['accion']) && $_POST['accion'] == 'mostrar') {
    // Maneja la acción 'mostrar' para obtener los datos de un coach

    $dni = $_POST['dni'];
    $coach = $coachModelo->obtenerCoachPorDNI($dni);
    echo json_encode($coach, JSON_FORCE_OBJECT);
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    // Maneja la acción 'editar' para modificar los datos de un coach

    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $club = $_POST['club'];
    $licencia = $_POST['licencia'];
    $estado = $_POST['estado'];
    $coach= $coachModelo->obtenerCoachPorDNI($dni);
    $coach->setNombre($nombre);
    $coach->setClub($club);
    $coach->setLicencia($licencia);
    $coach->setEstado($estado);
    $resultado = $coachModelo->modificarCoach($coach);
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    // Maneja la acción 'eliminar' para eliminar un coach

    $dni = $_POST['dni'];
    $coach= $coachModelo->obtenerCoachPorDNI($dni);
    $resultado = $coachModelo->eliminarCoach($coach);
}else{
    // Redirección a la página principal si no se ha enviado ninguna acción válida

    header("Location: ../index.php");
}
