<?php
//Controlador para modificar los datos del competidor
include_once '../Modelo/ModeloEnfrentamiento.php';
include_once '../Modelo/ModeloTorneo.php';
include_once '../Modelo/ModeloCompetidor.php';

if (isset($_POST['accion']) && $_POST['accion'] == 'mostrar') {
    $modeloCompetidor = new ModeloCompetidor();
    $dni=$_POST['dni'];
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);
    echo json_encode($competidor, JSON_FORCE_OBJECT);
    
}else if (isset($_POST['accion']) && $_POST['accion'] == 'editarPeso') {
    $modeloCompetidor = new ModeloCompetidor();
    $dni = $_POST['dni'];
    $peso = $_POST['peso'];
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);
    $competidor->setPeso($peso);
    $modeloCompetidor->modificarCompetidor($competidor);
}else if(isset($_POST['accion']) && $_POST['accion'] == 'mostrarCorreo'){
    $modeloCompetidor = new ModeloCompetidor();
    $dni=$_POST['dni'];
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);
    echo json_encode($competidor, JSON_FORCE_OBJECT);
}else if (isset($_POST['accion']) && $_POST['accion'] == 'editarCorreo') {
    $modeloCompetidor = new ModeloCompetidor();
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);
    $competidor->setCorreo($correo);
    $modeloCompetidor->modificarCompetidor($competidor);
}

//Función para obtener los enfrentamientos para mostrar los resultados de las competiciones de un competidor
//Devuelve la descripción del torneo, la categoría del enfrentamiento y la posición.
function obtenerEnfrentamientosConDescripcionTorneo($dni) {
    $modeloEnfrentamiento = new ModeloEnfrentamiento();
    $modeloTorneo = new ModeloTorneo();
    $enfrentamientos = $modeloEnfrentamiento->obtenerEnfrentamientos();
    $resultados = array();

    foreach ($enfrentamientos as $enfrentamiento) {
        if (($enfrentamiento->getDni1() == $dni || $enfrentamiento->getDni2() == $dni) && $enfrentamiento->getRonda() == 1 && $enfrentamiento->getPuntos1()!=null && $enfrentamiento->getPuntos2()!=null) {
            $torneo = $modeloTorneo->obtenerTorneoPorId($enfrentamiento->getIdTorneo());
            $descripcionTorneo=$torneo->getDescripcion();
            // Determinar la posición
            $posicion = '';
            if ($enfrentamiento->getDni1() == $dni && $enfrentamiento->getPuntos1() > $enfrentamiento->getPuntos2()) {
                $posicion = '1';
            } else if ($enfrentamiento->getDni2() == $dni && $enfrentamiento->getPuntos2() > $enfrentamiento->getPuntos1()) {
                $posicion = '1';
            } else {
                $posicion = '2';
            }
            $resultados[] = array(
                'enfrentamiento' => $enfrentamiento,
                'descripcionTorneo' => $descripcionTorneo,
                'posicion' => $posicion

            );
        }else if (($enfrentamiento->getDni1() == $dni || $enfrentamiento->getDni2() == $dni) && $enfrentamiento->getRonda() == 2) {
            $torneo = $modeloTorneo->obtenerTorneoPorId($enfrentamiento->getIdTorneo());
            $descripcionTorneo=$torneo->getDescripcion();
            // Determinar la posición
            $posicion = '';
            if ($enfrentamiento->getDni1() == $dni && $enfrentamiento->getPuntos1() < $enfrentamiento->getPuntos2()) {
                $posicion = '3';
            } else if ($enfrentamiento->getDni2() == $dni && $enfrentamiento->getPuntos2() < $enfrentamiento->getPuntos1()) {
                $posicion = '3';
            }
            if($posicion==="3"){
                $resultados[] = array(
                    'enfrentamiento' => $enfrentamiento,
                    'descripcionTorneo' => $descripcionTorneo,
                    'posicion' => $posicion
                );
            }
        }
    }  
    return $resultados;
}