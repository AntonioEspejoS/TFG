<?php
//Vista para la gestión de competidores
session_start();
include '../idioma/idioma.php';
// Verifica si hay una sesión de administrador de federación activa

 if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloCompetidor.php';
    include_once '../Modelo/ModeloClub.php'; 
    $modeloCompetidor = new ModeloCompetidor();
    $competidores = $modeloCompetidor->obtenerCompetidores();  
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
        <title><?php echo $lang["AdminCompetidores"]?></title
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
    </head>
    <body>
            <?php include '../header.php'; ?>
            <?php include '../menus/menuAdminFed.php'; ?>
            <div class="container" id="container-competidores">
                <h2 class="textoCentrado"><?php echo $lang["Competidores"]?></h2>
                <div class="table-responsive">
                <table id="tablaCompetidores" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th><?php echo $lang["Nombre"]?></th>
                            <th><?php echo $lang["Correo"]?></th>
                            <th><?php echo $lang["Club"]?></th>
                            <th><?php echo $lang["Licencia"]?></th>
                            <th><?php echo $lang["FechaNacimiento"]?></th>
                            <th><?php echo $lang["Sexo"]?></th>
                            <th><?php echo $lang["Peso"]?></th>
                            <th><?php echo $lang["Estado"]?></th>
                            <td><strong><?php echo $lang["Editar"]?></strong></td>
                            <td><strong><?php echo $lang["Borrar"]?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($competidores as $competidor) {
                           $fechaNacimiento = date('d/m/Y', strtotime($competidor->getFech_nac()));

                            print "<tr>";
                            print "<td>" . $competidor->getDni() . "</td>";
                            print "<td>" . $competidor->getNombre() . "</td>";
                            print "<td>" . $competidor->getCorreo() . "</td>";
                            $clubCompetidor=$modeloClub->obtenerClubPorId($competidor->getClub());
                            print "<td>" . $clubCompetidor->getNombre() . "</td>";
                            print "<td>" . $competidor->getLicencia() . "</td>";
                            print "<td>" . $fechaNacimiento . "</td>";
                            print "<td>" . $competidor->getSexo() . "</td>";
                            if($competidor->getPeso()==90){
                                        print "<td class='text-nowrap'>>";
                                    }else{
                                        print "<td class='text-nowrap'><";
                                    }
                            print  $competidor->getPeso() . " Kg</td>";
                            if($competidor->getEstado()==1 || $competidor->getEstado()==3){
                              print "<td>".$lang["Activo"]."</td>";  
                            }else{
                                print "<td>".$lang["Inactivo"]."</td>";  
                            }
                            print "<td><button type='button' name='editar' id='" . $competidor->getDni() . "' class='btn btn-warning-custom botonEditarCompetidor'>".$lang["Editar"]."</button></td>";
                            print "<td><button type='button' name='eliminar' id='" . $competidor->getDni() . "'  class='btn btn-danger botonEliminarCompetidor'>".$lang["Eliminar"]."</button></td>";
                            print "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>    
            </div>

        <!-- Dialogo Editar Competidor -->
        <div class="oculto" id="editarCompetidor" title="<?php echo $lang["EditarCompetidor"]?>">
                <form action="" method="post" id="formularioCompetidorEditar">
    <div class="form-group row">
        <input type="hidden" id="CompetidorDniEditar" name="CompetidorDniEditar" class="form-control">
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="CompetidorNombreEditar"><?php echo $lang["Nombre"]; ?>:</label>
            <input type="text" id="CompetidorNombreEditar" name="CompetidorNombreEditar" required maxlength="30" class="form-control">
            <div id="errorNombre" class="errorCampo"></div>
        </div>
        <div class="col-md-6">
            <label for="CompetidorClubEditar"><?php echo $lang["Club"]; ?>:</label>
            <select name="CompetidorClubEditar" id="CompetidorClubEditar" required class="form-control">
                <option selected="true" disabled="disabled"><?php echo $lang["SeleccionaElClub"]; ?>...</option>
                <?php foreach ($clubes as $club) {
                    echo "<option value='" . $club->getIdclub() . "'>" . $club->getNombre() . "</option>";
                } ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="CompetidorLicenciaEditar"><?php echo $lang["Licencia"]; ?>:</label>
            <input type="text" id="CompetidorLicenciaEditar" name="CompetidorLicenciaEditar" required maxlength="30" class="form-control">
            <div id="errorLicencia" class="errorCampo"></div>
        </div>
        <div class="col-md-6">
            <label for="CompetidorFechaEditar"><?php echo $lang["FechaNacimiento"]; ?>:</label>
            <input type="date" name="CompetidorFechaEditar" id="CompetidorFechaEditar" required class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="sexoCompetidorEditar"><?php echo $lang["Sexo"]; ?>:</label>
            <select name="peso" id="sexoCompetidorEditar" required class="form-control">
                <option selected="true" disabled="disabled"><?php echo $lang["SeleccionaSexo"]; ?>...</option>
                <option value="m"><?php echo $lang["Masculino"]; ?></option>
                <option value="f"><?php echo $lang["Femenino"]; ?></option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="pesoCompetidorEditar"><?php echo $lang["Peso"]; ?></label>
            <select name="peso" id="pesoCompetidorEditar" required class="form-control" data-peso-actual="74">
                <!-- Las opciones se añadirán dinámicamente -->
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label for="CompetidorEstadoEditar"><?php echo $lang["Estado"]; ?>:</label>
            <select id="CompetidorEstadoEditar" name="CompetidorEstadoEditar" required class="form-control">
                <option value="1"><?php echo $lang["Activo"]; ?></option>
                <option value="0"><?php echo $lang["Inactivo"]; ?></option>
            </select>
            <input type="hidden" id="CompetidorEstadoReal" name="CompetidorEstadoReal" required maxlength="30" class="span3">
        </div>
    </div>
                    <br>
    <div class="form-group" style="text-align: center">
        <input type="button" id="botonEditarCompetidor" value="<?php echo $lang["EditarCompetidor"]; ?>" class="btn btn-primary">
    </div>
</form>


            </div>
        <div id="DialogoBorrar" title="<?php echo $lang["EliminarCompetidor"]?>" class="oculto">
            <p><?php echo $lang["¿EliminarCompetidor"]?></p>
        </div>
        <div id="dlgEditar" title="<?php echo $lang["EditarCompetidor"]?>" class="oculto">
            <p><?php echo $lang["CompetidorEditado"]?></p>
        </div>
        <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
        
        
    <!-- Incluir CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <!-- Incluir JS de DataTables -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        var idiomaSeleccionado = "<?php echo (isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'es'); ?>"; // 'es' como valor predeterminado
        var urlIdioma;
        if (idiomaSeleccionado === "es") {
            urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json";
        } else if (idiomaSeleccionado === "in") {
            urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/English.json";
        }
        $('#tablaCompetidores').DataTable({
            "language": {
                "url": urlIdioma
            },
            "columnDefs": [
                {"searchable": false, "orderable": false, "targets": [9,10] } // Ajusta los índices según las columnas que quieras hacer no ordenables
            ]
        });
    });
</script>
<script src="../Scripts/adminCompetidor.js" type="text/javascript"></script>
        <script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
                errorCamposVacios: "<?php echo $lang['ErrorCamposVacios']; ?>",
                seleccionaPeso: "<?php echo $lang['SeleccionaElPeso']; ?>",
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
