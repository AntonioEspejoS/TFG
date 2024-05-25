<?php
//Vista del club de los competidores y coaches
session_start();
include '../idioma/idioma.php';

 if (isset($_SESSION["competidor"])|| isset($_SESSION["coach"]) ) {
     include 'controladorListaMiClub.php';
     
    
?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo $lang["MiClub"]?></title>
            <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">        
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <link href="/ProyectoTFG/CSS/principal.css" rel="stylesheet" type="text/css"/>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
            <!--MAPA -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
            <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>


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
            } 
            $datosDelClub = obtenerDatosClub($dni);
            $club = $datosDelClub['club'];

            $modeloClub = new ModeloClub();
            $clubes = $modeloClub->obtenerClubes();
            ?>
            <section>
                <div class="container mt-4">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <?php if ($club->getImg() !== null && $club->getImg() !== ""){ ?>
                                <img src="/ProyectoTFG/img/clubes/<?php echo $club->getImg(); ?>" alt="Imagen del Club" class="img-fluid club-logo">
                           <?php } else{ ?>
                                <img src="/ProyectoTFG/img/logoPredeterminado.png" alt="Imagen del Club" class="img-fluid club-logo">
                           <?php }
                           
                           ?>
                        </div>
                        <div class="col-md">
                            <?php print "<h1 class='nombreClub' id='identificadorNombreDelClub'>" . $club->getNombre()."</h1>";
                            ?>             
                        </div>        
                        <?php if (isset($_SESSION["coach"])): ?>
                        <div class="col-md-auto ml-auto">
                            <form id="formCambiarImagen" action="controladorSubirImagenClub.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="imagenClub" id="imagenClub" class="sr-only" onchange="cambiarImagen()" required>
                                <input type="hidden" name="idClub" value="<?php echo $club->getIdClub(); ?>">
                                <label for="imagenClub" class="btn btn-primary mb-2"><?php echo $lang["CambiarImagenClub"]?></label>
                            </form>
                        </div>
                        <script>
                            function cambiarImagen() {
                                document.getElementById("formCambiarImagen").submit(); // Envía el formulario cuando el archivo cambia
                            }
                        </script>
                        <?php endif; ?>
                        <?php if (isset($_SESSION["competidor"])): ?>
                        <div class="col-md-auto ml-auto">
                            <input type="button" class="btn btn-warning-custom botonAmarilloPerfil cambiarClub" id="<?php echo $_SESSION["competidor"]; ?>" value="<?php echo $lang["SolicitarCambio"]?>">
                        </div>
                        <?php endif; ?>
                        
                        
                    </div> 
                        
                        <h2 class="textoCentrado">Coachs</h2>
                        <div class="table-responsive">
                        <table id="tablaCoachClub" class="table table-striped table-hover">
                          <thead>
                              <tr>
                                  <th></th>
                                  <th><?php echo $lang["Nombre"]?></th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              foreach ($datosDelClub['coaches'] as $coach) {
                                    $imagenUrl = $coach->getImg() ? "/ProyectoTFG/img/usuarios/{$coach->getImg()}" : "/ProyectoTFG/img/perfilPredeterminado.png";
                                    print "<tr>";
                                    print "<td><img src='{$imagenUrl}' alt='Imagen del Coach' class='imagen-tabla'></td>";
                                    print "<td>" . $coach->getNombre() . "</td>";
                                    print "</tr>";
                              }
                                                            
                              ?>
                          </tbody>
                      </table>
                        <h2 class="textoCentrado"><?php echo $lang["Competidores"]?></h2>
                         <?php if (isset($_SESSION["coach"])){?>
                          <a href="../listados/listaCompetidoresVerificar.php"><button id="" class="btn btn-primary mb-2"><?php echo $lang["VerificarCompetidores"]?>
                            <?php if ($numeroNoVerificados > 0): ?>
                                <span class="badge badge-warning"><?php echo $numeroNoVerificados ?></span>
                            <?php endif; ?>
                            </button>
                        </a>
                       <?php }?>
                        
                        <table id="tablaCompetidorClub" class="table table-striped table-hover">
                          <thead>
                              <tr>
                                <th></th>
                                <th><?php echo $lang["Nombre"]?></th>
                                <th><?php echo $lang["Peso"]?></th>
                                <th><?php echo $lang["Sexo"]?></th>
                                <th><?php echo $lang["Categoria"]?></th>
                                <?php  
                                if(isset($_SESSION["coach"])){
                                    print "<td><strong>Eliminar</strong></td>";
                                }
                                ?>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                foreach ($datosDelClub['competidores'] as $competidor) {
                                    $imagenUrl = $competidor->getImg() ? "/ProyectoTFG/img/usuarios/{$competidor->getImg()}" : "/ProyectoTFG/img/perfilPredeterminado.png";
                                    print "<tr>";
                                    print "<td><img src='{$imagenUrl}' alt='Imagen del Competidor' class='imagen-tabla'></td>";
                                    print "<td>" . $competidor->getNombre() . "</td>";
                                    if($competidor->getPeso()==90){
                                        print "<td>>" . $competidor->getPeso() . " kg</td>";
                                    }else{
                                        print "<td><" . $competidor->getPeso() . " kg</td>";
                                    }
                                    if ($competidor->getSexo() == "m") {
                                        print "<td>".$lang["Masculino"]."</td>";
                                    } else {
                                        print "<td>".$lang["Femenino"]."</td>";
                                    }
                                    print "<td>" . $competidor->getCatedad() . "</td>";
                                    if(isset($_SESSION["coach"])){
                                       print "<td><button type='button' name='eliminar' id='" . $competidor->getDni() . "'  class='btn btn-danger botonEliminarCompetidor'>".$lang["Eliminar"]."</button></td>";
                                    }
                                    print "</tr>";
                                }
                              ?>
                          </tbody>
                      </table>      
                      </div>  
                      <input type="hidden" id="idClub" value="<?php echo $club->getIdClub(); ?>">

                      <h2 class="textoCentrado"><?php echo $lang["Ubicacion"]?></h2>
                      <?php if (isset($_SESSION["coach"])){?>
                          
                       <button id="btnCambiarUbicacion" class="btn btn-primary mb-2"><?php echo $lang["CambiarUbicacion"]?></button>

                       <?php }?>
                      <div id="mapaClub" style="height: 400px;"></div>


        <!-- Diálogo para seleccionar la nueva ubicación -->
        <div id="dialogoMapaSeleccion" title="<?php echo $lang["SeleccionarNuevaUbicacion"]?>" style="display:none;">
            <div id="mapaSeleccion" style="height: 400px;"></div>
            
            <input type="button" class="botonesDialogos" id="btnConfirmarUbicacion" value="<?php echo $lang["EditarClub"]?>">
            <input type="hidden" id="latitudNueva">
            <input type="hidden" id="longitudNueva">
        </div>
        <!-- Campos ocultos para latitud y longitud actuales del club -->
        <input type="hidden" id="latitudClub" value="<?php echo $club->getLatitud();?>">
        <input type="hidden" id="longitudClub" value="<?php echo $club->getLongitud(); ?>">
        
                        
                        
                </div>
            </section>
            <div class="oculto" id="dialogoCambiarClub" title="<?php echo $lang["SolicitarCambio"]?>">
                <form action="" method="post" id="formularioClubEditar" name="formularioClubEditar">
                    <input type="hidden" id="dniCompetidorEditarClub" name="dniCompetidorEditarClub" required value="<?php echo $_SESSION["competidor"]; ?>">
                    <input type="hidden" id="clubAntiguo" name="clubAntiguo">

                    <div class="form-group">
                        <label for="CompetidorClubEditar"><?php echo $lang["Club"];?>:</label>
                        <select class="form-control" name="CompetidorClubEditar" id="CompetidorClubEditar" required>
                            <option selected="true" disabled="disabled"><?php echo $lang["SeleccionaElNuevoClub"];?>...</option>
                            <?php foreach ($clubes as $clubCambiar): ?>
                                <option value="<?php echo htmlspecialchars($clubCambiar->getIdclub()); ?>"><?php echo htmlspecialchars($clubCambiar->getNombre()); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group text-center">
                        <input type="button" id="editarClub" class="btn btn-primary" value="<?php echo $lang["SolicitarCambio"];?>">
                    </div>
                </form>

            </div>
            <div id="dlgEditarClub" title="<?php echo $lang["EditarClub"]?>" class="oculto">
                <p><?php echo $lang["SolicitudANuevoClub"]?></p>
                <p><?php echo $lang["InformacionSolicitudClub"]?></p>
            </div>
            <div id="dialogoEliminar" title="Confirmar Eliminación" class="oculto">
                <p><?php echo $lang["ConfirmarEliminarCompetidor"]?></p>
            </div>
            <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>            <script src="../Scripts/OrdenarTablas.js" type="text/javascript"></script>
            <script src="../Scripts/eliminarCompetidores.js" type="text/javascript"></script>
            <script src="../Scripts/cambioClub.js" type="text/javascript"></script>
            <!-- Incluir CSS de DataTables -->
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
            <!-- Incluir JS de DataTables -->
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
            <script>
            $(document).ready(function() {
                var idiomaSeleccionado = "<?php echo (isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'es'); ?>"; // 'es' como valor predeterminado
                var urlIdioma;
                if (idiomaSeleccionado === "es") {
                    urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json";
                } else if (idiomaSeleccionado === "in") {
                    urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/English.json";
                }

                $('#tablaCoachClub,#tablaCompetidorClub').DataTable({
                    "language": {
                        "url": urlIdioma
                    },
                    "columnDefs": [
                        {"searchable": false, "orderable": false, "targets": [0] } // Ajusta los índices según las columnas que quieras hacer no ordenables
                    ]
                });
            });
            </script>
                    <script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
                errorCorreo: "<?php echo $lang['ErrorCorreo']; ?>",
                aceptar:"<?php echo $lang['Aceptar']; ?>",
                si:"<?php echo $lang['Si']; ?>",
                cancelar:"<?php echo $lang['Cancelar']; ?>",
                errorConexion:"<?php echo $lang['ErrorDeConexion']; ?>",
                mismoClub:"<?php echo $lang['HasElegidoElMismoClub']; ?>",
                
            };
        </script>
            <!-- Mapa del club -->
    <script src="../Scripts/mapaClub.js"></script>
        </body>  
         
  <?php   
 } else {
    header("Location: ../index.php");
} 

