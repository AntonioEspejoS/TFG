<?php
//Vista para el perfil del competidor
session_start();
include '../idioma/idioma.php';
 if (isset($_SESSION["competidor"])) {
     include_once '../Modelo/ModeloCompetidor.php';
     include 'controladorPerfilCompetidor.php';
     include_once '../Modelo/ModeloClub.php';
?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo $lang["PerfilCompetidor"]?></title>
            <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">        
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <link href="/ProyectoTFG/CSS/principal.css" rel="stylesheet" type="text/css"/>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        </head>     
        <body>
            <?php include '../header.php'; ?>
            <?php include '../menus/menuCompetidor.php'; ?>
            <section>
                <div class="container mt-4">
                <?php 
                $dni = $_SESSION["competidor"];
                $competidorModelo = new ModeloCompetidor();
                $modeloClub = new ModeloClub();
                $competidor = $competidorModelo->obtenerCompetidorPorDNI($dni);
                $clubCompetidor=$modeloClub->obtenerClubPorId($competidor->getClub());
          
                //Actualizar la categoria de edad según la fecha de nacimiento
                $fechaNacimiento=$competidor->getFech_nac();
                $competidor->calcularCategoriaEdad($fechaNacimiento);
                $competidorModelo->modificarCompetidor($competidor);        
                ?>   
                    
                    
                    <div class="datosPerfil table-responsive"> 
                        <table class="table table-bordered  tablaDatosPerfil">
                            <tbody>
                            <tr>
                                <!-- Columna para la imagen de perfil -->
                                <td rowspan="4" class="align-middle" style="width: 20%;">
                                    <?php if ($competidor->getImg() !== null && $competidor->getImg() !== ""){ ?>
                                        <img src="/ProyectoTFG/img/usuarios/<?php echo $competidor->getImg(); ?>" alt="Imagen de perfil" class="img-fluid perfil-imagen">
                                    <?php } else { ?>
                                        <img src="/ProyectoTFG/img/perfilPredeterminado.png" alt="Imagen de perfil" class="img-fluid perfil-imagen">
                                    <?php } ?>
                                </td>

                                <?php                     
                                    
                                    print "<th>".$lang["Nombre"]."</th>";
                                    print "<td>" . $competidor->getNombre() . "</td>";
                                    print "<th>DNI</th>";
                                    print "<td id='celdaDNI'>" . $competidor->getDni() . "</td>";
                                    print "</tr>";

                                    print "<tr>";
                                    print "<th>".$lang["Pass"]."</th>";
                                    print "<td> <input type='password' class='pass' readonly id='password1' value='" . $competidor->getContrasena(). "'> <div class='ver' id='mostrarPass'></div></td>";
                                    print "<th>".$lang["Correo"]."</th>";
                                    //Cambiar correo
                                    print "<td>" . $competidor->getCorreo() . "  <input type='button'class='btn btn-warning-custom botonAmarilloPerfil cambiarCorreo' id='" . $competidor->getDni() . "' value='".$lang["Editar"]."'></td>";
                                    print "</tr>";

                                    print "<tr>";
                                    print "<th>".$lang["FechaNacimiento"]."</th>";
                                    $fechaNacimiento = date('d/m/Y', strtotime($competidor->getFech_nac()));

                                    print "<td>" . $fechaNacimiento. "</td>";
                                    print "<th>".$lang["Licencia"]."</th>";
                                    print "<td>" . $competidor->getLicencia(). "</td>";
                                    print "</tr>";
                                    
                                    print "<tr>";
                                    print "<th>".$lang["Club"]."</th>";
                                    print "<td>" . $clubCompetidor->getNombre(). "</td>";
                                    print "<th> ".$lang["CategoriaPeso"]."</th>";
                                    if($competidor->getPeso()==90){
                                        print "<td>>";
                                    }else{
                                        print "<td><";
                                    }
                                    //Botón para cambiar peso
                                    print $competidor->getPeso() . " kg   <input type='button'class='btn btn-warning-custom botonAmarilloPerfil cambiarPeso' id='" . $competidor->getDni() . "' value='".$lang["Editar"]."'></td>";
                                    
                                    print "</tr>";
                                    print "<tr>";
                                    ?>
                                    <!-- Botón para cambiar la imagen de perfil -->
                                        <td class="text-center">
                                            <form id="formCambiarImagen" action="controladorSubirImagenPerfil.php" method="post" enctype="multipart/form-data">
                                                <input type="file" name="imagenPerfil" id="imagenPerfil" class="sr-only" onchange="cambiarImagen()" required>
                                                <input type="hidden" name="idCompetidor" value="<?php echo $competidor->getDni(); ?>">
                                                <input type="hidden" name="rol" value="competidor">
                                                <label for="imagenPerfil" class="btn btn-primary btn-block"><?php echo $lang["CambiarImagen"]?></label>
                                            </form>
                                        </td>
                                 <?php   
                                    print "<th>".$lang["Sexo"]."</th>";
                                    if ($competidor->getSexo() == "m") {
                                        print "<td>".$lang["Masculino"]."</td>";
                                    } else {
                                        print "<td>".$lang["Femenino"]."</td>";
                                    }
                                     print "<th>".$lang["CategoriaEdad"]."</th>";
                                    print "<td>" . $competidor->getCatedad(). "</td>";
                                    print "</tr>";
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Botón para registrarse con un nuevo rol -->
                    <a href="../registro/registrarseRol.php?dni=<?php echo $dni; ?>&rol=competidor">
                        <button  type="button"   class="btn btn-primary botonFormulario botonDerecha"><?php echo $lang["RegistrarseOtroRol"]?></button></a>        
                    <br>
                    <!-- Tabla de medallas conseguidas del competidor -->
                    <h2 class="textoCentrado"><?php echo $lang["Medallas"]?></h2>
                    <div class="datosPerfil table-responsive"> 
                        <?php
                        $enfrentamientosPodio = obtenerEnfrentamientosConDescripcionTorneo($dni);
                        if (!empty($enfrentamientosPodio)) {
                            print "<table class='table table-bordered' style='text-align:center;'>";
                            print "<tbody>";
                            print "<tr>";
                            print "<th>".$lang["Torneo"]."</th>";
                            print "<th>".$lang["Modalidad"]."</th>";
                            print "<th>".$lang["Edad"]."</th>";
                            print "<th>".$lang["Peso"]."</th>";
                            print "<th>".$lang["Medalla"]."</th>";
                            print "</tr>";
                            foreach($enfrentamientosPodio as $enfrentamientoP){
                                print "<tr>";
                                print "<td>" . $enfrentamientoP['descripcionTorneo'] . "</td>";
                                print "<td>" . $enfrentamientoP['enfrentamiento']->getModalidad() . "</td>";
                                print "<td>" . $enfrentamientoP['enfrentamiento']->getEdad() . "</td>";  
                                if ($enfrentamientoP['enfrentamiento']->getPeso() == "90") {
                                    print "<td>>" . $enfrentamientoP['enfrentamiento']->getPeso() . "kg</td>";
                                } else {
                                    print "<td><" . $enfrentamientoP['enfrentamiento']->getPeso() . "kg</td>";
                                }
                                if ($enfrentamientoP['posicion'] == 1) {
                                    print "<td><img src='/ProyectoTFG/img/medalla-de-oro.png' width='30em' height='30em'></td>";
                                } else if ($enfrentamientoP['posicion'] == 2) {
                                    print "<td><img src='/ProyectoTFG/img/medalla-de-plata.png' width='30em' height='30em'></td>";
                                } else if ($enfrentamientoP['posicion'] == 3){
                                    print "<td><img src='/ProyectoTFG/img/medalla-de-bronce.png' width='30em' height='30em'></td>";

                                }
                            }
                            print "</tr>";
                            print "</tbody>";
                            print "</table>";
                        } else {
                            print "<h3 style='margin:1em; '>No tienes medallas</h3>";
                        }
                        ?>
                    </div>
                </div>
            </section>
            <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
            <script src="../Scripts/perfiles.js" type="text/javascript"></script>
            
            <!-- Dialogo cambiar de peso-->
            <div class="oculto" id="dialogoCambiarPeso" title="Editar Peso">
                <form action="" method="post" id="formularioPesoEditar" name="formularioPesoEditar">
                    <label for="PesoCambiado">Peso:</label>
                    <span></span>
                    <select name="peso" class="form-control" id="PesoCambiado" required>
                        <option selected="true" disabled="disabled"><?php echo $lang["SeleccionaTuPeso"]?>...</option>
                        <?php
                        if ($competidor->getSexo() == "m") {
                            print" <option value='64'><64kg</option>
                        <option value='69'><69kg</option>
                        <option value='74'><74kg</option>
                        <option value='79'><79kg</option>
                        <option value='84'><84kg</option>
                        <option value='90'>>90kg</option>
                                ";
                        } else {
                            print"<option value='49'><49kg</option>
                        <option value='59'><59kg</option>
                        <option value='64'><64kg</option>
                        <option value='69'><69kg</option>
                        <option value='74'><74kg</option>
                        <option value='79'>>79kg</option>
                 
                         ";
                        }
                        ?>    
                    </select>
                    <br><br>
                    <fieldset id="btnAgregar" style="text-align: center">
                        <input type="button" id="editar" value="<?php echo $lang["EditarPeso"]?>">
                    </fieldset>
                </form>
            </div>
            <!-- Dialogo de peso editado -->
            <div id="dlgEditar" title="<?php echo $lang["EditarPeso"]?>" class="oculto">
                <p><?php echo $lang["PesoEditado"]?></p>
            </div>
            <!-- Dialogo cambiar correo -->
            <div class="oculto" id="dialogoCambiarCorreo" title="<?php echo $lang["EditarCorreo"]?>">
                <form action="" method="post" id="formularioCorreoEditar" name="formularioCorreoEditar">
                    <div class="form-group">
                        <label style=" float:left;" for="correo">Email: </label>
                        <input type="email" name="correo" class="form-control" id="CorreoCambiado" required="required" placeholder="<?php echo $lang["EjemploCorreo"]?>">
                        <div id="errorEmail" class="errorCampo"></div>
                    </div>
                    <div class="form-group text-center">
                        <input type="button" id="editarCorreo"  class="btn btn-primary"  value="<?php echo $lang["EditarCorreo"]?>">
                     </div>   
                </form>
            </div>
            <!-- Dialogo de correo editado -->
            <div id="dlgEditarCorreo" title="Editar Correo" class="oculto">
                <p><?php echo $lang["CorreoEditado"]?></p>
            </div>
            
        </body>  
        <script>
            function cambiarImagen() {
                document.getElementById("formCambiarImagen").submit(); // Envía el formulario cuando el archivo cambia
            }
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
  <?php   
 } else {
    header("Location: ../index.php");
} 

