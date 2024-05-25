<?php
//Vista para el perfil del administrador de la federación
session_start();
 if (isset($_SESSION["adminFed"])) {
     include '../idioma/idioma.php';

     include_once '../Modelo/ModeloAdminFed.php';
?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo $lang["PerfilAdminFed"]?></title>
            <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
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
            <?php include '../menus/menuAdminFed.php'; ?>
            <section>
                <div class="container">
                    <div class="datosPerfil table-responsive"> 
                        <table class="table table-bordered">
                            <tbody>
                                <?php
                                $dni = $_SESSION["adminFed"];
                                $adminFedModelo = new ModeloAdminFed();
                                $adminFed = $adminFedModelo->obtenerAdminFedPorDNI($dni);
                                    print "<tr>";
                                    print "<th>".$lang["Nombre"]."</th>";
                                    print "<td>" . $adminFed->getNombre() . "</td>";
                                    print "<th>DNI</th>";
                                    print "<td id='celdaDNI'>" . $adminFed->getDni() . "</td>";
                                    print "</tr>";
                                    print "<tr>";
                                    print "<th>".$lang["Pass"]."</th>";
                                    print "<td> <input type='password' class='pass' readonly id='password1' value='" . $adminFed->getContrasena(). "'> <div class='ver' id='mostrarPass'></div></td>";
                                    print "<th>".$lang["Correo"]."</th>";
                                    print "<td>" . $adminFed->getCorreo() . "<input type='button'class='btn btn-warning-custom botonAmarilloPerfil cambiarCorreoAdminFed' id='" . $adminFed->getDni() . "' value='".$lang["EditarCorreo"]."'></td>";
                                    print "</tr>";
                                ?>
                            </tbody>
                        </table>
                    </div>
                       <a href="../registro/registrarseRol.php?dni=<?php echo $dni; ?>&rol=adminFed">
                        <button  type="button"   class="btn btn-primary botonFormulario botonDerecha"><?php echo $lang["RegistrarseOtroRol"]?></button></a>        
                   
                </div>
            </section>
            <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
            <script src="../Scripts/perfiles.js" type="text/javascript"></script>
            
            <!-- Dialogo cambiar correo -->
            <div class="oculto" id="dialogoCambiarCorreoAdminFed" title="<?php echo $lang["EditarCorreo"]?>">
                <form action="" method="post" id="formularioCorreoEditar" name="formularioCorreoEditar">
                    <div class="form-group">
                        <label style=" float:left;" for="correo">Email: </label>
                        <input type="email" name="correo" class="form-control" id="CorreoCambiado" required="required" placeholder="<?php echo $lang["EjemploCorreo"]?>">
                        <div id="errorEmail"class="errorCampo"></div>
                    </div> 
                    <div class="form-group text-center">
                        <input type="button" id="editarCorreoAdminFed"  class="btn btn-primary"  value="<?php echo $lang["EditarCorreo"]?>">
                    </div>
                    
                    
                </form>
            </div>
            <!-- Dialogo de correo editado -->
            <div id="dlgEditarCorreo" title="<?php echo $lang["EditarCorreo"]?>" class="oculto">
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

