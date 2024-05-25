<?php
//Vista para el formulario para recuperar la contraseña
session_start();
include '../idioma/idioma.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $lang["Recuperar"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="../CSS/registro.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include '../header.php';?>
        <section>
            <div class="row" id="contenido">
                <div class="col-md-12 col-sm-12 col-xs-12" id="signin">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label style=" float:left;" for="dni">DNI: <span class="text-danger">*</span></label><div id="errorDNI" class="errorCampo"></div>
                            <input type="dni" name="dni" class="form-control" id="dni" required="required" placeholder="99999999X">
                        </div>
                        <div class="form-group">
                            <label style=" float:left;" for="correo">Email: <span class="text-danger">*</span></label><div id="errorEmail" class="errorCampo"></div>
                            <input type="email" name="correo" class="form-control" id="correo" required="required" placeholder="<?php echo $lang["EjemploCorreo"]?>">
                        </div>
                        <div class="form-group">
                            <p class="text-danger">* <?php echo $lang["CamposObligatorios"]?></p>
                        </div>
                               
                        <div class="form-row">
                            <div class="col">
                                 <button id="enviar" type="submit" name="enviar" class="btn btn-primary botonFormulario" disabled="true"><?php echo $lang["Recuperar"]?> <?php echo $lang["PassMini"]?></button>  
                            </div>
                            <div class="col">
                                 <a href="../index.php"><button  type="button"  class="btn btn-success botonFormulario"><?php echo $lang["Volver"]?></button></a>
                            </div>
                        </div>    
                    </form>
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
                correo: "<?php echo $lang['ErrorCorreo']; ?>"
            };
        </script>
        <script src="../Scripts/formularioRecuperar.js" type="text/javascript"></script>

    </body>
</html>    