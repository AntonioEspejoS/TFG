<?php
//Vista para el formulario de registro de un usuario que ya tiene una cuenta para registrar nuevo rol
session_start();
// Redireccionar si no hay roles en la sesión o no hay usuario logueado
if (empty($_SESSION['roles']) || !isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}
include '../idioma/idioma.php';
include_once '../Modelo/ModeloClub.php'; 
include_once '../registro/controladorRegistroRol.php'; 
$modeloClub = new ModeloClub();
$clubes = $modeloClub->obtenerClubes();

$dni = $_GET['dni'];
$rolActual = $_GET['rol'];
// Obtener los roles que tiene el usuario
$roles = obtenerRolesPorDNI($dni);
// Llamar a la función para obtener el usuario
$usuario = obtenerUsuarioPorDNIyRol($dni, $rolActual);
if ($usuario === null) {
     header('Location: ../MensajesYErrores/errorRegistro.php');
     exit;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $lang["Registro"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="../CSS/registro.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include '../header.php';?>
        <section>
            <div class="row" id="contenido">
                <div class="col-md-12 col-sm-12 col-xs-12" id="signin">
                    <form action="controladorRegistro.php" method="POST">
                        <!-- Campos comunes ocultos-->
                        <input type="hidden" name="dni" value="<?php echo $usuario->getDni(); ?>">
                        <input type="hidden" name="nombre" value="<?php echo $usuario->getNombre(); ?>">
                        <input type="hidden" name="correo" value="<?php echo $usuario->getCorreo(); ?>">
                        <input type="hidden" name="contra" value="<?php echo $usuario->getContrasena(); ?>">

                        
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                               <!-- Columna 1 -->
                                <div class="form-group">
                                    <label for="rol">Rol: <span class="text-danger">*</span></label>
                                    <select name="rol" class="form-control" id="rol" required>
                                        <option value=""><?php echo $lang["SeleccionaUnRol"]?>...</option>
                                        
                                        <?php
                                        $todosLosRoles = ['competidor' => $lang["Competidor"], 'coach' => 'Coach', 'arbitro' => $lang["Arbitro"], 'adminFed' => $lang["AdminFed"]];
                                        // Filtramos y mostramos solo los roles que el usuario no posee
                                        foreach ($todosLosRoles as $key => $value) {
                                            if (!in_array($key, $roles)) {
                                                echo "<option value='$key'>$value</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- Fin campos comunes -->
                                <!-- Campos competidor columna 1-->
                                <div id="camposCompetidor1" class="oculto">
                                    <div class="form-group">
                                        <label style=" float:left;" for="fecha"><?php echo $lang["FechaNacimiento"]?>: <span class="text-danger">*</span></label>
                                        <input type="date" name="fecha" class="form-control" id="fecha" required="required">
                                    </div>
                                </div>
                                <!-- Fin campos competidor columna 1-->
                                
                                
                                <!-- Campos coach columna 1-->
                                <div id="camposCoach" class="oculto">
                                    <div class="form-group">
                                        <label for="club"><?php echo $lang["Club"]?>: <span class="text-danger">*</span></label>
                                        <select name="club" class="form-control" id="club">
                                            <option value="" selected><?php echo $lang["SeleccionaClub"]?>...</option>
                                            <option value="nuevo"><?php echo $lang["NuevoClub"]?></option>
                                              <?php
                                             foreach ($clubes as $club) {
                                                  echo "<option value='" . $club->getIdclub() . "'>" . $club->getNombre() . "</option>";
                                             }
                                             ?>  
                                        </select>
                                    </div>
                                    <div id="nuevo_club_container" style="display: none;">
                                        <div class="form-group">
                                            <label for="nuevoClub"><?php echo $lang["NombreNuevoClub"]?>: <span class="text-danger">*</span></label>
                                            <input type="text" name="nuevoClub" class="form-control" id="nuevoClub" placeholder="<?php echo $lang["NombreNuevoClub"]?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="localidad"><?php echo $lang["Localidad"]?>: <span class="text-danger">*</span></label>
                                            <select name="localidad" class="form-control" id="localidad">
                                                <option value="" selected><?php echo $lang["SeleccionaLocalidad"]?>...</option>
                                                 <option value="Cordoba">Córdoba</option>
                                                 <option value="Sevilla">Sevilla</option>
                                                 <option value="Granada">Granada</option>
                                                 <option value="Malaga">Málaga</option>
                                                 <option value="Cadiz">Cádiz</option>
                                                 <option value="Huelva">Huelva</option>
                                                 <option value="Almeria">Almería</option>
                                                 <option value="Jaen">Jaén</option>
                                            </select>
                                        </div>
                                    </div>  
                                </div>
                              <!-- Fin campos coach columna 1--> 
                              
                              
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6"><!-- Columna 2 -->
                        
                                
                                <!-- Campo licencia competidor y coach-->
                                <div id="bloqueLicencia" class="form-group oculto">
                                        <label style=" float:left;" for="licencia"><?php echo $lang["Licencia"]?>: <span class="text-danger">*</span></label><div id="errorLicencia" class="errorCampo"></div>
                                        <input type="text" name="licencia" class="form-control" id="licencia" required="required" placeholder="<?php echo $lang["NumeroLicencia"]?>">
                                </div>
                                <!-- Fin campo licencia competidor y coach -->
                                
                                <!-- Campos competidor columna 2-->
                                <div id="camposCompetidor2" class="oculto">
                                    <div class="form-group">
                                        <label style=" float:left;" for="peso"><?php echo $lang["Peso"]?>: <span class="text-danger">*</span></label>
                                        <select name="peso" class="form-control" id="peso" required="required">
                                            <option value="" selected="true" disabled="disabled"><?php echo $lang["SeleccionaPrimeroSexo"]?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style=" float:left;" for="clubCompetidor"><?php echo $lang["Club"]?>: <span class="text-danger">*</span></label>
                                        <select name="clubCompetidor" class="form-control" id="clubCompetidor" required="required">
                                            <option value="" selected="true" disabled="disabled"><?php echo $lang["SeleccionaClub"]?>...</option>
                                            <?php
                                            foreach ($clubes as $club) {
                                                 echo "<option value='" . $club->getIdclub() . "'>" . $club->getNombre() . "</option>";
                                            }
                                            ?>   
                                        </select>
                                    </div>   
                                </div>
                                
                                <!-- Fin campos competidor columna 2--> 
                                <div class="form-group">
                                    <p class="text-danger">* <?php echo $lang["CamposObligatorios"]?></p>
                                    <button id="enviar" type="submit" name="enviar" class="btn btn-primary botonFormulario" disabled="true"><?php echo $lang["Registrarse"]?></button>  
                                               <?php
                                        $volverUrl = "/ProyectoTFG/index.php";
                                        if (isset($_SESSION["admin"])) {
                                            $volverUrl = "/ProyectoTFG/perfiles/perfilAdmin.php";
                                        } else if (isset($_SESSION["adminFed"])) {
                                            $volverUrl = "/ProyectoTFG/perfiles/perfilAdminFed.php";
                                        } else if (isset($_SESSION["arbitro"])) {
                                            $volverUrl = "/ProyectoTFG/perfiles/perfilArbitro.php";
                                        } else if (isset($_SESSION["coach"])) {
                                            $volverUrl = "/ProyectoTFG/perfiles/perfilCoach.php";
                                        } else if (isset($_SESSION["competidor"])) {
                                            $volverUrl = "/ProyectoTFG/perfiles/perfilCompetidor.php";

                                        }
                                        ?>
                                    <a href="<?php echo $volverUrl; ?>"><button  type="button"  class="btn btn-success botonFormulario"><?php echo $lang["Volver"]?></button></a>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </section>
         <?php include '../footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
                dni: "<?php echo $lang['ErrorDni']; ?>",
                nombre: "<?php echo $lang['ErrorNombre']; ?>",
                primerApellido: "<?php echo $lang['ErrorPrimerApellido']; ?>",
                apellido: "<?php echo $lang['ErrorApellido']; ?>",
                pass: "<?php echo $lang['ErrorPass']; ?>",
                correo: "<?php echo $lang['ErrorCorreo']; ?>",
                licencia: "<?php echo $lang['ErrorLicencia']; ?>",
                seleccionaTuPeso: "<?php echo $lang['SeleccionaPeso']; ?>",
                correoConfirmacion:"<?php echo $lang['CorreoNoCoinciden']; ?>",
                passConfirmacion:"<?php echo $lang['PassNoCoinciden']; ?>"
            };
        </script>
        <script src="../Scripts/formulariosRol.js" type="text/javascript"></script>

    </body>
</html>    