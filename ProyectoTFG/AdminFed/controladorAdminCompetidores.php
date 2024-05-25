<?php
// Controlador para la gestión de competidores

include_once '../Modelo/ModeloCompetidor.php';
include_once '../Clases/Competidor.php';

$competidorModelo = new ModeloCompetidor();
if (isset($_POST['accion']) && $_POST['accion'] == 'mostrar') {
    // Maneja la acción 'mostrar' para obtener los datos de un competidor

    $dni=$_POST['dni'];
    $competidor = $competidorModelo->obtenerCompetidorPorDNI($dni);
    echo json_encode($competidor, JSON_FORCE_OBJECT);
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    // Maneja la acción 'editar' para modificar los datos de un competidor

    $dni=$_POST['dni'];
    $nombre=$_POST['nombre'];
    $fech_nac=$_POST['fechaNac'];
    $licencia=$_POST['licencia'];
    $club=$_POST['club'];
    $peso=$_POST['peso'];
    $sexo=$_POST['sexo'];
    $estado = $_POST['estado']; 
    $competidor=$competidorModelo->obtenerCompetidorPorDNI($dni);
    $competidor->setNombre($nombre);
    $competidor->setFech_nac($fech_nac);
    $competidor->setLicencia($licencia);
    $competidor->setClub($club);
    $competidor->setPeso($peso);
    $competidor->setSexo($sexo);
    $competidor->setEstado($estado);
    $resultado = $competidorModelo->modificarCompetidor($competidor);       
} else if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    // Maneja la acción 'eliminar' para eliminar un competidor

    $dni=$_POST['dni'];
    $competidor=$competidorModelo->obtenerCompetidorPorDNI($dni);
    $resultado = $competidorModelo->eliminarCompetidor($competidor);      
}else{
    // Redirección a la página principal si no se ha enviado ninguna acción válida

    header("Location: ../index.php");

}