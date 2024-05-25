<?php
//Controlador de la lista de competidores para verificar por parte del coaches
include_once '../Modelo/ModeloCoach.php';
include_once '../Modelo/ModeloCompetidor.php';

//Verificación del competidor seleccionado
if (isset($_POST['accion']) && $_POST['accion'] == 'verificar') {
  $modeloCompetidor = new ModeloCompetidor();
  $dni = $_POST['dni'];
  $nuevoEstado = $_POST['estado'];
  // Obtiene el competidor actual
  $competidorActual = $modeloCompetidor ->obtenerCompetidorPorDNI($dni);
  $competidorActual->setEstado($nuevoEstado);
  $resultado = $modeloCompetidor->modificarCompetidor($competidorActual);
}
//Función para obtener los competidores no verificados a partir del dn del coach y el club de este.
//Devuelve la lista de competidores no verificados
function obtenerCompetidoresNoVerificados($dni) {
    $modeloCoach = new ModeloCoach();
    $modeloCompetidor = new ModeloCompetidor();

    // Obtener el club a partir del DNI del coach
    $coach = $modeloCoach->obtenerCoachPorDNI($dni);
    $nombreClub = $coach ? $coach->getClub() : null;

    $competidoresNoVerificados = [];

    // Si el coach existe y tiene un club
    if ($nombreClub) {
        $todosLosCompetidores = $modeloCompetidor->obtenerCompetidoresPorClub($nombreClub);

        // Filtrar competidores con estado 0 o 1
        foreach ($todosLosCompetidores as $competidor) {
            if ($competidor->getEstado() == 0 || $competidor->getEstado() == 1) {
                $competidoresNoVerificados[] = $competidor;
            }
        }
    }

    return $competidoresNoVerificados;
}
