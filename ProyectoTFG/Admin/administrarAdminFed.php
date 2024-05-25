<?php
//Vista para la gestión de administradores de la federación
session_start();
include '../idioma/idioma.php';

// Verifica si hay una sesión de administrador activa
 if (isset($_SESSION["admin"])) {
    include_once '../Modelo/ModeloAdminFed.php';
    $modeloAdminFed = new ModeloAdminFed();
    $administradoresFed = $modeloAdminFed->obtenerAdminsFed();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="../CSS/admin.css" rel="stylesheet" type="text/css"/>
        <link href="../CSS/principal.css" rel="stylesheet" type="text/css"/>  
        <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>        <title><?php echo $lang["AdminAdminFed"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
    </head>
    <body>
            <?php include '../header.php'; ?>
            <?php include '../menus/menuAdmin.php'; ?>
            <div class="container">
                <div class="table-responsive">
                    <h2 class="textoCentrado"><?php echo $lang["AdminFed"]?></h2>

                <table id="tablaAdminFed" class="table table-striped table-hover">

                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th><?php echo $lang["Nombre"]?></th>
                            <th><?php echo $lang["Correo"]?></th>
                            <th><?php echo $lang["Estado"]?></th>
                            <td><strong><?php echo $lang["Editar"]?></strong></td>
                            <td><strong><?php echo $lang["Eliminar"]?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($administradoresFed as $adminFed) {
                            print "<tr>";
                            print "<td>" . $adminFed->getDni() . "</td>";
                            print "<td>" . $adminFed->getNombre() . "</td>";
                            print "<td>" . $adminFed->getCorreo() . "</td>";

                            if($adminFed->getEstado()==1){
                              print "<td>".$lang["Activo"]."</td>";  
                            }else{
                                print "<td>".$lang["Inactivo"]."</td>";  
                            }
                            print "<td><button type='button' name='editar' id='" . $adminFed->getDni() . "' class='btn btn-warning-custom botonEditarAdminFed'>".$lang["Editar"]."</button></td>";
                            print "<td><button type='button' name='eliminar' id='" . $adminFed->getDni() . "'  class='btn btn-danger botonEliminarAdminFed'>".$lang["Eliminar"]."</button></td>";
                            print "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>

        <!-- Dialogo Editar AdminFed -->
        <div class="oculto" id="editarAdminFed" title="<?php echo $lang["EditarAdmin"]?>">
            <form action="" method="post" id="formularioAdminFedEditar">
                <fieldset id="datosAdminFedEditar">
                    <input type="hidden" id="AdminFedDniEditar" name="AdminFedDniEditar" required maxlength="30">

                    <div class="form-group">
                        <label for="AdminFedNombreEditar"><?php echo $lang["Nombre"]; ?>:</label>
                        <input type="text" id="AdminFedNombreEditar" name="AdminFedNombreEditar" required maxlength="30" class="form-control">
                         <div id="errorNombre" class="errorCampo"></div>

                    </div>

                    <div class="form-group">
                        <label for="AdminFedEstadoEditar"><?php echo $lang["Estado"]; ?>:</label>
                        <select id="AdminFedEstadoEditar" name="AdminFedEstadoEditar" required class="form-control">
                            <option value="1"><?php echo $lang["Activo"]; ?></option>
                            <option value="0"><?php echo $lang["Inactivo"]; ?></option>
                        </select>
                    </div>

                    <div class="form-group text-center">
                        <input type="button" id="botonEditarAdminFed" class="btn btn-primary" value="<?php echo $lang["EditarAdmin"]; ?>">
                    </div>
                </fieldset>
            </form>

        </div>
        <!-- Diálogos adicionales -->
        <div id="DialogoBorrar" title="<?php echo $lang["EliminarAdmin"]?>" class="oculto">
            <p><?php echo $lang["¿EliminarAdmin"]?></p>
        </div>
        <div id="dlgEditar" title="<?php echo $lang["EditarAdmin"]?>" class="oculto">
            <p><?php echo $lang["AdminEditado"]?></p>
        </div>
        <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
        <script src="../Scripts/adminAdminFed.js" type="text/javascript"></script>
        
    <!-- Incluir CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <!-- Incluir JS de DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
    $(document).ready(function() {
        var idiomaSeleccionado = "<?php echo (isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'es'); ?>"; // 'es' como valor predeterminado
        var urlIdioma;
        if (idiomaSeleccionado === "es") {
            urlIdioma = "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json";
        } else if (idiomaSeleccionado === "in") {
            urlIdioma = "//cdn.datatables.net/plug-ins/1.10.25/i18n/English.json";
        }
        $('#tablaAdminFed').DataTable({
            "language": {
                "url":urlIdioma
            },
            "columnDefs": [
                { "searchable": false, "orderable": false, "targets": [4, 5] }
            ]
        });
    });
</script>
        <script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
                errorCamposVacios: "<?php echo $lang['ErrorCamposVacios']; ?>",
                errorNombre: "<?php echo $lang['ErrorNombre']; ?>",
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
