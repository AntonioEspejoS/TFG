<?php
//Controlador para la gestión de enfrentamientos de los combates
if (isset($_POST['accion']) && $_POST['accion'] == 'generar') {
    //Obtenemos los datos de los competidores y los enfrentamientos existentes, con su puntuación y las rondas correspondientes
    include_once '../Modelo/ModeloEnfrentamiento.php';
    include_once '../Modelo/ModeloCompetidor.php';
    $modeloEnfrentamiento = new ModeloEnfrentamiento();
    $modeloCompetidor = new ModeloCompetidor();
    $idTorneo=$_POST['idTorneo'];
    $peso=$_POST['peso'];
    $sexo=$_POST['sexo'];
    $edad=$_POST['edad'];
    $modalidad=$_POST['modalidad'];
    $enfrentamientos = $modeloEnfrentamiento->obtenerEnfrentamientosPorCriterios($idTorneo, $modalidad, $edad, $peso, $sexo);
    $resultado = [];
    foreach ($enfrentamientos as $enfrentamiento) {
        $competidor1Info = null;
        $competidor2Info = null;

        if ($enfrentamiento->getDni1()) {
            $competidor1 = $modeloCompetidor->obtenerCompetidorPorDNI($enfrentamiento->getDni1());
            $competidor1Info = [
                'dni' => $enfrentamiento->getDni1(),
                'nombre' => $competidor1 ? $competidor1->getNombre() : 'Desconocido',
            ];
        }

        if ($enfrentamiento->getDni2()) {
            $competidor2 = $modeloCompetidor->obtenerCompetidorPorDNI($enfrentamiento->getDni2());
            $competidor2Info = [
                'dni' => $enfrentamiento->getDni2(),
                'nombre' => $competidor2 ? $competidor2->getNombre() : 'Desconocido',
            ];
        }

        $infoEnfrentamiento = [
            'idEnfrentamiento' => $enfrentamiento->getIdEnfrentamiento(),
            'competidor1' => $competidor1Info,
            'competidor2' => $competidor2Info ? $competidor2Info : ['dni' => null, 'nombre' => 'Sin Competidor'],
            'puntuacion1' => $enfrentamiento->getPuntos1(),
            'puntuacion2' => $enfrentamiento->getPuntos2(),
            'ronda' => $enfrentamiento->getRonda(),
        ];

        $resultado[] = $infoEnfrentamiento;
    }
    //error_log(var_export($resultado, true));

    echo json_encode($resultado, JSON_FORCE_OBJECT);
} else if (isset($_POST['accion']) && $_POST['accion'] == 'insertarEnfrentamiento') {
    //Se inserta cada enfrentamiento que se realice
    include_once '../Modelo/ModeloEnfrentamiento.php';
    $modeloEnfrentamiento = new ModeloEnfrentamiento();
    $idTorneo=$_POST['idTorneo'];
    $peso=$_POST['peso'];
    $sexo=$_POST['sexo'];
    $edad=$_POST['edad'];
    $modalidad=$_POST['modalidad'];
    $dni1=$_POST['dni0'];
    $dni2=$_POST['dni1'];
    $dniNuevoContrincante=$_POST['dniNuevoContrincante'];
    $posicionDelContrincante=$_POST['posicionDelContrincante'];
    $puntos1=$_POST['puntuacion0'];
    $puntos2=$_POST['puntuacion1'];        
    $ronda=$_POST['ronda']; 
    //Modificamos el enfrentamiento para meterle los puntos
    $enfrentamientos = $modeloEnfrentamiento->obtenerEnfrentamientosPorCriteriosAvanzados($idTorneo, $modalidad, $edad, $peso, $sexo, $dni1, $dni2, $ronda);
    //error_log(var_export($enfrentamientos, true));

    foreach ($enfrentamientos as $enfrentamientoModificar) {
     $enfrentamientoModificar->setPuntos1($puntos1);
     $enfrentamientoModificar->setPuntos2($puntos2);
    }
    $resultado = $modeloEnfrentamiento->modificarEnfrentamiento($enfrentamientoModificar);
    //Crear nuevo enfrentamiento sin puntuación
    //Compruebo si ya tengo nuevo contrincante
    if($dniNuevoContrincante!="" && $dniNuevoContrincante!=null){
            //Cogemos al ganador
        $dniGanador;
        if($puntos1>$puntos2){
            $dniGanador=$dni1;  
        }else{
            $dniGanador=$dni2;   
        }
        $nuevaRonda=$ronda-1;
        if($posicionDelContrincante==0){
            $nuevoEnfrentamiento = new Enfrentamiento(null, $dniGanador, $dniNuevoContrincante, null, null, $nuevaRonda, $idTorneo, $peso, $sexo, $edad, $modalidad);
            $enfrentamientoExistente=$modeloEnfrentamiento->obtenerEnfrentamientosPorCriteriosAvanzados($idTorneo, $modalidad, $edad, $peso, $sexo, $dniGanador, $dniNuevoContrincante, $nuevaRonda);
                if(empty($enfrentamientoExistente)){
                    //Elimino si hay otro enfrentamiento en el mimo sitio pero con otro peleador
                    $modeloEnfrentamiento->eliminarEnfrentamientosPorDNIs($idTorneo, $modalidad, $edad, $peso, $sexo, $dni1, $dni2, $nuevaRonda);
                    $resultado=$modeloEnfrentamiento->insertarEnfrentamiento($nuevoEnfrentamiento);
                }
        }else{          
            $nuevoEnfrentamiento = new Enfrentamiento(null, $dniNuevoContrincante, $dniGanador, null, null, $nuevaRonda, $idTorneo, $peso, $sexo, $edad, $modalidad);
            $enfrentamientoExistente=$modeloEnfrentamiento->obtenerEnfrentamientosPorCriteriosAvanzados($idTorneo, $modalidad, $edad, $peso, $sexo, $dniNuevoContrincante, $dniGanador, $nuevaRonda);
                if(empty($enfrentamientoExistente)){
                    //Elimino si hay otro enfrentamiento en el mimo sitio pero con otro peleador
                    $modeloEnfrentamiento->eliminarEnfrentamientosPorDNIs($idTorneo, $modalidad, $edad, $peso, $sexo, $dni1, $dni2, $nuevaRonda);
                    $resultado=$modeloEnfrentamiento->insertarEnfrentamiento($nuevoEnfrentamiento);
                }
        }
        
    }
}else if (isset($_POST['accion']) && $_POST['accion'] == 'terminar') {
    //Modificamos el torneo para ponerlo coo terminado
    include_once '../Modelo/ModeloTorneo.php';
    $modeloTorneo = new ModeloTorneo();
    $idTorneo = $_POST['idTorneo'];
    $torneo = $modeloTorneo->obtenerTorneoPorId($idTorneo);
    //error_log("Entraaa finalizado");
    if ($torneo != null) {
        $torneo->setEstado(0);
        $torneo->setFinalizado(1);
        $modeloTorneo->modificarTorneo($torneo);
    }
}else{
    header("Location: ../index.php");

}
