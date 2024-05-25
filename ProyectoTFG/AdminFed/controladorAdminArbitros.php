<?php
// Controlador para la gestión de árbitros

include_once '../Modelo/ModeloArbitro.php';
include_once '../Clases/Arbitro.php';

$arbitroModelo = new ModeloArbitro();
// Verifica si se ha enviado una acción y maneja la solicitud en consecuencia
if (isset($_POST['accion']) && $_POST['accion'] == 'mostrar') {
    // Muestra los detalles de un árbitro específico

    $dni=$_POST['dni'];
    $arbitro = $arbitroModelo->obtenerArbitroPorDNI($dni);
    echo json_encode($arbitro, JSON_FORCE_OBJECT);
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    // Edita los detalles de un árbitro específico

    $dni=$_POST['dni'];
    $nombre=$_POST['nombre'];
    $contrasena=$_POST['pass'];
    $estado = $_POST['estado'];
    $arbitro= $arbitroModelo->obtenerArbitroPorDNI($dni);
    $arbitro->setNombre($nombre);
    $arbitro->setEstado($estado);
    $resultado = $arbitroModelo->modificarArbitro($arbitro);       
} else if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    // Elimina un árbitro específico
    $dni=$_POST['dni'];
    $arbitro= $arbitroModelo->obtenerArbitroPorDNI($dni);
    $resultado = $arbitroModelo->eliminarArbitro($arbitro);      
}else{
    
    header("Location: ../index.php");
}