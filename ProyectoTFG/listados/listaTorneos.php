<?php
//Vista de la lista de torneos no finalizados
session_start();
include '../idioma/idioma.php';

if (isset($_SESSION["competidor"]) || isset($_SESSION["coach"]) || isset($_SESSION["arbitro"])) {
    include_once '../Modelo/ModeloBD.php';
    //Sacar torneos
    include_once '../Modelo/ModeloTorneo.php'; 
    $modeloTorneo = new ModeloTorneo();
    $torneos = $modeloTorneo->obtenerTorneosNoFinalizados();      
    if (isset($_SESSION["competidor"])){
        $dni = $_SESSION["competidor"];
        //Obtener donde está registrado el competidor
        include_once '../Modelo/ModeloRegistrado.php'; 
        $modeloRegistrado = new ModeloRegistrado();
        $registrosDeCompetidor = $modeloRegistrado->obtenerRegistrosPorDni($dni);
        //Sacar competidor
        include_once '../Modelo/ModeloCompetidor.php'; 
        $competidorModelo = new ModeloCompetidor();
        $competidor = $competidorModelo->obtenerCompetidorPorDNI($dni);
        $sexoCompetidor=$competidor->getSexo();
        include_once '../Modelo/ModeloCategoria.php';
        $modeloCategoria = new ModeloCategoria();
    }
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo $lang["ListaTorneos"]?></title>
            <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            <link href="/ProyectoTFG/CSS/principal.css" rel="stylesheet" type="text/css"/>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        </head>
        <body>
            <?php include '../header.php'; ?>
            <?php 
            if(isset($_SESSION["competidor"])){
                include '../menus/menuCompetidor.php';    
                $dni = $_SESSION["competidor"];
            }else if( isset($_SESSION["coach"])){
                include '../menus/menuCoach.php';
                $dni = $_SESSION["coach"];
            } else if(isset($_SESSION["arbitro"])){
                
                include '../menus/menuArbitro.php';
            }
            ?>
            <section>
            <?php    
            if (empty($torneos)) {
                print "<h2 class='textoCentrado'>".$lang["NoHayTorneosProximamente"]."</h2>";
            }else{
            ?>
                <div class="container">  
                    <h2 class="textoCentrado"><?php echo $lang["Torneos"]?></h2>
                    <div class="table-responsive">

                    <table class="table table-striped table-hover">
                        <thead>
                            <?php

                                if (isset($_SESSION["competidor"])) {
                                    print "<tr>";
                                    print "<td></td>";
                                    print "<td></td>";
                                    print "<td></td>";
                                    print "<td><strong>Full contact</strong></td>";
                                    print "<td></td>";
                                    print "<td><strong>Low kick</strong></td>";
                                    print "<td></td>";
                                    print "</tr>";
                                }
                             ?>
                            <tr>
                                <th><?php echo $lang["Torneo"]?></th>
                                <th><?php echo $lang["LimiteInscripcion"]?></th>
                                <th><?php echo $lang["Fecha"]?></th>

                                <?php
                                if (isset($_SESSION["competidor"])) {
                                    print "<td><strong>".$lang["PlazasDisponibles"]."</strong></td>";
                                    print "<td><strong>".$lang["Inscripcion"]."</strong></td>";
                                    print "<td><strong>".$lang["PlazasDisponibles"]."</strong></td>";
                                    print "<td><strong>".$lang["Inscripcion"]."</strong></td>";
                                }else if(isset($_SESSION["arbitro"])){
                                    print "<td><strong>".$lang["Categorias"]."</strong></td>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($torneos as $torneo) {
                                $plazasTorneo=$torneo->getPlazas();
                                $fechaInscripcion = date('d/m/Y', strtotime($torneo->getFechaInscripcion()));
                                $fechaTorneo = date('d/m/Y', strtotime($torneo->getFechatorneo()));     
                                print "<tr>";
                                
                                print "<td>" . $torneo->getDescripcion() . "</td>";
                                print "<td>" . $fechaInscripcion . "</td>";
                                print "<td class='text-nowrap'>" . $fechaTorneo . "</td>";
                                //PARA EL COMPETIDOR
                                if (isset($_SESSION["competidor"])) {
                                    $ok = false;
                                    $okLow = false;
                                    $categoriasTorneo = $modeloCategoria->obtenerCategoriasPorTorneo($torneo->getIdtorneo());
                                    $puedeInscribirseFull = false;
                                    $puedeInscribirseLow = false;

                                    // Verifica si existen categorías que coincidan con los datos del competidor
                                    foreach ($categoriasTorneo as $categoria) {
                                        
                                     
                                        if ($categoria->getSexo() == $sexoCompetidor) {
                                            if ($categoria->getEdad() == $competidor->getCatedad()) {
                                                if ($categoria->getModalidad() == 'fullcontact') {
                                                    $puedeInscribirseFull = true;
                                                }
                                                if ($categoria->getModalidad() == 'lowkick') {
                                                    $puedeInscribirseLow = true;
                                                }
                                            }
                                        }
                                    }       
                                    
                                    if($puedeInscribirseFull){
                                            //FULL CONTACT
                                        $plazasOcupadasFull=$modeloRegistrado->contarFullContact($torneo->getIdtorneo(), $competidor);
                                        $plazasDisponiblesFull = ($plazasTorneo - (int) $plazasOcupadasFull);
                                        print "<td>" . $plazasDisponiblesFull . "</td>";
                                        /////////////////////////////////////////////////////
                                        if ($torneo->getEstado() == 1) {
                                            if ($registrosDeCompetidor != null) {
                                                foreach ($registrosDeCompetidor as $registro) {
                                                    if ($torneo->getIdtorneo() == $registro->getIdtorneo() && $registro->getModalidad()=="fullcontact") {
                                                        $ok = true;
                                                    }
                                                }
                                                if ($ok) {//Compruebo si ya estoy inscrito
                                                    print "<td><a href='controladorListaTorneos.php?idtorneo=" . $torneo->getIdtorneo() . "&modalidad=fullcontact&accion=desinscribirse'><button type='button' name='inscribirse' class='btn btn-danger'>".$lang["Desinscribirse"]."</button></a></td>";
                                                } else {
                                                    if ($plazasOcupadasFull > ($plazasTorneo-1)) {
                                                        print "<td><button type='button' name='inscribirse' class='btn btn-secondary' disabled>".$lang["PlazasOcupadas"]."</button></td>";
                                                    } else {
                                                        print "<td><a href='controladorListaTorneos.php?idtorneo=" . $torneo->getIdtorneo() . "&modalidad=fullcontact&accion=inscribirse'><button type='button' name='inscribirse' class='btn btn-success'>".$lang["Inscribirse"]."</button></a></td>";
                                                    }
                                                }
                                            } else {
                                                if ($plazasOcupadasFull > ($plazasTorneo-1)) {
                                                    print "<td><button type='button' name='inscribirse' class='btn btn-secondary' disabled>".$lang["PlazasOcupadas"]."</button></td>";
                                                } else {

                                                    print "<td><a href='controladorListaTorneos.php?idtorneo=" . $torneo->getIdtorneo() . "&modalidad=fullcontact&accion=inscribirse'><button type='button' name='inscribirse' class='btn btn-success'>".$lang["Inscribirse"]."</button></a></td>";
                                                }
                                            }
                                        } elseif ($torneo->getEstado() == 0) {
                                            print "<td><button type='button'  class='btn btn-secondary' disabled>".$lang["Cerrada"]."</button></td>";
                                        }
                                    }else{
                                                    print "<td colspan='2'>".$lang["NoPuedesInscribirte"]."</td>";

                                        
                                    }
                                    
                         
                                    
                                    if($puedeInscribirseLow){
                                            //LOWKICK
                                        $plazasOcupadasLow=$modeloRegistrado->contarLowKick($torneo->getIdtorneo(), $competidor);
                                        $plazasDisponiblesLow = ($plazasTorneo - (int) $plazasOcupadasLow);
                                        print "<td>" . $plazasDisponiblesLow . "</td>";
                                        if ($torneo->getEstado() == 1) {
                                            if ($registrosDeCompetidor != null) {
                                                $okLow;
                                                foreach ($registrosDeCompetidor as $registro) {
                                                    if ($torneo->getIdtorneo() == $registro->getIdtorneo()&& $registro->getModalidad()=="lowkick") {
                                                        $okLow = true;
                                                    }
                                                }
                                                if ($okLow) {
                                                    print "<td><a href='controladorListaTorneos.php?idtorneo=" . $torneo->getIdtorneo() . "&modalidad=lowkick&accion=desinscribirse'><button type='button' name='inscribirse' class='btn btn-danger'>".$lang["Desinscribirse"]."</button></a></td>";
                                                } else {
                                                    if ($plazasOcupadasLow > ($plazasTorneo-1)) {
                                                        print "<td><button type='button' name='inscribirse' class='btn btn-secondary' disabled>Plazas ocupadas</button></td>";
                                                    } else {
                                                        print "<td><a href='controladorListaTorneos.php?idtorneo=" . $torneo->getIdtorneo() . "&modalidad=lowkick&accion=inscribirse'><button type='button' name='inscribirse' class='btn btn-success'>".$lang["Inscribirse"]."</button></a></td>";
                                                    }
                                                }
                                            } else {
                                                if ($plazasOcupadasLow > ($plazasTorneo-1)) {
                                                    print "<td><button type='button' name='inscribirse' class='btn btn-danger'>Plazas ocupadas</button></td>";
                                                } else {
                                                    print "<td><a href='controladorListaTorneos.php?idtorneo=" . $torneo->getIdtorneo(). "&modalidad=lowkick&accion=inscribirse'><button type='button' name='inscribirse' class='btn btn-success'>".$lang["Inscribirse"]."</button></a></td>";
                                                }
                                            }
                                        } elseif ($torneo->getEstado() == 0) {
                                            print "<td><button type='button'  class='btn btn-secondary' disabled>".$lang["Cerrada"]."</button></td>";
                                        }
                                    }else{
                                       print "<td colspan='2'>".$lang["NoPuedesInscribirte"]."</td>";

                                    }
                                    
                                //PARA EL ARBITRO
                                }else if(isset($_SESSION["arbitro"])){
                                    include_once '../Modelo/ModeloGestion.php';
                                    $modeloGestion = new ModeloGestion();
                                    if($modeloGestion->existeGestion($torneo->getIdtorneo(), $_SESSION["arbitro"])){
                                        if ($torneo->getEstado() == 0) {
                                            print "<td><a href='../Torneo/torneoCategorias.php?idtorneo=" . $torneo->getIdtorneo(). "'><button type='button' name='comenzar' class='btn btn-success'>".$lang["GestionarCombates"]."</button></a></td>";
                                        }else{
                                            print "<td><button type='button' name='comenzar' class='btn btn-secondary' disabled>".$lang["InscripcionesAbiertas"]."</button></td>";
                                        }
                                        
                                    }else{
                                        print "<td>".$lang["NoTienesAcceso"]."</td>";

                                    }
                                    
                                }
                                print "<tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </section>
            <?php
            }
            ?>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}    
