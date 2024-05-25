<?php
//Controlador de la gestión de administradores de la federación.
include_once '../Modelo/ModeloAdminFed.php';
include_once '../Clases/Admin.php';

$modeloAdminFed = new ModeloAdminFed();
// Verifica si se ha enviado una acción y la maneja en consecuencia
if (isset($_POST['accion']) && $_POST['accion'] == 'mostrar') {
    // Muestra los detalles de un administrador específico
    $dni=$_POST['dni'];
    $adminFed = $modeloAdminFed->obtenerAdminFedPorDNI($dni);
    echo json_encode($adminFed, JSON_FORCE_OBJECT);
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    // Edita los detalles de un administrador específico
    $dni=$_POST['dni'];
    $nombre=$_POST['nombre'];
    $estado = $_POST['estado']; 
    $adminFed=$modeloAdminFed->obtenerAdminFedPorDNI($dni);
    $adminFed->setNombre($nombre);
    $adminFed->setEstado($estado);
    $resultado = $modeloAdminFed->modificarAdminFed($adminFed);       
} else if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
   // Elimina un administrador específico
    $dni=$_POST['dni'];
    $adminFed=$modeloAdminFed->obtenerAdminFedPorDNI($dni);
    $resultado = $modeloAdminFed->eliminarAdminFed($adminFed);      
}else{
// Redirecciona a la página principal si no se ha enviado ninguna acción
    header("Location: ../index.php");
}