<?php
session_start();
include '../idioma/idioma.php';
?>
<html>
    <head>
        <title>Error club</title>
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
                <div id="cuerpo">
                    <img id="advertencia" src="../img/advertencia.png" alt=""/>
                    <h1 id="enunciadoAdver"><?php echo $lang["ClubExiste"]?>.</h1>
                     <!-- <img id="advertencia" src="../img/advertencia.png" alt=""/>-->
                </div>
                <br>
                <br>
                <br>
                <a href="../registro/registrarse.php"> <button type="button" id="botonVolver" class="btn btn-success"><?php echo $lang["Volver"]?></button></a>
            </div>
        </section>
    </body>
</html>
