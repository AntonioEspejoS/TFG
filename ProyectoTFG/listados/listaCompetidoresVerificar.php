<?php
//Vista de la lista de competidores para verificar por parte de los coaches
session_start();
include '../idioma/idioma.php';

 if (isset($_SESSION["coach"]) ) {
     //include 'controladorListaCompetidoresVerificar.php';
?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo $lang["VerificarCompetidores"]?></title>
            <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">        
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <link href="/ProyectoTFG/CSS/principal.css" rel="stylesheet" type="text/css"/>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        </head>     
        <body>
            <?php 
                include '../header.php';
                include '../menus/menuCoach.php';        
            ?>
            <section>
                <div class="container">
                        <h2 class="textoCentrado"><?php echo $lang["CompetidoresNoVerificados"]?></h2>
                        <div class="table-responsive">
                        <table id="tablaVerificar" class="table table-striped table-hover">
                          <thead>
                              <tr>
                                <th><?php echo $lang["Nombre"]?></th>
                                <th><?php echo $lang["Licencia"]?></th>
                                <th><?php echo $lang["Verificar"]?></th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                foreach ($competioresNoVerificados as $competidor) {
                                    print "<tr>";
                                    print "<td>" . $competidor->getNombre() . "</td>";
                                    print "<td>" . $competidor->getLicencia() . "</td>";
                                    print "<td><button type='button' name='verificar' id='" . $competidor->getDni() . "' class='botonVerificar btn btn-success'>".$lang["Verificar"]."</button></td>";
                                    print "<input type='hidden' id='CompetidorEstadoReal' name='CompetidorEstadoReal' required maxlength='30' class='span3' value='".$competidor->getEstado()."'>";
                                    print "</tr>";
                                }
                              ?>
                          </tbody>
                      </table>         
                      </div>
                </div>
            </section>
            <div id="dialogoVerificar" title="<?php echo $lang["ConfirmarVerificacion"]?>" class="oculto">
                <p><?php echo $lang["MensajeConfirmarVerificacion"]?></p>
            </div>
            <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
            <script src="../Scripts/verificarCompetidores.js" type="text/javascript"></script>
        </body>   
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
        } else if (idiomaSeleccionado === "en") {
            urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/English.json";
        }

        $('#tablaVerificar').DataTable({
            "language": {
                "url": urlIdioma
            },
            "columnDefs": [
                {"searchable": false, "orderable": false, "targets": [2] } 
            ]
        });
    });
</script>
        <script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
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

