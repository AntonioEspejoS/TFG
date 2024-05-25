<?php
//Vista para la gestión de clubes
session_start();
include '../idioma/idioma.php';
// Verifica si hay una sesión de administrador de federación activa

 if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloClub.php';
    $modeloClub = new ModeloClub();
    $clubes = $modeloClub->obtenerClubes();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="../CSS/principal.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <title><?php echo $lang["AdminClubes"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
    </head>
    <body>
            <?php include '../header.php'; ?>
            <?php include '../menus/menuAdminFed.php'; ?>
        <section>
            <div class="container">
               <h2 class="textoCentrado"><?php echo $lang["Clubes"]?></h2>
               <div class="table-responsive">
                <table id="tablaClubes" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?php echo $lang["Nombre"]?></th>
                            <th><?php echo $lang["Localidad"]?></th>
                            <td><strong><?php echo $lang["Editar"]?></strong></td>
                            <td><strong><?php echo $lang["Borrar"]?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($clubes as $club) {
                            print "<tr>";
                            print "<td>" . $club->getNombre() . "</td>";
                            print "<td>" . $club->getLocalidad() . "</td>";
                            print "<td><button type='button' name='editar' id='" .$club->getIdclub(). "' class='btn btn-warning-custom botonEditarClub'>".$lang["Editar"]."</button></td>";
                            print "<td><button type='button' name='eliminar' id='" . $club->getIdclub() . "'  class='btn btn-danger botonEliminarClub'>".$lang["Eliminar"]."</button></td>";
                            print "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
               </div>   
            </div>
        </section>    
        <!-- Dialogo Editar Club -->
        <div class="oculto" id="editarClub" title="<?php echo $lang["EditarClub"]?>">
            <form action="" method="post" id="formularioClubEditar">
                <div class="form-group">
                    <input type="hidden" id="ClubId" name="ClubId" required maxlength="30" class="form-control">
                </div>

                <div class="form-group">
                    <label for="ClubNombreEditar"><?php echo $lang["Nombre"]; ?>:</label>
                    <input type="text" class="form-control" id="ClubNombreEditar" name="ClubNombreEditar" required maxlength="30">
                </div>

                <div class="form-group">
                    <label for="ClubLocalidadEditar"><?php echo $lang["Localidad"]; ?>:</label>
                    <select class="form-control" id="ClubLocalidadEditar" name="ClubLocalidadEditar">
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

                <div class="form-group" style="text-align: center">
                    <input type="button" id="botonEditarClub" value="<?php echo $lang["EditarClub"]; ?>" class="btn btn-primary">
                </div>
            </form>

            
            
            
            
        </div>
        <div id="DialogoBorrar" title="<?php echo $lang["EliminarClub"]?>" class="oculto">
            <p><?php echo $lang["¿EliminarClub"]?></p>
        </div>
        <div id="dlgEditar" title="<?php echo $lang["EditarClub"]?>" class="oculto">
            <p><?php echo $lang["ClubEditado"]?></p>
        </div>
        <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
        <script src="../Scripts/adminClub.js" type="text/javascript"></script>
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
        $('#tablaClubes').DataTable({
            "language": {
                "url": urlIdioma
            },
            "columnDefs": [
                {"searchable": false, "orderable": false, "targets": [2, 3] } 
            ]
        });
    });
</script>
        <script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
                errorCamposVacios: "<?php echo $lang['ErrorCamposVacios']; ?>",
                aceptar:"<?php echo $lang['Aceptar']; ?>",
                si:"<?php echo $lang['Si']; ?>",
                cancelar:"<?php echo $lang['Cancelar']; ?>",
                errorConexion:"<?php echo $lang['ErrorDeConexion']; ?>"
            };
        </script>
    </body>
</html>
  <?php
}else{
    header("Location: ../index.php");
}