<?php
//Vista de la lista de resultaods y enfrentamientos de los torneos para usuarios no registrados

session_start();
include '../idioma/idioma.php';

    $idTorneo = $_GET['idtorneo'];
    $peso = $_GET['peso'];
    $sexo = $_GET['sexo'];
    $edad = $_GET['edad'];
    $modalidad = $_GET['modalidad'];
    include_once '../Modelo/ModeloEnfrentamiento.php';
    $modeloEnfrentamiento = new ModeloEnfrentamiento();
    $enfrentamientos = $modeloEnfrentamiento->obtenerEnfrentamientosPorCriterios($idTorneo, $modalidad, $edad, $peso, $sexo);
    include_once '../Modelo/ModeloCompetidor.php';
    $modeloCompetidor = new ModeloCompetidor();
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $lang["Resultados"]?></title>
            <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            <link href="../CSS/principal.css" rel="stylesheet" type="text/css"/>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        </head>    
        <body>
                <?php include '../header.php'; 
                    include '../menus/menuInvitado.php';    
                ?>
            <?php
            if ( !empty($enfrentamientos)) {
                // Flag para verificar si el torneo ha terminado
                $torneoTerminado = false;

                // Primero, verifica si existe al menos un enfrentamiento final con puntos no null
                foreach ($enfrentamientos as $enfrentamiento) {
                    if ($enfrentamiento->getRonda() == 1 && !is_null($enfrentamiento->getPuntos1()) && !is_null($enfrentamiento->getPuntos2())) {
                        $torneoTerminado = true;
                        break; // Sal del bucle una vez que se encuentra un enfrentamiento final válido
                    }
                }
                ?>
                <div class="container">
                    
                    <?php
                    print "<a href='listaCategoriasResultadosInvitados.php?idtorneo=" . $idTorneo . "'><button type='button' id='volverACategorias' name='volverACategorias' class='btn btn-success'>".$lang["VolverCategorias"]."</button></a>";
                    if($torneoTerminado){
                    ?>
                    <br>
                    <h2 class="textoCentrado"> <?php echo $lang["Medallas"]?></h2>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo $lang["Nombre"]?></th>
                                <th><?php echo $lang["Medalla"]?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Ordenamos enfrentamientos por ronda
                            usort($enfrentamientos, function($a, $b) {
                                return $a->getRonda() <=> $b->getRonda();
                            });

                            foreach ($enfrentamientos as $enfrentamiento) {
                                if($enfrentamiento->getRonda()==1){
                                    $dni1=$enfrentamiento->getDni1();
                                    $dni2=$enfrentamiento->getDni2();
                                    $competidor1=$modeloCompetidor->obtenerCompetidorPorDNI($dni1);
                                    $competidor2=$modeloCompetidor->obtenerCompetidorPorDNI($dni2);
                                    if($enfrentamiento->getPuntos1()>$enfrentamiento->getPuntos2()){
                                        print "<tr>";
                                        print "<td>" . $competidor1->getNombre() . "</td>";
                                        print "<td><img src='../img/medalla-de-oro.png' width='30em' height='30em'></td>";
                                        print "</tr>";
                                        print "<tr>";
                                        print "<td>" . $competidor2->getNombre() . "</td>";
                                        print "<td><img src='../img/medalla-de-plata.png' width='30em' height='30em'></td>";
                                        print "</tr>";
                                    }else{
                                        print "<tr>";
                                        print "<td>" . $competidor2->getNombre() . "</td>";
                                        print "<td><img src='../img/medalla-de-oro.png' width='30em' height='30em'></td>";
                                        print "</tr>";
                                        print "<tr>";
                                        print "<td>" . $competidor1->getNombre() . "</td>";
                                        print "<td><img src='../img/medalla-de-plata.png' width='30em' height='30em'></td>";
                                        print "</tr>";
                                    }
                                }else if($enfrentamiento->getRonda()==2){
                                    $dni1=$enfrentamiento->getDni1();
                                    $dni2=$enfrentamiento->getDni2();
                                    $competidor1=$modeloCompetidor->obtenerCompetidorPorDNI($dni1);
                                    $competidor2=$modeloCompetidor->obtenerCompetidorPorDNI($dni2);
                                    if($enfrentamiento->getPuntos1()>$enfrentamiento->getPuntos2()){
                                        print "<tr>";
                                        print "<td>" . $competidor2->getNombre() . "</td>";
                                        print "<td><img src='../img/medalla-de-bronce.png' width='30em' height='30em'></td>";
                                        print "</tr>";
                                    }else{
                                        print "<tr>";
                                        print "<td>" . $competidor1->getNombre() . "</td>";
                                        print "<td><img src='../img/medalla-de-bronce.png' width='30em' height='30em'></td>";
                                        print "</tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                     }
                     ?>
                    <h2 class="textoCentrado"><?php echo $lang["TodosEnfrentamientos"]?></h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php echo $lang["Competidor"]?> 1</th>
                                <th><?php echo $lang["Competidor"]?> 2</th>
                                <th><?php echo $lang["Puntos"]?> 1</th>
                                <th><?php echo $lang["Puntos"]?> 2</th>
                                <th><?php echo $lang["Ronda"]?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($enfrentamientos as $enfrentamiento) {
                                $dni1=$enfrentamiento->getDni1();
                                $dni2=$enfrentamiento->getDni2();
                                $competidor1=$modeloCompetidor->obtenerCompetidorPorDNI($dni1);
                                if($dni2!==null){
                                   $competidor2=$modeloCompetidor->obtenerCompetidorPorDNI($dni2);
                                }
                                print "<tr>";
                                print "<td>" . $competidor1->getNombre() . "</td>";
                                 if($dni2==null){
                                    print "<td>".$lang["SinCombate"]."</td>";
                                 }else{
                                   print "<td>" . $competidor2->getNombre() . "</td>";
                                 }
                                print "<td>" . $enfrentamiento->getPuntos1() . "</td>";
                                print "<td>" . $enfrentamiento->getPuntos2() . "</td>";
                                if ($enfrentamiento->getRonda() == 3) {
                                    print "<td>".$lang["CuartosFinal"]."</td>";
                                } else if ($enfrentamiento->getRonda() == 2) {
                                    print "<td>".$lang["SemiFinal"]."</td>";
                                } else if ($enfrentamiento->getRonda() == 1) {
                                    print "<td>".$lang["Final"]."</td>";
                                }
                                print "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                print "<h1>".$lang["NoHayResultados"]."</h1>";
            }
            ?>
        </body>
    </html>
  
