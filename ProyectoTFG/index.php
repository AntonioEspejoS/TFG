<?php
//Vista del index
session_start();
// Manejo de idioma con soporte para mantener otros parámetros GET
if (!empty($_GET['idioma'])) {
    $lang = $_GET['idioma'];
    $_SESSION["idioma"] = $lang;
}
if (isset($_SESSION["idioma"])) {
    $lang = $_SESSION["idioma"];
    require "idioma/" . $lang . ".php";
} else {
    require "idioma/es.php";
}
// Recolectar todos los parámetros GET excepto 'idioma' y construir la cadena de consulta
$parametros = $_GET;
unset($parametros['idioma']); // Eliminar 'idioma' si ya existe
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kickboxing Tourney</title>
          <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="/ProyectoTFG/CSS/index.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include 'header.php';?>
        <section>
 
            <div class="row" id="contenido">
                <div class="col-md-1 col-sm-1 col-xs-1"></div>
                <div class="col-md-10 col-sm-10 col-xs-10" id="login">
                    <h1><?php echo $lang["Bienvenido"] ?></h1> 
                    <form action="sesiones/controladorSesiones.php" method="POST">
                        <div class="form-group">
                            <label style=" float:left;" for="dni">DNI:</label> <div id="errorDNI" class="errorCampo"></div>
                            <input type="dni" name="dni" class="form-control" id="dni" required="required">
                        </div>
                        <div class="form-group">
                            <label for="contra"><?php echo $lang["Pass"]?>:</label>
                            <input type="password" name="contra" class="form-control" id="contra" required="required" >
                            <!-- Enlace para recuperar la contraseña -->
                            <div style="text-align: right;">
                                <a href="registro/recuperarPass.php"><?php echo $lang["Recuperar"]; ?> <?php echo $lang["PassMini"]; ?></a>
                            </div>
                        </div>      
                        
                        <div class="form-row">
                            <div class="col">
                                <button id="enviar" type="submit" name="Entrar" class="btn btn-success botonFormulario"><?php echo $lang["Entrar"]?></button>
                            </div>
                            <div class="col">
                                <a href="registro/registrarse.php">
                                    <button type="button" class="btn btn-primary botonFormulario"><?php echo $lang["Registrarse"]?></button>
                                </a>
                            </div>
                            <div class="col">
                                <a href="Invitado/listaTorneosResultadosInvitados.php"> 
                                    <button type="button" class="btn btn-info botonFormulario"><?php echo $lang["VerTorneos"]?></button>
                                </a>
                            </div>
                        </div>     
                        
                    </form>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1"></div>
            </div>
        </section>
        <?php include 'footer.php'; ?>
    </body>
</html>
