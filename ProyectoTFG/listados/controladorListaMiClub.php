<?php
//Controlador para modificar datos del club por parte de coach, cambiar de club por parte del competidor y ver la información del club para competidores y coaches
include_once '../Modelo/ModeloCoach.php';
include_once '../Modelo/ModeloCompetidor.php';
include_once '../Modelo/ModeloClub.php';

//Acciones para eliminar competidores del club, mostrar club para hacer un cambio de club y editar este club por parte del competidor
//, actualizar la ubicación del club por parte del coach
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
  $modeloCompetidor = new ModeloCompetidor();
  $dni = $_POST['dni'];
  $competidor=$modeloCompetidor->obtenerCompetidorPorDNI($dni);
  $resultado = $modeloCompetidor->eliminarCompetidor($competidor);
}else if(isset($_POST['accion']) && $_POST['accion'] == 'mostrarClub'){
    $modeloCompetidor = new ModeloCompetidor();
    $dni=$_POST['dni'];
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);
    echo json_encode($competidor, JSON_FORCE_OBJECT);
}else if(isset($_POST['accion']) && $_POST['accion'] == 'editarClub'){
    $modeloCompetidor = new ModeloCompetidor();
    $dni = $_POST['dni'];
    $club = $_POST['club'];
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);
    $competidor->setClub($club);
    $competidor->setEstado(1);
    $modeloCompetidor->modificarCompetidor($competidor);
    
}else if(isset($_POST['accion']) && $_POST['accion'] == 'actualizarUbicacion'){
    $modeloClub = new ModeloClub();
    $longitud = $_POST['longitud'];
    $latitud = $_POST['latitud'];
    $idClub = $_POST['idClub'];
    $club = $modeloClub->obtenerClubPorId($idClub);
    $club->setLongitud($longitud);
    $club->setLatitud($latitud);
    $modeloClub->modificarClub($club);
}


//Función para obtener los datos del club a partir del competidor o coach 
//Devuelve la informaciçon del club y competidores y coaches verificados por ese club
function obtenerDatosClub($dni) {
    $modeloCompetidor = new ModeloCompetidor();
    $modeloCoach = new ModeloCoach();
    $modeloClub = new ModeloClub();
    $idClub = null;
    // Obtener el club a partir del competidor o coach
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);
    if ($competidor) {
        $idClub = $competidor->getClub();
    }

    // Si no se encuentra como competidor, buscar como coach
    if (!$idClub) {
        $coach = $modeloCoach->obtenerCoachPorDNI($dni);
        if ($coach) {
            $idClub = $coach->getClub();
        }
    }

    // Obtener datos del club si se encontró
    if ($idClub) {
        $club= $modeloClub->obtenerClubPorId($idClub);
        $coaches = $modeloCoach->obtenerCoachesPorClub($idClub);
        $competidores = $modeloCompetidor->obtenerCompetidoresPorClub($idClub);
        $coachesVerificados = [];
        $competidoresVerificados = [];
        // Filtrar solo coaches verificados (estado = 1)
        foreach ($coaches as $coach) {
            if ($coach->getEstado() == 1) {
                $coachesVerificados[] = $coach;
            }
        }
        // Filtrar solo competidores verificados (estado = 3) 
        foreach ($competidores as $competidor) {
            if ($competidor->getEstado() == 3) {
                $competidoresVerificados[] = $competidor;
            }
        }
        return array(
            'club' => $club,
            'coaches' => $coachesVerificados,
            'competidores' => $competidoresVerificados
        );
    }

    return null;
}

