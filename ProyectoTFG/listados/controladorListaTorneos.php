<?php
//Controlador de la lisa de torneos no verificados
session_start();
include_once '../Modelo/ModeloCompetidor.php'; 
include_once '../Modelo/ModeloRegistrado.php'; 
include_once '../Clases/Competidor.php';
include_once '../Clases/Registrado.php'; 
//Realizar las inscripción y desinscripción de competidores en torneos
if (isset($_SESSION["competidor"]) && isset($_GET['accion']) && $_GET['accion'] == 'inscribirse') {
    //Inscripción
    $dni = $_SESSION["competidor"];
    $idTorneo = $_GET['idtorneo'];
    $modalidad = $_GET['modalidad'];
    //Crear instancia del modelo de Competidor 
    $modeloCompetidor = new ModeloCompetidor();
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);

    // Comprobar que el competidor existe y hemos obtenido los datos correctamente
    if ($competidor != null) {
        $peso = $competidor->getPeso();
        $sexo = $competidor->getSexo();
        $edad = $competidor->getCatedad();

        // Crear un objeto Registrado
        $registrado = new Registrado(null, $dni, $idTorneo, $sexo, $peso, $edad, $modalidad);

        // Crear instancia del modelo de Registrado y insertar el objeto
        $modeloRegistrado = new ModeloRegistrado();
        $resultado = $modeloRegistrado->insertarRegistrado($registrado);

        if ($resultado) {
                header("Location: listaTorneos.php");
        } else {
            echo "Error al realizar el registro.";
        }
    } else {
        echo "Error: Competidor no encontrado.";
    }
}else if(isset($_SESSION["competidor"]) && isset($_GET['accion']) && $_GET['accion'] == 'desinscribirse'){
    //Desinscripción
    $dni = $_SESSION["competidor"];
    $idTorneo = $_GET['idtorneo'];
    $modalidad = $_GET['modalidad'];
    $modeloRegistrado = new ModeloRegistrado();
    $resultado = $modeloRegistrado->eliminarCompetidorRegistrado($dni, $idTorneo, $modalidad);
    if ($resultado) {
        header("Location: listaTorneos.php");
    } else {
        echo "Error al realizar el registro.";
    }
} else {
    header("Location: ../index.php");
}

