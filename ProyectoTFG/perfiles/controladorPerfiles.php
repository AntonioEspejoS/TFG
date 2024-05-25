<?php
//Controlador para modificar los correos de los perfiles de los usuarios
include_once '../Modelo/ModeloCoach.php';
include_once '../Modelo/ModeloArbitro.php';
include_once '../Modelo/ModeloAdminFed.php';
include_once '../Modelo/ModeloAdmin.php';


if (isset($_POST['accion']) && $_POST['accion'] == 'mostrarCorreoCoach') {
    //Mostrar correo de coach para modificar
    $modeloCoach = new ModeloCoach();
    $dni=$_POST['dni'];
    $coach = $modeloCoach->obtenerCoachPorDNI($dni);
    echo json_encode($coach, JSON_FORCE_OBJECT);
    
}else if (isset($_POST['accion']) && $_POST['accion'] == 'editarCorreoCoach') {
    //Editar correo de coach
    $modeloCoach = new ModeloCoach();
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $coach = $modeloCoach->obtenerCoachPorDNI($dni);
    $coach->setCorreo($correo);
    $modeloCoach->modificarCoach($coach);
}else if (isset($_POST['accion']) && $_POST['accion'] == 'mostrarCorreoArbitro') {
    //Mostrar correo de arbitro para modificar
    $modeloArbitro = new ModeloArbitro();
    $dni=$_POST['dni'];
    $arbitro = $modeloArbitro->obtenerArbitroPorDNI($dni);
    echo json_encode($arbitro, JSON_FORCE_OBJECT);
    
}else if (isset($_POST['accion']) && $_POST['accion'] == 'editarCorreoArbitro') {
    //Editar correo de arbitro
    $modeloArbitro = new ModeloArbitro();
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $arbitro = $modeloArbitro->obtenerArbitroPorDNI($dni);
    $arbitro->setCorreo($correo);
    $modeloArbitro->modificarArbitro($arbitro);
}else if (isset($_POST['accion']) && $_POST['accion'] == 'mostrarCorreoAdminFed') {
    //Mostrar correo del administrador de la federación para modificar
    $modeloAdminFed = new ModeloAdminFed();
    $dni=$_POST['dni'];
    $adminFed = $modeloAdminFed->obtenerAdminFedPorDNI($dni);
    echo json_encode($adminFed, JSON_FORCE_OBJECT);
    
}else if (isset($_POST['accion']) && $_POST['accion'] == 'editarCorreoAdminFed') {
    //Editar correo del administrador de la federación
    $modeloAdminFed = new ModeloAdminFed();
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $adminFed = $modeloAdminFed->obtenerAdminFedPorDNI($dni);
    $adminFed->setCorreo($correo);
    $modeloAdminFed->modificarAdminFed($adminFed);
}else if (isset($_POST['accion']) && $_POST['accion'] == 'mostrarCorreoAdmin') {
    //Mostrar correo del administrador del sistema para modificar
    $modeloAdmin = new ModeloAdmin();
    $dni=$_POST['dni'];
    $admin = $modeloAdmin->obtenerAdminPorDNI($dni);
    echo json_encode($admin, JSON_FORCE_OBJECT);
    
}else if (isset($_POST['accion']) && $_POST['accion'] == 'editarCorreoAdmin') {
    //Editar correo del administrador del sistema
    $modeloAdmin = new ModeloAdmin();
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $admin = $modeloAdmin->obtenerAdminPorDNI($dni);
    $admin->setCorreo($correo);
    $modeloAdmin->modificarAdmin($admin);
}

