<?php
//Controlador para subir la imagen del club
session_start();
include_once '../Modelo/ModeloClub.php';

if (!isset($_SESSION["coach"])) {
    // Redirigir al usuario si no es un coach
    header("Location: ../index.php");
    exit();
}

if (isset($_FILES['imagenClub']) && isset($_POST['idClub'])) {
    $idClub = $_POST['idClub'];
    $modeloClub = new ModeloClub();
    $club = $modeloClub->obtenerClubPorId($idClub);

    if (!$club) {
        echo "Club no encontrado.";
        exit();
    }

    $directorioDestino = __DIR__ . '/../img/clubes/';
    $nombreImagenActual = $club->getImg();

    // Si existe una imagen anterior, eliminarla
    if (!empty($nombreImagenActual)) {
        $rutaImagenActual = $directorioDestino . $nombreImagenActual;
        if (file_exists($rutaImagenActual)) {
            unlink($rutaImagenActual);
        }
    }

    // Procesar la nueva imagen
    $nombreArchivoOriginal = basename($_FILES['imagenClub']['name']);
    $prefijo = $idClub . "_";
    $nombreArchivo = $prefijo . $nombreArchivoOriginal;
    $archivoSubido = $directorioDestino . $nombreArchivo;

    // Validar y mover el archivo subido
    if (move_uploaded_file($_FILES['imagenClub']['tmp_name'], $archivoSubido)) {
        $club->setImg($nombreArchivo);
        if ($modeloClub->modificarClub($club)) {
            header("Location: listaMiClub.php");
        } else {
            echo "Error al actualizar la imagen en la base de datos.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
} else {
    echo "No se ha subido ningún archivo o falta información.";
}

