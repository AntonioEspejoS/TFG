<?php
//Controlador de registro de otro rol para usuarios que ya tienen una cuenta creada
include_once '../Modelo/ModeloCompetidor.php';
include_once '../Modelo/ModeloCoach.php';
include_once '../Modelo/ModeloClub.php';
include_once '../Modelo/ModeloArbitro.php';
include_once '../Modelo/ModeloAdminFed.php';
include_once '../Modelo/ModeloAdmin.php';
///////////////////////////////////////////
//Función para obtener el dni del rol actual
//Devuelve el usuario del dni
function obtenerUsuarioPorDNIyRol($dni, $rol) {
    switch ($rol) {
        case 'competidor':
            $modelo = new ModeloCompetidor();
            return $modelo->obtenerCompetidorPorDNI($dni);
        case 'coach':
            $modelo = new ModeloCoach();
            return $modelo->obtenerCoachPorDNI($dni);
        case 'arbitro':
            $modelo = new ModeloArbitro();
            return $modelo->obtenerArbitroPorDNI($dni);
        case 'adminFed':
            $modelo = new ModeloAdminFed();
            return $modelo->obtenerAdminFedPorDNI($dni);
        case 'admin':
            $modelo = new ModeloAdmin();
            return $modelo->obtenerAdminPorDNI($dni);
        default:
            return null;
    }
}
//Función para obtener los roles de un usuario.
//Devuelve los roles que tiene un mismo usuario
function obtenerRolesPorDNI($dni) {
    $roles = []; // Array para almacenar los roles del usuario
    // Instancia los modelos
    $modeloCompetidor = new ModeloCompetidor();
    $modeloCoach = new ModeloCoach();
    $modeloArbitro = new ModeloArbitro();
    $modeloAdminFed = new ModeloAdminFed();
    $modeloAdmin = new ModeloAdmin();
    // Verificar cada rol y añadir al array si el usuario existe con ese rol
    if ($modeloCompetidor->obtenerCompetidorPorDNI($dni) !== null) {
        $roles[] = 'competidor';
    }
    if ($modeloCoach->obtenerCoachPorDNI($dni) !== null) {
        $roles[] = 'coach';
    }
    if ($modeloArbitro->obtenerArbitroPorDNI($dni) !== null) {
        $roles[] = 'arbitro';
    }
    if ($modeloAdminFed->obtenerAdminFedPorDNI($dni) !== null) {
        $roles[] = 'adminFed';
    }
    if ($modeloAdmin->obtenerAdminPorDNI($dni) !== null) {
        $roles[] = 'admin';
    }
    return $roles; // Devuelve el array de roles
}



//Registro de un rol nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    session_start();
    $rol = (string) ($_REQUEST['rol']?? null);
    if ($rol == "competidor") {
        $dni = $_REQUEST['dni'] ?? null;
        $nombre = $_REQUEST['nombre'] ?? null;
        $contrasena = $_REQUEST['contra'] ?? null;
        $correo = $_REQUEST['correo'] ?? null;
        $fech_nac = $_REQUEST['fecha'] ?? null;
        $licencia = $_REQUEST['licencia'] ?? null;
        $club = $_REQUEST['clubCompetidor'] ?? null;
        $peso = $_REQUEST['peso'] ?? null;
        $sexo = $_REQUEST['sexo'] ?? null;
        $estado = 0;
        $modeloCompetidor = new ModeloCompetidor();
        $competidorExistente = $modeloCompetidor->obtenerCompetidorPorDNI($dni);

        if ($competidorExistente !== null) {
        // El competidor ya existe
            header('Location: ../MensajesYErrores/errorDni.php');
            exit;
        }else{
            $competidor = new Competidor($dni, $nombre, $contrasena, $correo, $fech_nac, $licencia, $club, $peso, $sexo, $estado,null);
            $competidor->calcularCategoriaEdad($fech_nac);
            $exito = $modeloCompetidor->insertarCompetidor($competidor);
            // Redirigir o mostrar mensaje según el resultado de la inserción
            if ($exito) {
                // Redirigir a la página de éxito o mostrar mensaje
                header('Location: ../MensajesYErrores/MensajeVerificarCompetidor.php');
                exit;
            } else {
                // Redirigir a la página de formulario con mensaje de error o mostrar mensaje
                header('Location: ../MensajesYErrores/errorRegistro.php');
                exit;
            }

        } 
    }else if($rol == "coach"){
        $dni = $_REQUEST['dni'] ?? null;
        $nombre = $_REQUEST['nombre'] ?? null;
        $contrasena = $_REQUEST['contra'] ?? null;
        $correo = $_REQUEST['correo'] ?? null;
        $licencia = $_REQUEST['licencia'] ?? null;
        $clubId = $_REQUEST['club'] ?? null;
        $nuevoClubNombre = $_REQUEST['nuevoClub'] ?? null;
        $localidad = $_REQUEST['localidad'] ?? null;
        $estado = 0;
        $modeloCoach = new ModeloCoach();
        $coachExistente = $modeloCoach->obtenerCoachPorDNI($dni);
        if ($coachExistente !== null) {
        // El coach ya existe
            header('Location: ../MensajesYErrores/errorDni.php');
            exit;
        }else{
            //Si hay un club nuevo se introduce el nuevo club y el coach
            if(!empty($nuevoClubNombre)){
                $modeloClub=new ModeloClub();
                if(!empty($modeloClub->obtenerClubPorNombre($nuevoClubNombre))){
                    // Redirigir a la página de formulario con mensaje de error
                    header('Location: ../MensajesYErrores/errorClubExistente.php');
                    exit;  
                }
                $clubParaInsertar= new Club(null, $nuevoClubNombre, $localidad, null,null,null);
                $exitoclub=$modeloClub->insertarClub($clubParaInsertar);
                if($exitoclub){
                    $clubNuevoConId=$modeloClub->obtenerClubPorNombre($nuevoClubNombre);
                    $idNuevoClub=$clubNuevoConId->getIdclub();
                    $coach = new Coach($dni, $nombre, $contrasena, $correo, $idNuevoClub, $licencia, $estado,null);
                    $exito = $modeloCoach->insertarCoach($coach);
                }
                if ($exito && $exitoclub) {
                    // Redirigir a la página de éxito
                    header('Location: ../MensajesYErrores/MensajeVerificarCoach.php');
                    exit;
                }else {
                    // Redirigir a la página de formulario con mensaje de error 
                header('Location: ../MensajesYErrores/errorRegistro.php');
                    exit;
                }
            }else{
                //Si no hay nuevo club se registra solo el coach
                $coach = new Coach($dni, $nombre, $contrasena, $correo, $clubId, $licencia, $estado,null);
                $exito = $modeloCoach->insertarCoach($coach);
                // Redirigir o mostrar mensaje según el resultado de la inserción
                if ($exito) {
                    // Redirigir a la página de éxito o mostrar mensaje
                    header('Location: ../MensajesYErrores/MensajeVerificarCoach.php');
                    exit;
                } else {
                    // Redirigir a la página de formulario con mensaje de error
                header('Location: ../MensajesYErrores/errorRegistro.php');
                    exit;
                }        
            }              
        } 


    }else if($rol == "arbitro"){   
        $dni = $_REQUEST['dni'] ?? null;
        $nombre = $_REQUEST['nombre'] ?? null;
        $contrasena = $_REQUEST['contra'] ?? null;
        $correo = $_REQUEST['correo'] ?? null;
        $estado = 0;
        $modeloArbitro = new ModeloArbitro();
        $arbitroExistente = $modeloArbitro->obtenerArbitroPorDNI($dni);

        if ($arbitroExistente !== null) {
        // El arbitro ya existe
            header('Location: ../MensajesYErrores/errorDni.php');
            exit;
        }else{
            $arbitro = new Arbitro($dni, $nombre, $contrasena, $correo, $estado);
            $exito = $modeloArbitro->insertarArbitro($arbitro);
            //Mostrar mensaje según el resultado de la inserción
            if ($exito) {
                // Redirigir a la página de éxito
                header('Location: ../MensajesYErrores/MensajeVerificarArbitro.php');
                exit;
            } else {
                // Redirigir a la página de formulario con mensaje de error
                header('Location: ../MensajesYErrores/errorRegistro.php');
                exit;
            }

        }    
    }else if($rol == "adminFed"){
        $dni = $_REQUEST['dni'] ?? null;
        $nombre = $_REQUEST['nombre'] ?? null;
        $contrasena = $_REQUEST['contra'] ?? null;
        $correo = $_REQUEST['correo'] ?? null;
        $estado = 0;
        $modeloAdminFed = new ModeloAdminFed();
        $adminFedExistente = $modeloAdminFed->obtenerAdminFedPorDNI($dni);

        if ($adminFedExistente !== null) {
        // El administrador ya existe
            header('Location: ../MensajesYErrores/errorDni.php');
            exit;
        }else{
            $adminFed = new AdminFed($dni, $nombre, $contrasena, $correo, $estado);
            $exito = $modeloAdminFed->insertarAdminFed($adminFed);
            //Mostrar mensaje según el resultado de la inserción
            if ($exito) {
                // Redirigir a la página de éxito o mostrar mensaje
                header('Location: ../MensajesYErrores/MensajeVerificarAdminFed.php');
                exit;
            } else {
                // Redirigir a la página de formulario con mensaje de error o mostrar mensaje
                header('Location: ../MensajesYErrores/errorRegistro.php');
                exit;
            }
        }
    }else{
       header('Location: ../index.php');    
    }
}    