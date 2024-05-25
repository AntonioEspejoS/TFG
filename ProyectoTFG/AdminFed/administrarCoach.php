<?php
//Vista para la gestión de coaches
session_start();
include '../idioma/idioma.php';
// Verifica si hay una sesión de administrador de federación activa

 if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloCoach.php';
    include_once '../Modelo/ModeloClub.php'; 
    $modeloCoach = new ModeloCoach();
    $coaches = $modeloCoach->obtenerCoaches();
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
        <title><?php echo $lang["AdminCoach"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
    </head>
    <body>
        <?php include '../header.php'; ?>
        <?php include '../menus/menuAdminFed.php'; ?>
            <div class="container">
                <h2 class="textoCentrado">Coachs</h2>
                <div class="table-responsive">
                <table id="tablaCoaches" class="table table-striped table-hover">
                    <thead>
                            <th>DNI</th>
                            <th><?php echo $lang["Nombre"]?></th>
                            <th><?php echo $lang["Pass"]?></th>
                            <th><?php echo $lang["Club"]?></th>
                            <th><?php echo $lang["Licencia"]?></th>
                            <th><?php echo $lang["Estado"]?></th>
                             <td><strong><?php echo $lang["Editar"]?></strong></td>
                            <td><strong><?php echo $lang["Borrar"]?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($coaches as $coach) {
                            print "<tr>";
                            print "<td>" . $coach->getDni() . "</td>";
                            print "<td>" . $coach->getNombre() . "</td>";
                            print "<td>" . $coach->getCorreo() . "</td>";
                            $clubCoach=$modeloClub->obtenerClubPorId($coach->getClub());
                            print "<td>" . $clubCoach->getNombre() . "</td>";
                            print "<td>" . $coach->getLicencia() . "</td>";
                            if($coach->getEstado()==1){
                              print "<td>".$lang["Activo"]."</td>";  
                            }else{
                                print "<td>".$lang["Inactivo"]."</td>";  
                            }
                            print "<td><button type='button' name='editar' id='" . $coach->getDni() . "' class='btn btn-warning-custom botonEditarCoach'>".$lang["Editar"]."</button></td>";
                            print "<td><button type='button' name='eliminar' id='" . $coach->getDni() . "'  class='btn btn-danger botonEliminarCoach'>".$lang["Eliminar"]."</button></td>";
                            print "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>    
            </div>

        <!-- Dialogo Editar Coach -->
        <div class="oculto" id="editarCoach" title="<?php echo $lang["EditarCoach"]?>"">
             <form action="" method="post" id="formularioCoachEditar">
                <div class="form-group">
                    <input type="hidden" id="CoachDniEditar" name="CoachDniEditar" required maxlength="30" class="form-control">
                </div>

                <div class="form-group">
                    <label for="CoachNombreEditar"><?php echo $lang["Nombre"]; ?>:</label>
                    <input type="text" id="CoachNombreEditar" name="CoachNombreEditar" required maxlength="40" class="form-control">
                    <div id="errorNombre" class="errorCampo"></div>

                </div>

                <div class="form-group">
                    <label for="CoachClubEditar"><?php echo $lang["Club"]; ?>:</label>
                    <select name="CoachClubEditar" id="CoachClubEditar" required class="form-control">
                        <option selected="true" disabled="disabled"><?php echo $lang["SeleccionaElClub"]; ?>...</option>
                        <?php foreach ($clubes as $club) {
                            echo "<option value='" . $club->getIdclub() . "'>" . $club->getNombre() . "</option>";
                        } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="CoachLicenciaEditar"><?php echo $lang["Licencia"]; ?>:</label>
                    <input type="text" id="CoachLicenciaEditar" name="CoachLicenciaEditar" required maxlength="20" class="form-control">
                    <div id="errorLicencia" class="errorCampo"></div>
                </div>

                <div class="form-group">
                    <label for="CoachEstadoEditar"><?php echo $lang["Estado"]; ?>:</label>
                    <select id="CoachEstadoEditar" name="CoachEstadoEditar" required class="form-control">
                        <option value="1"><?php echo $lang["Activo"]; ?></option>
                        <option value="0"><?php echo $lang["Inactivo"]; ?></option>
                    </select>
                </div>

                <div class="form-group" style="text-align: center">
                    <input type="button" id="botonEditarCoach" value="<?php echo $lang["EditarCoach"]; ?>" class="btn btn-primary">
                </div>
            </form>

        </div>
        <div id="DialogoBorrar" title="<?php echo $lang["EliminarCoach"]?>" class="oculto">
            <p><?php echo $lang["¿EliminarCoach"]?></p>
        </div>
        <div id="dlgEditar" title="<?php echo $lang["EditarCoach"]?>" class="oculto">
            <p><?php echo $lang["CoachEditado"]?></p>
        </div>
        <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
        <script src="../Scripts/adminCoach.js" type="text/javascript"></script>
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
        $('#tablaCoaches').DataTable({
            "language": {
                "url": urlIdioma
            },
            "columnDefs": [
                {"searchable": false, "orderable": false, "targets": [6, 7] }
            ]
        });
    });
</script>
<script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
                errorCamposVacios: "<?php echo $lang['ErrorCamposVacios']; ?>",
                errorNombre: "<?php echo $lang['ErrorNombre']; ?>",
                errorLicencia: "<?php echo $lang['ErrorLicencia']; ?>",
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