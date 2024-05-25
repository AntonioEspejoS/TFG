<?php
session_start();
// Manejo de la selección del rol
if (!isset($_SESSION['usuario']) || !isset($_POST['rolSeleccionado'])) {
    header('Location: ../index.php'); // Redirigir a la página de inicio si no cumple los requisitos
    exit();
}
$dniUsuario = $_SESSION['usuario'];
$rolSeleccionado = $_POST['rolSeleccionado'];
$paginaDestino = $_SESSION['roles'][$rolSeleccionado];

// Asignar el DNI a la variable de sesión específica del rol seleccionado
$_SESSION[$rolSeleccionado] = $dniUsuario;

// Redirigir al perfil correspondiente al rol seleccionado
header('Location: ../perfiles/' . $paginaDestino);
exit();
