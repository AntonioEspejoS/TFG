<?php
//Vista de los arbitros asociados a torneos
session_start();
include '../idioma/idioma.php';
// Verifica si hay una sesión de administrador de federación activa
if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloBD.php';
    include_once '../Modelo/ModeloGestion.php';
    include_once '../Modelo/ModeloArbitro.php';
    include_once '../Modelo/ModeloTorneo.php';

    $idTorneo = $_GET['idtorneo'];
    $modeloGestion = new ModeloGestion();
    $modeloArbitro = new ModeloArbitro();
    $modeloTorneo = new ModeloTorneo();
    $torneo=$modeloTorneo->obtenerTorneoPorId($idTorneo);
    $gestiones=$modeloGestion->obtenerGestionesPorIdTorneo($torneo);
    ?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="../CSS/admin.css" rel="stylesheet" type="text/css"/>
        <link href="../CSS/principal.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <title><?php echo $lang["ArbitrosGestion"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
    </head>
        <body>
        <?php include '../header.php'; ?>
        <?php include '../menus/menuAdminFed.php'; ?>
            <section>
                <div class="container">
                <input class="oculto" type="text" id="idTorneoGeneral" name="idTorneoGeneral" value="<?php echo $idTorneo; ?>" maxlength="30">

                <h2 class="textoCentrado"><?php echo $lang["ArbitrosGestion"]?></h2>
               <?php print "<td><button type='button' name='addArbitro' id='" . $idTorneo . "'  class='btn btn-primary addArbitro'>".$lang["AddArbitro"]."</button></td>";?>
                <div class="table-responsive">
                <table id="tablaRegistrados" class="table table-striped">
                    <thead>
                            <th>DNI</th>
                            <th><?php echo $lang["Nombre"]?></th>
                            <th><?php echo $lang["Eliminar"]?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($gestiones as $gestion) {     
                            $arbitro=$modeloArbitro->obtenerArbitroPorDNI($gestion->getDniArbitro());
                            print "<tr>";
                            print "<td>". $arbitro->getDni()."</td>"; 
                            print "<td>". $arbitro->getNombre()."</td>"; 
                            print "<td><button type='button' name='eliminar' id='" . $arbitro->getDni() . "'  class='btn btn-danger eliminar'>".$lang["Eliminar"]."</button></td>";
                            print "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>    
                </div> 
                <!-- Añadir arbitro -->
                <div class="oculto" id="addArbitro" title="<?php echo $lang["AddArbitro"]?>">
                    <form action="" method="post" id="formularioArbitro" name="formularioArbitro">
                        <fieldset id="datosArbitro" class="p-3">
                            <input type="hidden" id="idTorneo" name="idTorneo" value="<?php echo $idTorneo; ?>" maxlength="30">
                            <div class="form-group">
                                <label for="listaArbitros"><?php echo $lang["SeleccionaArbitro"]; ?>:</label>
                                <select id="listaArbitros" name="listaArbitros" class="form-control">
                                    <!-- Las opciones se cargarán aquí -->
                                </select>
                            </div>
                            <div class="form-group text-center mt-4">
                                <input type="button" id="add" class="btn btn-primary" value="<?php echo $lang["AddArbitro"]?>">
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!-- Diálogos adicionales -->
                <!-- CONFIRMAR ELIMINACION -->
                <div id="DialogoBorrar" title="<?php echo $lang["EliminarArbitro"]?>" class="oculto">
                    <p><?php echo $lang["¿EliminarArbitroTorneo"]?></p>
                </div>
                <!-- CONFIRMAR Arbitro añadido -->
                <div id="dlgInsertar" title="Agregar árbitro" class="oculto">
                    <p><?php echo $lang["ArbitroAdd"]?></p>
                </div>
            </section>
           

            <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
            <script type="text/javascript">
                var mensajeSeleccionaArbitro = "<?php echo $lang['SeleccionaElArbitro']; ?>";
            </script>
            <script src="../Scripts/adminArbitrosTorneos.js" type="text/javascript"></script>

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

        $('#tablaRegistrados').DataTable({
            "language": {
                "url": urlIdioma
            },
            "columnDefs": [
                { "searchable": false, "orderable": false, "targets": [2] } // Ajusta los índices según las columnas que quieras hacer no ordenables
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
                errorConexion:"<?php echo $lang['ErrorDeConexion']; ?>",
                introduceUnArbitro:"<?php echo $lang['IntroduceUnArbitro']; ?>"
            };
 </script>
        </body>
    </html>
    <?php
} else{
    header("Location: ../index.php");
}