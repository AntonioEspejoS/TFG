<?php
//Vista para el perfil del coach
session_start();
include '../idioma/idioma.php';

 if (isset($_SESSION["coach"])) {
     include_once '../Modelo/ModeloCoach.php';
     include_once '../Modelo/ModeloClub.php';

?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo $lang["PerfilCoach"]?></title>
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
            <?php include '../menus/menuCoach.php'; ?>
            <section>
                <div class="container mt-4">
                    
                <?php 
                $dni = $_SESSION["coach"];
                $coachModelo = new ModeloCoach();
                $modeloClub = new ModeloClub();
                $coach = $coachModelo->obtenerCoachPorDNI($dni);
                $clubCoach=$modeloClub->obtenerClubPorId($coach->getClub());
                        
                ?>   
                  
                    
                    <div class="datosPerfil table-responsive"> 
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Columna para la imagen de perfil y el botón de cambio, a la izquierda -->
                                <td class="align-middle" style="width: 20%; text-align: center;" rowspan="5">
                                    <?php if ($coach->getImg() !== null && $coach->getImg() !== ""){ ?>
                                        <img src="/ProyectoTFG/img/usuarios/<?php echo htmlspecialchars($coach->getImg(), ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen de perfil" class="img-fluid perfil-imagen">
                                    <?php } else { ?>
                                        <img src="/ProyectoTFG/img/perfilPredeterminado.png" alt="Imagen de perfil" class="img-fluid perfil-imagen">
                                    <?php } ?>
                                    <!-- Espacio reservado para el botón, que se colocará después de los datos -->
                                </td>

                                <!-- Datos del coach -->
                                <th><?php echo $lang["Nombre"]?></th>
                                <td><?php echo $coach->getNombre(); ?></td>
                            </tr>
                            <tr>
                                <th>DNI</th>
                                <td id="celdaDNI"><?php echo $coach->getDni(); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $lang["Pass"]?></th>
                                <td><input type='password' class='pass' readonly value='<?php echo $coach->getContrasena(); ?>'></td>
                            </tr>
                            <tr>
                             <?php  print "<th>".$lang["Correo"]."</th>"; 
                                    print "<td>" . $coach->getCorreo() . "<input type='button'class='btn btn-warning-custom botonAmarilloPerfil cambiarCorreoCoach' id='" . $coach->getDni() . "' value='".$lang["EditarCorreo"]."'></td>";
                             ?>
                            </tr>
                            <tr>
                                <th><?php echo $lang["Licencia"]?></th>
                                <td><?php echo $coach->getLicencia(); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <form id="formCambiarImagen" action="controladorSubirImagenPerfil.php" method="post" enctype="multipart/form-data">
                                        <input type="file" name="imagenPerfil" id="imagenPerfil" class="sr-only" onchange="cambiarImagen()" required>
                                        <input type="hidden" name="idCoach" value="<?php echo $coach->getDni(); ?>">
                                        <input type="hidden" name="rol" value="coach">
                                        <label for="imagenPerfil" class="btn btn-primary btn-block"><?php echo $lang["CambiarImagen"]?></label>
                                    </form>
                                </td>
                                <th>Club</th>
                                <td><?php echo $clubCoach->getNombre(); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="../registro/registrarseRol.php?dni=<?php echo $dni; ?>&rol=coach">
                        <button  type="button"   class="btn btn-primary botonFormulario botonDerecha"><?php echo $lang["RegistrarseOtroRol"]?></button></a>        
                   
                 </div>
            </section>
            <script>
                function cambiarImagen() {
                    document.getElementById("formCambiarImagen").submit(); // Envía el formulario cuando el archivo cambia
                }
            </script>
            <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
            <script src="../Scripts/perfiles.js" type="text/javascript"></script>
            
            <!-- Dialogo cambiar correo -->
            <div class="oculto" id="dialogoCambiarCorreoCoach" title="<?php echo $lang["EditarCorreo"]?>">
                <form action="" method="post" id="formularioCorreoEditar" name="formularioCorreoEditar">
                        <div class="form-group">
                            <label for="CorreoCambiado">Email: </label>
                            <input type="email" name="correo" class="form-control" id="CorreoCambiado" required="required" placeholder="<?php echo $lang["EjemploCorreo"]?>">
                            <div id="errorEmail" class="errorCampo"></div>
                        </div>
                        <div class="form-group text-center">
                            <input type="button" id="editarCorreoCoach" class="btn btn-primary" value="<?php echo $lang["EditarCorreo"]?>">
                        </div>

                </form>
            </div>
            <!-- Dialogo de correo editado -->
            <div id="dlgEditarCorreo" title="Editar Correo" class="oculto">
                <p><?php echo $lang["CorreoEditado"]?></p>
            </div>
        </body>   
        <script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
                errorCorreo: "<?php echo $lang['ErrorCorreo']; ?>",
                aceptar:"<?php echo $lang['Aceptar']; ?>",
                si:"<?php echo $lang['Si']; ?>",
                cancelar:"<?php echo $lang['Cancelar']; ?>",
                errorConexion:"<?php echo $lang['ErrorDeConexion']; ?>"
            };
        </script>
  <?php   
 } else {
    header("Location: ../index.php");
} 

