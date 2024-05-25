<?php
session_start();
include_once '../Modelo/ModeloCompetidor.php';
include_once '../Modelo/ModeloCoach.php';
include_once '../Modelo/ModeloArbitro.php';
include_once '../Modelo/ModeloAdminFed.php';
include_once '../Modelo/ModeloAdmin.php';
///////////////////////////////////////////
$dni = (string) ($_REQUEST['dni']);
$contra = (string) ($_REQUEST['contra']);
$rol = (string) ($_REQUEST['rol']);
//Se crea una sesión para el rol que inicie sesión.
if ($rol == "competidor") {
    $competidorModelo = new ModeloCompetidor();
    if ($competidorModelo->verificarCredenciales($dni, $contra)) {
        $competidor = $competidorModelo->obtenerCompetidorPorDNI($dni);
        $_SESSION["competidor"]= $competidor->getDni();
        header("Location: ../perfiles/perfilCompetidor.php");
    } else {
       header("Location: ../MensajesYErrores/errorCredenciales.php");
    }
}else if($rol == "coach"){
    $coachModelo = new ModeloCoach();
    if ($coachModelo->verificarCredenciales($dni, $contra)) {
        $coach = $coachModelo->obtenerCoachPorDNI($dni);
        $_SESSION["coach"]= $coach->getDni();
        header("Location: ../listados/listaMiClub.php");
    } else {
       header("Location: ../MensajesYErrores/errorCredenciales.php");
    }      
}else if($rol == "arbitro"){
    $arbitroModelo = new ModeloArbitro();
    if ($arbitroModelo->verificarCredenciales($dni, $contra)) {
        $arbitro = $arbitroModelo->obtenerArbitroPorDNI($dni);
        $_SESSION["arbitro"]= $arbitro->getDni();
        header("Location: ../perfiles/perfilArbitro.php");
    } else {
       header("Location: ../MensajesYErrores/errorCredenciales.php");
    }       
}else if($rol == "adminFed"){
    $adminFedModelo = new ModeloAdminFed();
    if ($adminFedModelo->verificarCredenciales($dni, $contra)) {
        $adminFed = $adminFedModelo->obtenerAdminFedPorDNI($dni);
        $_SESSION["adminFed"]= $adminFed->getDni();
        header("Location: ../perfiles/perfilAdminFed.php");
    } else {
       header("Location: ../MensajesYErrores/errorCredenciales.php");
    }       
}else if($rol == "admin"){
    $adminModelo = new ModeloAdmin();
    if ($adminModelo->verificarCredenciales($dni, $contra)) {
        $admin = $adminModelo->obtenerAdminPorDNI($dni);
        $_SESSION["admin"]= $admin->getDni();
        header("Location: ../perfiles/perfilAdmin.php");
    } else {
       header("Location: ../MensajesYErrores/errorCredenciales.php");
    }       
}else{  
    header('Location: ../index.php');    
}

