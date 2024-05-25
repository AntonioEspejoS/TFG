<?php
//Vista para la gestión de arbitros
session_start();
include '../idioma/idioma.php';
// Verifica si hay una sesión de administrador de federación activa

 if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloArbitro.php';
    $modeloArbitro = new ModeloArbitro();
    $arbitros = $modeloArbitro->obtenerArbitros();
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
        
        
        
        <title><?php echo $lang["AdminArbitro"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
    </head>
    <body>
            <?php include '../header.php'; ?>
            <?php include '../menus/menuAdminFed.php'; ?>
        <section>
            <div class="container">
               <h2 class="textoCentrado"><?php echo $lang["Arbitros"]?></h2>
               <div class="table-responsive">

                <table id="tablaArbitros" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th><?php echo $lang["Nombre"]?></th>
                            <th><?php echo $lang["Correo"]?></th>
                            <th><?php echo $lang["Estado"]?></th>
                            <td><strong><?php echo $lang["Editar"]?></strong></td>
                            <td><strong><?php echo $lang["Borrar"]?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($arbitros as $arbitro) {
                            print "<tr>";
                            print "<td>" . $arbitro->getDni() . "</td>";
                            print "<td>" . $arbitro->getNombre() . "</td>";
                            print "<td>" . $arbitro->getCorreo() . "</td>";
                            if($arbitro->getEstado()==1){
                              print "<td>".$lang["Activo"]."</td>";  
                            }else{
                                print "<td>".$lang["Inactivo"]."</td>";  
                            }
                            print "<td><button type='button' name='editar' id='" . $arbitro->getDni() . "' class='btn btn-warning-custom botonEditarArbitro'>".$lang["Editar"]."</button></td>";
                            print "<td><button type='button' name='eliminar' id='" . $arbitro->getDni() . "'  class='btn btn-danger botonEliminarArbitro'>".$lang["Eliminar"]."</button></td>";
                            print "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
               </div>
            </div>
        </section>
        <!-- Dialogo Editar Arbitros -->
        <div class="oculto" id="editarArbitro" title="Editar Arbitro">
            <form action="" method="post" id="formularioArbitroEditar">
                <div class="form-group">
                    <input type="hidden" id="ArbitroDniEditar" name="ArbitroDniEditar" required maxlength="30" class="form-control">
                </div>

                <div class="form-group">
                    <label for="ArbitroNombreEditar"><?php echo $lang["Nombre"]; ?>:</label>
                    <input type="text" id="ArbitroNombreEditar" name="ArbitroNombreEditar" required maxlength="30" class="form-control">
                    <div id="errorNombre" class="errorCampo"></div>

                </div>

                <div class="form-group">
                    <label for="ArbitroEstadoEditar"><?php echo $lang["Estado"]; ?>:</label>
                    <select id="ArbitroEstadoEditar" name="ArbitroEstadoEditar" required class="form-control">
                        <option value="1"><?php echo $lang["Activo"]; ?></option>
                        <option value="0"><?php echo $lang["Inactivo"]; ?></option>
                    </select>
                </div>

                <div class="form-group" style="text-align: center">
                    <input type="button" id="botonEditarArbitro" value="<?php echo $lang["EditarArbitro"]; ?>" class="btn btn-primary">
                </div>
            </form>

        </div>
        <!-- Diálogos adicionales -->

        <div id="DialogoBorrar" title="<?php echo $lang["EliminarArbitro"]?>" class="oculto">
            <p><?php echo $lang["¿EliminarArbitro"]?></p>
        </div>
        <div id="dlgEditar" title="<?php echo $lang["EditarArbitro"]?>" class="oculto">
            <p><?php echo $lang["ArbitroEditado"]?></p>
        </div>
        <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
        <script src="../Scripts/adminArbitro.js" type="text/javascript"></script>
                    <!-- Incluir CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <!-- Incluir JS de DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jqui/datatables.min.js"></script>

    <script>
    $(document).ready(function() {
        var idiomaSeleccionado = "<?php echo (isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'es'); ?>";
        var urlIdioma;
        if (idiomaSeleccionado === "es") {
            urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json";
        } else if (idiomaSeleccionado === "in") {
            urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/English.json";
        }
        $('#tablaArbitros').DataTable({
            "language": {
                "url": urlIdioma
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
} else{
    header("Location: ../index.php");
}