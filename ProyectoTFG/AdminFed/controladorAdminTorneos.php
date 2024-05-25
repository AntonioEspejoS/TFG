<?php
// Controlador para la gestión de torneos

include_once '../Modelo/ModeloTorneo.php';
include_once '../Modelo/ModeloRegistrado.php';
include_once '../Modelo/ModeloCategoria.php';
include_once '../Modelo/ModeloEnfrentamiento.php';

include_once '../Clases/Torneo.php';
include_once '../Clases/Categoria.php';
include_once '../Clases/Competidor.php';

$torneoModelo = new ModeloTorneo();
if (isset($_POST['accion']) && $_POST['accion'] == 'mostrar') {
    // Maneja la acción 'mostrar' para obtener los datos de un torneo

    $idTorneo=$_POST['idTorneo'];
    $torneo = $torneoModelo->obtenerTorneoPorId($idTorneo);
    //error_log(var_export($torneo, true));
    echo json_encode($torneo, JSON_FORCE_OBJECT);
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
    // Maneja la acción 'editar' para modificar los datos de un torneo

    $idTorneo = $_POST['idTorneo'];
    $torneoExistente = $torneoModelo->obtenerTorneoPorId($idTorneo);
    $estadoAnteriorAlCambio=$torneoExistente->getEstado();
    if ($torneoExistente != null) {
        // Actualizar los valores del torneo con los nuevos datos recibidos del formulario
        $fechaInscripcion = $_POST['fechaInscripcion'];
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];
        $estado = $_POST['estado'];
        $finalizado = $_POST['finalizado'];
        $plazas = $_POST['plazas']; 
        $torneoExistente->setFechainscripcion($fechaInscripcion);
        $torneoExistente->setFechatorneo($fecha);
        $torneoExistente->setDescripcion($descripcion);
        $torneoExistente->setEstado($estado);
        $torneoExistente->setFinalizado($finalizado);
        $torneoExistente->setPlazas($plazas);
        //Si el torneo se ha finalizado no se pueden abrir las inscripciones, no tendría sentido 
        if($finalizado==1){
            $estado=0;
        }
        // Modifico el torneo
        $resultado = $torneoModelo->modificarTorneo($torneoExistente);

        if ($resultado) {
        } else {
            error_log("Error al actualizar el torneo.");
        }
    } else {
        error_log("Torneo no encontrado.");
    }
    //Si se abren de nuevo las inscripciones por lo que sea se borran los enfrentamientos 
    //por si se inscriben gente nueva, si pasa de estar de inactivas a activas y el torneo no ha finalizado
    if($estado == 1 && $estadoAnteriorAlCambio==0 && $finalizado==0){
        $modeloEnfrentamiento = new ModeloEnfrentamiento();
        
        $modeloEnfrentamiento->eliminarEnfrentamientoPorTorneo($torneoExistente);
    }  
    //Crear enfrentamientos si pasa las insripciones  de estar activas a inactivas y el torneo no ha finalizado
    if ($estado == 0 && $estadoAnteriorAlCambio==1 && $finalizado==0) {
        $modeloCategoria = new ModeloCategoria();
        $modeloRegistrado = new ModeloRegistrado();
        $modeloEnfrentamiento = new ModeloEnfrentamiento();
        $categorias=$modeloCategoria->obtenerCategoriasPorTorneo($idTorneo);
        $competidoresRegistrados = $modeloRegistrado->obtenerListaCompetidoresRegistradosTorneo($idTorneo);
        foreach ($categorias as $categoria) {
            $peso= $categoria->getPeso();
            $sexo=$categoria->getSexo();
            $edad=$categoria->getEdad();
            $modalidad=$categoria->getModalidad();
            $competidoresDeUnaModalidad = array();
            foreach ($competidoresRegistrados as $competidorRegistrado) {
              // Accedes a los detalles de inscripción del competidor
              $detallesInscripcion = $competidorRegistrado['detallesInscripcion'];
              // Comparas los criterios de la categoría con los detalles de inscripción del competidor
              if ($detallesInscripcion['pesoInscripcion'] == $peso && 
                  $detallesInscripcion['sexoInscripcion'] == $sexo && 
                  $detallesInscripcion['edad'] == $edad && 
                  $detallesInscripcion['modalidad'] == $modalidad) {
                  // Si el competidor cumple con los criterios, lo agregas al arreglo de competidores de esta modalidad
                  $competidoresDeUnaModalidad[] = $competidorRegistrado['competidor'];
              }
            }
            // Mezclar aleatoriamente los competidores para generar enfrentamientos
            shuffle($competidoresDeUnaModalidad);
            // Calcular la ronda inicial basada en el número de competidores
            $numeroCompetidores = count($competidoresDeUnaModalidad);
                if ($numeroCompetidores <= 2) {
                    $ronda= 1; // Finales
                } elseif ($numeroCompetidores <= 4) {
                    $ronda= 2; // Semifinales
                } else {
                    $ronda= 3; // Cuartos de final
                }
            // Generar enfrentamientos
            for ($i = 0; $i < count($competidoresDeUnaModalidad); $i += 2) {
                //Cuando son 5 los que no tienen cuartos se ponen a ronda 2
                    if( $numeroCompetidores == 5 && $i ==2){
                      $ronda= 2;
                    }else if($numeroCompetidores == 5 && $i + 1 == 5){
                       $ronda= 3; 
                    }
                //Cuando son 6 los últimos se ponen a ronda 2 porque no tienen cuartos
                if( $numeroCompetidores == 6 && $i ==4){
                      $ronda= 2;
                    }   
                    // Si hay un número impar de competidores, el último quedará sin pareja

                if ($i + 1 < $numeroCompetidores) {
                    // Insertar enfrentamiento con ambos competidores
                    $enfrentamiento= new Enfrentamiento(
                    null, 
                    $competidoresDeUnaModalidad[$i]->getDni(), 
                    $competidoresDeUnaModalidad[$i + 1]->getDni(), 
                    null, null, $ronda,$idTorneo, $peso, $sexo, $edad, $modalidad);
                    //Comprobar si el enfrentamiento existe
                    $enfrentamientoExistente=$modeloEnfrentamiento->obtenerEnfrentamientosPorCriteriosAvanzados($idTorneo, $modalidad, $edad, $peso, $sexo, $enfrentamiento->getDni1(), $enfrentamiento->getDni2(), $ronda);
                    
                    if(empty($enfrentamientoExistente)){
                        $resultado=$modeloEnfrentamiento->insertarEnfrentamiento($enfrentamiento);
                    }
                } else {
                    // Insertar enfrentamiento para el competidor sin pareja
                    $enfrentamiento= new Enfrentamiento(
                    null, 
                    $competidoresDeUnaModalidad[$i]->getDni(), 
                    null, 
                    null, null, $ronda,$idTorneo, $peso, $sexo, $edad, $modalidad);
                    $enfrentamientoExistente=$modeloEnfrentamiento->obtenerEnfrentamientosPorCriteriosAvanzados($idTorneo, $modalidad, $edad, $peso, $sexo, $enfrentamiento->getDni1(), null, $ronda);
                    if(empty($enfrentamientoExistente)){
                        $modeloEnfrentamiento->insertarEnfrentamiento($enfrentamiento);
                    }
                }
            }
        }  
    }

    
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    // Maneja la acción 'eliminar' para eliminar un torneo y sus relaciones

    $id=$_POST['id'];
    include_once '../Modelo/ModeloCategoria.php';
    include_once '../Modelo/ModeloEnfrentamiento.php';
    include_once '../Modelo/ModeloGestion.php';
    $torneo = $torneoModelo->obtenerTorneoPorId($id);
    //Eliminar los inscritos al torneo
    $modeloRegistrado = new ModeloRegistrado();
    $modeloRegistrado->eliminarRegistradoPorTorneo($torneo);
    // Eliminar todas las categorías asociadas a este torneo
    $modeloCategoria = new ModeloCategoria();
    $modeloCategoria->eliminarCategoriasPorTorneo($torneo);
    //Eliminar todos los enfrentamientos
    $modeloEnfrentamiento = new ModeloEnfrentamiento();
    $modeloEnfrentamiento->eliminarEnfrentamientoPorTorneo($torneo);
    //Eliminar los arbitros asociados
    $modeloGestion=new ModeloGestion();
    $gestiones=$modeloGestion->obtenerGestionesPorIdTorneo($torneo);
    foreach ($gestiones as $gestion){
            $modeloGestion->eliminarGestion($gestion);
    }
    //eliminar torneo
    $resultado = $torneoModelo->eliminarTorneo($torneo);      
    
    
    
} else if (isset($_POST['accion']) && $_POST['accion'] == 'insertar') {
    // Maneja la acción 'insertar' para crear un nuevo torneo

    $fecha=$_POST['fecha'];
    $fechaInscripcion=$_POST['fechaInscripcion'];
    $descripcion=$_POST['descripcion'];
    $estado=$_POST['estado'];
    $genero = $_POST['generoTorneo'];
    $modalidad = $_POST['modalidadTorneo'];
    $categoriaEdad = $_POST['categoriaEdadTorneo'];
    $plazas = $_POST['plazas'];
    $modeloCategoria = new ModeloCategoria();
    $torneoModelo = new ModeloTorneo();
    $torneo = new Torneo(null, $fechaInscripcion, $fecha, $descripcion, $estado, 0, $plazas);
    $idTorneoInsertado = $torneoModelo->insertarTorneo($torneo);  
    //Insertamos las categorias
    if ($idTorneoInsertado !== false) {
        // Define todas las posibles modalidades y categorías de edad
        $todasModalidades = ['lowkick', 'fullcontact']; 
        $todasEdades = ['junior', 'senior'];
        $pesosMasculinos = [64, 69, 74, 79, 84, 90];
        $pesosFemeninos = [49, 59, 64, 69, 74, 79];
        // Decide qué modalidades y edades usar basado en la selección
        if ($modalidad == 'todas') {
            $modalidadesUsar = $todasModalidades;
        } else {
            $modalidadesUsar = [$modalidad];
        }
        if ($categoriaEdad == 'todas') {
            $edadesUsar = $todasEdades;
        } else {
            $edadesUsar = [$categoriaEdad];
        }
        foreach ($modalidadesUsar as $modalidadSeleccionada) {
            foreach ($edadesUsar as $edadSeleccionada) {
                if ($genero == 'ambos' || $genero == 'masculino') {
                    foreach ($pesosMasculinos as $peso) {
                        // Crea categoría masculina
                        $categoria = new Categoria(null, $idTorneoInsertado, 'm', $peso, $edadSeleccionada, $modalidadSeleccionada, 1);
                        $modeloCategoria->insertarCategoria($categoria);
                    }
                }
                if ($genero == 'ambos' || $genero == 'femenino') {
                    foreach ($pesosFemeninos as $peso) {
                        // Crea categoría femenina
                        $categoria = new Categoria(null, $idTorneoInsertado, 'f', $peso, $edadSeleccionada, $modalidadSeleccionada, 1);
                        $modeloCategoria->insertarCategoria($categoria);
                    }
                }
            }
        }
    } 
}else{
    // Redirección a la página principal si no se ha enviado ninguna acción válida

    header("Location: ../index.php");
}
    
    
    
    
    
    
    
