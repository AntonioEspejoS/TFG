<?php
session_start();
include_once '../Modelo/ModeloCompetidor.php';
include_once '../Modelo/ModeloCoach.php';
include_once '../Modelo/ModeloArbitro.php';
include_once '../Modelo/ModeloAdminFed.php';
include_once '../Modelo/ModeloAdmin.php';
///////////////////////////////////////////
$dni = (string) ($_REQUEST['dni']);
$contra = (string) ($_REQUEST['contra']);

// Verificamos las credenciales y obtenemos los roles
$roles = verificarCredencialesYObtenerRoles($dni, $contra);

if (empty($roles)) {
    header("Location: ../MensajesYErrores/errorCredenciales.php");
} else {
    $cantidadRoles = count($roles);
    if ($cantidadRoles == 1) {
        // Solo tiene un rol, redirigir directamente al perfil correspondiente
        $rol = key($roles);
        $_SESSION['roles'] = $roles;
        $_SESSION['usuario'] = $dni;
        $_SESSION[$rol] = $dni;
        header("Location: ../perfiles/" . $roles[$rol]);
    } else if ($cantidadRoles > 1) {
        // Tiene múltiples roles, redirigir a la página de selección de roles
        $_SESSION['roles'] = $roles;
        $_SESSION['usuario'] = $dni;
        header("Location: seleccionRol.php");
    }
}


//Función para verificar las credenciales de los distintos roles que tenga un usuario
//Devuelve los roles que tiene el usuario y el fichero del perfil de cada uno para redireccionar
function verificarCredencialesYObtenerRoles($dni, $contrasena) {
    $roles = [];
    // Instanciamos los modelos
    $modeloCompetidor = new ModeloCompetidor();
    $modeloCoach = new ModeloCoach();
    $modeloArbitro = new ModeloArbitro();
    $modeloAdminFed = new ModeloAdminFed();
    $modeloAdmin = new ModeloAdmin();   
    // Verificamos las credenciales para cada rol
    if ($modeloCompetidor->verificarCredenciales($dni, $contrasena)) {
        $roles['competidor'] = 'perfilCompetidor.php';
    }
    if ($modeloCoach->verificarCredenciales($dni, $contrasena)) {
        $roles['coach'] = 'perfilCoach.php';
    }
    if ($modeloArbitro->verificarCredenciales($dni, $contrasena)) {
        $roles['arbitro'] = 'perfilArbitro.php';
    }
    if ($modeloAdminFed->verificarCredenciales($dni, $contrasena)){
        $roles['adminFed'] = 'perfilAdminFed.php';
    }
    if($modeloAdmin->verificarCredenciales($dni, $contrasena)){
        $roles['admin'] = 'perfilAdmin.php';
    }
    return $roles;
}