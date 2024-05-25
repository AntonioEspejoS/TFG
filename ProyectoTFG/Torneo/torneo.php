<?php
//Vista de los combates dentro de una categoría para que los árbitros los gestionen.
//Se mostrarán una cantidad de cuadros de competición dependiendo del número de participantes de una categoría
session_start();
include '../idioma/idioma.php';

if (isset($_SESSION["arbitro"])) {
    include_once '../Modelo/ModeloRegistrado.php';
    include_once '../Modelo/ModeloEnfrentamiento.php';

    $idTorneo = $_GET['idtorneo'];
    $peso = $_GET['peso'];
    $sexo = $_GET['sexo'];
    $edad = $_GET['edad'];
    $modalidad = $_GET['modalidad'];
    //Obtener competidores registrados
    $modeloRegistrado = new ModeloRegistrado();
    $competidores = $modeloRegistrado->obtenerListaCompetidoresRegistrados($idTorneo,$peso,$sexo,$edad,$modalidad);
    $numeroCompetidores = count($competidores);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $lang["Torneos"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link href="../CSS/torneo.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include '../header.php'; ?>
        <section>
            <div class="container">
                <?php
                print "<input class='oculto' type='text' id='idTorneo' name='idTorneo' value='" . $idTorneo . "'>";
                print "<input class='oculto' type='text' id='peso' name='peso' value='" . $peso . "'>";
                print "<input class='oculto' type='text' id='sexo' name='sexo' value='" . $sexo . "'>";
                print "<input class='oculto' type='text' id='edad' name='edad' value='" . $edad . "'>";
                print "<input class='oculto' type='text' id='modalidad' name='modalidad' value='" . $modalidad . "'>";
                if ($numeroCompetidores == 0) {
                    ?>
                    <h1 style="color: white; text-align: center;">No hay competidores</h1>
                    <?php
                } else if ($numeroCompetidores == 1) {
                    ?>
                    <h1 style="color: white; text-align: center;">Solo hay un competidor</h1>
                    <?php
                } else if ($numeroCompetidores ==  2) {
                    ?>
                   <!--Cruces para dos competidores-->
                    <div id="TorneoModelo2">
                        <table>
                            <!--1-->
                            <tr>
                                <td id="0" class="nombreRojo" ROWSPAN=2 >------</td>
                                <?php print "<input class='oculto' type='text' id='dni0' name='dni0' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p0" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td> 
                            </tr>
                            <!--2-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input class="boton" id="b0" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="2" class="nombreGanador" ROWSPAN=2>------</td>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                            </tr>
                            <!--3-->
                            <tr>
                                <td id="1" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni1' name='dni1' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p1" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>                    
                        </table>
                    </div>

                    <script src="../Scripts/TorneoPlantilla2.js" type="text/javascript"></script>
                    <?php
                } else if ($numeroCompetidores ==  3) {
                    ?>
                    <!--Cruces para tres competidores-->
                    <div id="TorneoModelo3">
                        <table>
                            <!--1-->
                            <tr>
                                <td id="0" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni0' name='dni0' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p0" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>
                            </tr>
                            <!--2-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b0"  class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="3" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni3' name='dni3' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p3" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                                <td class="lineaArriba"></td> 
                            </tr>
                            <!--3-->
                            <tr>
                                <td id="1" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni1' name='dni1' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p1" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>
                            <!--4-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b1" class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="4" class="nombreGanador" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni4' name='dni4' value=''>"; ?>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                            </tr>
                            <!--5-->
                            <tr>
                                <td id="2" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni2' name='dni2' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p2" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaRecta"></td>  
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                            </tr>
                        </table>
                    </div>
                    <script src="../Scripts/TorneoPlantilla3.js" type="text/javascript"></script>
                    <?php
                } else if ($numeroCompetidores ==  4) {
                    ?>
                    <!--Cruces para cuatro competidores-->
                    <div id="TorneoModelo4">
                        <table>
                            <!--1-->
                            <tr>
                                <td id="0" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni0' name='dni0' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p0" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>

                            </tr>
                            <!--2-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b0"  class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="4" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni4' name='dni4' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p4" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                                <td class="lineaArriba"></td> 
                            </tr>
                            <!--3-->
                            <tr>
                                <td id="1" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni1' name='dni1' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p1" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>
                            <!--4-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b2" class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="6" class="nombreGanador" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni6' name='dni6' value=''>"; ?>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                            </tr>
                            <!--5-->
                            <tr>
                                <td id="2" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni2' name='dni2' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p2" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>  
                            </tr>
                            <!--6-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b1" class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="5" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni5' name='dni5' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p5" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                                <td></td> 
                            </tr>
                            <!--7-->
                            <tr>
                                <td id="3" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni3' name='dni3' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p3" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>

                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>
                        </table>
                    </div>
                    <script src="../Scripts/TorneoPlantilla4.js" type="text/javascript"></script>

                    <?php
                } else if ($numeroCompetidores ==  5) {
                    ?>
                    <!--Cruces para cinco competidores-->
                    <div id="TorneoModelo5">
                        <table>
                            <!--1-->
                            <tr>
                                <td id="0" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni0' name='dni0' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p0" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>

                            </tr>
                            <!--2-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b0"  class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="5" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni5' name='dni5' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p5" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12--> 
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td></td>
                                <td  class="puntuacionRojo2" ROWSPAN=2><input id="p3" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="3" class="nombreRojo2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni3' name='dni3' value=''>"; ?>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                                <td class="lineaArriba"></td> 
                                <td class="lineaArriba2"></td>
                            </tr>
                            <!--3-->
                            <tr>
                                <td id="1" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni1' name='dni1' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p1" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>

                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>
                            <!--4-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b2" class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td></td>
                                <td id="6" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni6' name='dni6' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p6" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td id="8" class="nombreGanador" ROWSPAN=2>------</td><!--12-->
                                <?php print "<input class='oculto' type='text' id='dni8' name='dni8' value=''>"; ?>

                                <td></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p7" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="7" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni7' name='dni7' value=''>"; ?>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b1" class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaArriba"></td>
                            </tr>
                            <!--5-->
                            <tr>
                                <td id="2" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni2' name='dni2' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p2" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaRecta"></td>  
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td></td> 
                            </tr>
                            <!--6-->
                            <tr>

                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b3" class="boton" type=image src="../img/guante.png"></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="lineaAbajo2"></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p4" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="4" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni4' name='dni4' value=''>"; ?>

                            </tr> 

                            <tr>
                                <td></td>
                            </tr>



                        </table>
                    </div>
                    <script src="../Scripts/TorneoPlantilla5.js" type="text/javascript"></script>



                    <?php
                } else if ($numeroCompetidores ==  6) {
                    ?>
                    <!--Cruces para seis competidores-->
                    <div id="TorneoModelo6">
                        <table>
                            <!--1-->
                            <tr>
                                <td id="0" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni0' name='dni0' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p0" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>

                            </tr>
                            <!--2-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b0"  class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="6" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni6' name='dni6' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p6" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12--> 
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td></td>
                                <td  class="puntuacionRojo2" ROWSPAN=2><input id="p4" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="4" class="nombreRojo2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni4' name='dni4' value=''>"; ?>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                                <td class="lineaArriba"></td> 
                                <td class="lineaArriba2"></td>
                            </tr>
                            <!--3-->
                            <tr>
                                <td id="1" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni1' name='dni1' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p1" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>

                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>
                            <!--4-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b3" class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td></td>
                                <td id="8" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni8' name='dni8' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p8" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td id="10" class="nombreGanador" ROWSPAN=2>------</td><!--12-->
                                <td></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p9" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="9" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni9' name='dni9' value=''>"; ?>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b2" class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaArriba"></td>
                            </tr>
                            <!--5-->
                            <tr>
                                <td id="2" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni2' name='dni2' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p2" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2> </td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2 class="bordeDerecha"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>  
                            </tr>
                            <!--6-->
                            <tr>

                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b1"  class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2 class="bordeDerecha"></td>
                                <td ></td>
                                <td id="7" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni7' name='dni7' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p7" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b4"  class="boton" type=image src="../img/guante.png"></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="lineaAbajo2"></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p5" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="5" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni5' name='dni5' value=''>"; ?>

                            </tr> 

                            <tr>
                                <td class="lineaRecta"></td>
                                <td></td>
                            </tr>
                            <!--7-->
                            <tr>
                                <td id="3" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni3' name='dni3' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p3" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>

                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>
                        </table>
                    </div>
                    <script src="../Scripts/TorneoPlantilla6.js" type="text/javascript"></script>
                    <?php
                } else if ($numeroCompetidores == 7) {
                    ?>
                    <!--Cruces para siete competidores-->
                    <div id="TorneoModelo7">
                        <table>
                            <!--1-->
                            <tr>
                                <td id="0" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni0' name='dni0' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p0" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--20-->
                                <td></td>
                                <td  class="puntuacionRojo2" ROWSPAN=2><input id="p4" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="4" class="nombreRojo2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni4' name='dni4' value=''>"; ?>

                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>
                                <td class="lineaArriba2"></td>

                            </tr>
                            <!--2-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b0"  class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="6" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni6' name='dni6' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p6" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12--> 
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td></td>
                                <td  class="puntuacionRojo2" ROWSPAN=2><input id="p8" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="8" class="nombreRojo2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni8' name='dni8' value=''>"; ?>
                                <td></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b2" class="boton" type=image src="../img/guante.png"></td>

                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                                <td class="lineaArriba"></td> 
                                <td class="lineaArriba2"></td>
                                <td class="lineaRecta"></td>
                            </tr>
                            <!--3-->
                            <tr>
                                <td id="1" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni1' name='dni1' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p1" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="lineaAbajo2"></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p5" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="5" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni5' name='dni5' value=''>"; ?>
                            </tr> 
                            <tr>
                                <td></td> 
                                <td></td>
                            </tr>
                            <!--4-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b3" class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td></td>
                                <td id="10" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni10' name='dni10' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p10" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td id="12" class="nombreGanador" ROWSPAN=2>------</td><!--12-->
                                <td></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p11" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="11" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni11' name='dni11' value=''>"; ?>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b4" class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaArriba"></td>
                            </tr>
                            <!--5-->
                            <tr>
                                <td id="2" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni2' name='dni2' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p2" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2> </td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2 class="bordeDerecha"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>  
                            </tr>
                            <!--6-->
                            <tr>

                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b1"  class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2 class="bordeDerecha"></td>
                                <td ></td>
                                <td id="7" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni7' name='dni7' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p7" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b5" class="boton" type=image src="../img/guante.png"></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="lineaAbajo2"></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p9" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="9" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni9' name='dni9' value=''>"; ?>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 

                            <tr>
                                <td class="lineaRecta"></td>
                                <td></td>
                            </tr>
                            <!--7-->
                            <tr>
                                <td id="3" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni3' name='dni3' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p3" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>
                        </table>
                    </div>
                    <script src="../Scripts/TorneoPlantilla7.js" type="text/javascript"></script>
                    <?php
                } else if ($numeroCompetidores == 8) {
                    ?>
                    <!--Cruces para ocho competidores-->
                    <div id="TorneoModelo8">
                        <table>
                            <!--1-->
                            <tr>
                                <td id="0" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni0' name='dni0' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p0" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--20-->
                                <td></td>
                                <td  class="puntuacionRojo2" ROWSPAN=2><input id="p4" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="4" class="nombreRojo2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni4' name='dni4' value=''>"; ?>

                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>
                                <td class="lineaArriba2"></td>

                            </tr>
                            <!--2-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b0"  class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td class="lineaCentralArriba"></td>
                                <td id="8" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni8' name='dni8' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p8" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12--> 
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td></td>
                                <td  class="puntuacionRojo2" ROWSPAN=2><input id="p10" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="10" class="nombreRojo2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni10' name='dni10' value=''>"; ?>
                                <td></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b2" class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaCentralABajo"></td> 
                                <td class="lineaArriba"></td> 
                                <td class="lineaArriba2"></td>
                                <td class="lineaRecta"></td>
                            </tr>
                            <!--3-->
                            <tr>
                                <td id="1" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni1' name='dni1' value=''>"; ?>
                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p1" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="lineaAbajo2"></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p5" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="5" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni5' name='dni5' value=''>"; ?>
                            </tr> 
                            <tr>
                                <td></td> 
                                <td></td>
                            </tr>
                            <!--4-->
                            <tr>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b4" class="boton" type=image src="../img/guante.png"></td>
                                <td class="bordeDerecha" ROWSPAN=2></td>
                                <td></td>
                                <td id="12" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni12' name='dni12' value=''>"; ?>
                                <td class="puntuacionRojo" ROWSPAN=2><input id="p12" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td id="14" class="nombreGanador" ROWSPAN=2>------</td><!--12-->
                                <td></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p13" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="13" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni13' name='dni13' value=''>"; ?>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b5" class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2></td>
                            </tr> 
                            <tr>
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaRecta"></td> 
                                <td class="lineaArriba"></td>
                            </tr>
                            <!--5-->
                            <tr>
                                <td id="2" class="nombreRojo" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni2' name='dni2' value=''>"; ?>
                                <td  class="puntuacionRojo" ROWSPAN=2><input id="p2" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2> </td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2 class="bordeDerecha"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td></td>
                                <td  class="puntuacionRojo2" ROWSPAN=2><input id="p6" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="6" class="nombreRojo2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni6' name='dni6' value=''>"; ?>
                            </tr> 
                            <tr>
                                <td class="lineaArriba"></td>  
                                <td class="lineaArriba2"></td>  
                            </tr>
                            <!--6-->
                            <tr>

                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b1"  class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2 class="bordeDerecha"></td>
                                <td ></td>
                                <td id="9" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni9' name='dni9' value=''>"; ?>
                                <td class="puntuacionAzul" ROWSPAN=2><input id="p9" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2><input  id="b6"  class="boton" type=image src="../img/guante.png"></td><!--12-->
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="lineaAbajo2"></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p11" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="11" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni11' name='dni11' value=''>"; ?>
                                <td></td>
                                <td class="bordeIzquierda" ROWSPAN=2></td>
                                <td ROWSPAN=2><input id="b3" class="boton" type=image src="../img/guante.png"></td>
                                <td ROWSPAN=2></td>

                            </tr> 
                            <tr>
                                <td class="lineaRecta"></td>
                                <td></td>
                                <td></td>
                                <td class="lineaRecta"></td>
                            </tr>
                            <!--7-->
                            <tr>
                                <td id="3" class="nombreAzul" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni3' name='dni3' value=''>"; ?>

                                <td  class="puntuacionAzul" ROWSPAN=2><input id="p3" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td class="lineaAbajo"></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td ROWSPAN=2></td>
                                <td class="lineaAbajo2"></td>
                                <td  class="puntuacionAzul2" ROWSPAN=2><input id="p7" type="text" maxlength="2" onkeypress="return valida(event)"></td>
                                <td id="7" class="nombreAzul2" ROWSPAN=2>------</td>
                                <?php print "<input class='oculto' type='text' id='dni7' name='dni7' value=''>"; ?>
                            </tr> 
                            <tr>
                                <td></td> 
                            </tr>
                        </table>
                    </div>
                       <script src="../Scripts/TorneoPlantilla8.js" type="text/javascript"></script>
                    <?php
                }
                print "<br>";
                ?>
                <a href="torneoCategorias.php?idtorneo=<?php echo$idTorneo;?>"><button  type="button"  class="btn btn-success botonFormulario"><?php echo $lang["VolverACategorias"]?></button></a>
               <script src="../Scripts/TorneoValidarPuntos.js" type="text/javascript"></script>
            </div>
        </section>
    </body>
</html>
  <?php
} else {
    header("Location: ../index.php");
}     