<?php
// Manejo de idioma con soporte para mantener otros parámetros GET
if (!empty($_GET['idioma'])) {
    $lang = $_GET['idioma'];
    $_SESSION["idioma"] = $lang;
}

if (isset($_SESSION["idioma"])) {
    $lang = $_SESSION["idioma"];
    require "../idioma/" . $lang . ".php";
} else {
    require "../idioma/es.php";
}
// Recolectar todos los parámetros GET excepto 'idioma' y construir la cadena de consulta
$parametros = $_GET;
unset($parametros['idioma']); // Eliminar 'idioma' si ya existe
//$queryString = http_build_query($params);