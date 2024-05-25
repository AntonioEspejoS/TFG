<?php
//Vista para la selección de roles en el caso de que un usuario tenga más de un rol
session_start();
include '../idioma/idioma.php';

// Redireccionar si no hay roles en la sesión o no hay usuario logueado
if (empty($_SESSION['roles']) || !isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}
$dniUsuario = $_SESSION['usuario']; 
$roles = $_SESSION['roles'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $lang["ElegirRol"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
         <link href="/ProyectoTFG/CSS/index.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include '../header.php';?>
        <section>
            <div class="row" id="contenido">
                <div class="col-md-1 col-sm-1 col-xs-1"></div>
                <div class="col-md-10 col-sm-10 col-xs-10" id="login">
                    <h2><?php echo $lang["SeleccionaTuRol"]?></h2> 
                    <form action="controladorSeleccionRol.php" method="POST">
                        <div class="form-group">
                        <select name="rolSeleccionado" class="form-control" id="rolSeleccionado" required>
                            <option value="" selected><?php echo $lang["SeleccionaUnRol"]?>...</option>
                              <?php
                             foreach ($roles as $rol => $pagina) {
                                  echo "<option value='" . $rol . "'>" . ucfirst($rol) . "</option>";
                             }
                             ?>  
                        </select>
                        </div>  
                        <div class="form-row">
                            <div class="col">
                                <button id="enviar" type="submit" name="Entrar" class="btn btn-success botonFormulario"><?php echo $lang["Entrar"]?></button>
                            </div>

                            <div class="col">
                               <a href="../index.php"><button  type="button"   class="btn btn-primary botonFormulario"><?php echo $lang["Volver"]?></button></a>
                           </div>
                        </div>   
                    </form>
                   
                    
                </div>
                
                        
                
                
                <div class="col-md-1 col-sm-1 col-xs-1"></div>
            </div>
        </section>
        <?php include '../footer.php'; ?>

    </body>
</html>
