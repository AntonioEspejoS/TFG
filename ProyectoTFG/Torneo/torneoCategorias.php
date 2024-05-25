<?php
//Vista de las categorias de un torneo que tiene competidores registrados para que el árbitro pueda gestionar los combates
session_start();
include '../idioma/idioma.php';
require_once '../Modelo/ModeloCategoria.php';
require_once '../Modelo/ModeloRegistrado.php';
if (!isset($_SESSION["arbitro"])) {
    header("Location: ../index.php");
    exit();
}
$idTorneo = isset($_GET['idtorneo']) ? $_GET['idtorneo'] : null;

$modeloCategoria = new ModeloCategoria();
$modeloRegistrado = new ModeloRegistrado();
$categorias = $modeloCategoria->obtenerCategoriasPorTorneo($idTorneo);
$todosCompetidores=$modeloRegistrado->obtenerListaCompetidoresRegistradosTorneo($idTorneo);
$numeroTodosCompetidores=count($todosCompetidores);
// Organizar las categorías por modalidad, edad y sexo
$categoriasOrganizadas = [];
foreach ($categorias as $categoria) {
    $modalidad = $categoria->getModalidad();
    $edad = $categoria->getEdad();
    $sexo = $categoria->getSexo();
    $categoriasOrganizadas[$modalidad][$edad][$sexo][] = $categoria;
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $lang["ListaCategorias"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link href="/ProyectoTFG/CSS/index.css" rel="stylesheet" type="text/css"/> 
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header class="headerTorneos">
            <div class="row" id="cabecera">
                <div class="col-md-2 col-sm-3 col-xs-3"></div>
                <div class="col-md-8 col-sm-6 col-xs-6" id="logo"> 
                    <img  src="/ProyectoTFG/img/NOMBRERecortado.png"  class="img-fluid"/>
                </div>
       <div class="col-md-2 col-sm-3 col-xs-3">
            <div id="banderas">
                <?php
                //Compruebo si estamos en index ya que las rutas son distintas porque está en la raiz
                if(basename($_SERVER['PHP_SELF']) == "index.php"){
                    $rutaImagenes="img/";
                }else{
                    $rutaImagenes="../img/"; 
                }     
                $esUrl = '?' . http_build_query(array_merge($parametros, ['idioma' => 'es']));
                $inUrl = '?' . http_build_query(array_merge($parametros, ['idioma' => 'in']));
                ?>
                <a href="<?php echo $esUrl; ?>"><img src="<?php echo $rutaImagenes; ?>espana.png" class="bandera" alt="Español"></a>
                <a href="<?php echo $inUrl; ?>"><img src="<?php echo $rutaImagenes; ?>reino-unido.png" class="bandera" alt="Inglés"></a>
            </div>
        </div>            </div>
        </header>
        <?php 
        include '../menus/menuArbitro.php';  
        ?>
                                          

        <section>
            <div class="row" id="contenido">
                <div class="col-md-1 col-sm-1 col-xs-1"></div>
                <div class="col-md-10 col-sm-10 col-xs-10" id="login" >
                <?php 
                if($numeroTodosCompetidores>1){
                    foreach ($categoriasOrganizadas as $modalidad => $categoriasPorEdad){
                        print "<h2 class='h2Categorias'>".$lang["Modalidad"].": ". strtoupper($modalidad )."</h2>";
                        foreach ($categoriasPorEdad as $edad => $categoriasPorSexo){
                            print "<h3 class='h3Categorias'> ".$lang["Edad"].": ". ucfirst($edad) ."</h3>";
                            foreach ($categoriasPorSexo as $sexo => $categorias){
                                if($sexo == 'm'){
                                   print "<h4 class='h4Categorias' >".$lang["Masculino"]."</h4>";
                                }else{
                                   print "<h4 class='h4Categorias'>".$lang["Femenino"]."</h4>";
                                }  
                                print "<div class='botones-fila'>";
                                $contadorBotones=0;
                                foreach ($categorias as $categoria){
                                      $listaCompetidoresDeUnaModalidad=$modeloRegistrado->obtenerListaCompetidoresRegistrados($idTorneo, $categoria->getPeso(), $categoria->getSexo(), $categoria->getEdad(), $categoria->getModalidad());
                                        if(count($listaCompetidoresDeUnaModalidad)>1){
                                            
                                            if($categoria->getPeso()==90){
                                                print "<a href='torneo.php?idtorneo=" . $idTorneo . "&peso=" . $categoria->getPeso() . "&sexo=". $categoria->getSexo() ."&edad=" . $categoria->getEdad() ."&modalidad=" . $categoria->getModalidad() ."'><button type='button' name='".$categoria->getEdad()."' class='btn btn-success botonesPesos'>>".$categoria->getPeso() . " kg</button></a>";
                                                $contadorBotones++;
                                                
                                            }else if($categoria->getPeso()==79 && $categoria->getSexo()=="f"){
                                                print "<a href='torneo.php?idtorneo=" . $idTorneo . "&peso=" . $categoria->getPeso() . "&sexo=". $categoria->getSexo() ."&edad=" . $categoria->getEdad() ."&modalidad=" . $categoria->getModalidad() ."'><button type='button' name='".$categoria->getEdad()."' class='btn btn-success botonesPesos'>>".$categoria->getPeso() . " kg</button></a>";
                                                $contadorBotones++;
                                            }else{
                                                print "<a href='torneo.php?idtorneo=" . $idTorneo . "&peso=" . $categoria->getPeso() . "&sexo=". $categoria->getSexo() ."&edad=" . $categoria->getEdad() ."&modalidad=" . $categoria->getModalidad() ."'><button type='button' name='".$categoria->getEdad()."' class='btn btn-success botonesPesos'><".$categoria->getPeso() . " kg</button></a>";
                                                $contadorBotones++;
                                            }
                                        }else{
                                            
                                        }
                                        
                                }
                                if($contadorBotones==0){
                                    print "<h2 class='h2Categorias'>".$lang["NoHayCombatesEnEstaCategoria"]."</h2>";

                                }
                                print "</div>";
                                
                            }
                        }
                    } 
                    print"<br>";
                    }else{
                       print "<h2 class='h2Categorias'>".$lang["NoHayCombates"]."</h2>";

                   }
                ?>
                    <div class="botones-fila">
                        <input type="hidden" name="idtorneo" value="<?php echo $idTorneo; ?>">
                        <a href='../listados/listaTorneos.php'><button type='button' name='atras' class='btn btn-primary'><?php echo $lang["VolverATorneos"]?></button></a>
                       <!-- <button id="<?php //echo $idTorneo; ?>" type="submit" class="btn btn-primary botonTerminarTorneo"><?php //echo $lang["TerminarTorneo"]?></button>-->
                    </div>
            
                </div> 
                
                <div class="col-md-1 col-sm-1 col-xs-1"></div>
            </div>    
        </section> 
        <div id="DialogoTerminar" title="<?php echo $lang["TerminarTorneo"]?>" class="oculto">
            <p><?php echo $lang["¿TerminarTorneo"]?></p>
        </div>
        <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
        <script src="../Scripts/adminTorneo.js" type="text/javascript"></script>

    </body>
</html>
