<?php
//Controlador para subir la imagen de un competidor o un coach
session_start();
include_once '../Modelo/ModeloCompetidor.php';
include_once '../Modelo/ModeloCoach.php';

if (!isset($_SESSION["coach"]) && !isset($_SESSION["competidor"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_FILES['imagenPerfil']) && isset($_POST['idCompetidor']) && ($_POST['rol'])=="competidor" ) {
    $dni = $_POST['idCompetidor'];
    $modeloCompetidor = new ModeloCompetidor();
    $competidor = $modeloCompetidor->obtenerCompetidorPorDNI($dni);
    if (!$competidor) {
        echo "Competidor no encontrado.";
        exit();
    }

    $directorioDestino = __DIR__ . '/../img/usuarios/';
    $nombreImagenActual = $competidor->getImg();

    // Si existe una imagen anterior, eliminarla
    if (!empty($nombreImagenActual)) {
        $rutaImagenActual = $directorioDestino . $nombreImagenActual;
        if (file_exists($rutaImagenActual)) {
            unlink($rutaImagenActual);
        }
    }

    // Procesar la nueva imagen
    $nombreArchivoOriginal = basename($_FILES['imagenPerfil']['name']);
    $prefijo = $dni . "_";
    $nombreArchivo = $prefijo . $nombreArchivoOriginal;
    $archivoSubido = $directorioDestino . $nombreArchivo;

    // Validar y mover el archivo subido
    if (move_uploaded_file($_FILES['imagenPerfil']['tmp_name'], $archivoSubido)) {
        $competidor->setImg($nombreArchivo);
        if ($modeloCompetidor->modificarCompetidor($competidor)) {
            header("Location: perfilCompetidor.php");
        } else {
            echo "Error al actualizar la imagen en la base de datos.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
}else if (isset($_FILES['imagenPerfil']) && isset($_POST['idCoach']) && ($_POST['rol'])=="coach" ) {
    $dni = $_POST['idCoach'];
    $modeloCoach = new ModeloCoach();
    $coach = $modeloCoach->obtenerCoachPorDNI($dni);
    if (!$coach) {
        echo "Coach no encontrado.";
        exit();
    }

    $directorioDestino = __DIR__ . '/../img/usuarios/';
    $nombreImagenActual = $coach->getImg();

    // Si existe una imagen anterior, eliminarla
    if (!empty($nombreImagenActual)) {
        $rutaImagenActual = $directorioDestino . $nombreImagenActual;
        if (file_exists($rutaImagenActual)) {
            unlink($rutaImagenActual);
        }
    }

    // Procesar la nueva imagen
    $nombreArchivoOriginal = basename($_FILES['imagenPerfil']['name']);
    $prefijo = $dni . "_";
    $nombreArchivo = $prefijo . $nombreArchivoOriginal;
    $archivoSubido = $directorioDestino . $nombreArchivo;

    // Validar y mover el archivo subido
    if (move_uploaded_file($_FILES['imagenPerfil']['tmp_name'], $archivoSubido)) {
        $coach->setImg($nombreArchivo);
        if ($modeloCoach->modificarCoach($coach)) {
            header("Location: perfilCoach.php");
        } else {
            echo "Error al actualizar la imagen en la base de datos.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
} else {
    header("Location: ../index.php");
}

