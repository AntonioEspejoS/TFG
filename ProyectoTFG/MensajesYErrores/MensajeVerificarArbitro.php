<?php
session_start();
include '../idioma/idioma.php';
?>
<html>
    <head>
        <title><?php echo $lang["Esperando"]?></title
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link href="../CSS/errores.css" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>
    <body>
    <?php include '../header.php';?>
        <nav></nav>
        <section>
            <div class="container">
                <div id="body">
                    <h1><?php echo $lang["MensajeVerificarCoach"]?></h1>
                    <br><br><br>
                    <h2>  <?php echo $lang["Espere"]?>
                    </h2>
                </div>
                <br>
                <br>
                <br>
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
                                        }else{
                                            $volverUrl = "/ProyectoTFG/index.php";
                                        }
                                        ?>
                                    <a href="<?php echo $volverUrl; ?>"><button  type="button"  class="btn btn-success "><?php echo $lang["Volver"]?></button></a>
                                

            </div>
        </section>
    </body>
</html>
