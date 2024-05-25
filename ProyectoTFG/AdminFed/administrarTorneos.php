<?php
//Vista para la gestión de torneos
session_start();
include '../idioma/idioma.php';
// Verifica si hay una sesión de administrador de federación activa

 if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloTorneo.php'; 
    include_once '../Modelo/ModeloGestion.php';
    $modeloGestion = new ModeloGestion();
    $modeloTorneo = new ModeloTorneo();
    $torneos = $modeloTorneo->obtenerTorneos();  
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--<link href="../CSS/admin.css" rel="stylesheet" type="text/css"/>-->
        <link href="../CSS/principal.css" rel="stylesheet" type="text/css"/>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

        <title><?php echo $lang["AdminTorneos"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
    </head>
    <body>
        <?php include '../header.php'; ?>
        <?php include '../menus/menuAdminFed.php'; ?>
        <div class="container" id="container-torneos">
        <h2 class="textoCentrado"><?php echo $lang["Torneos"]?></h2>
        <button id="nuevoTorneo" type='button' name='crearTorneo'  class='btn btn-primary'><?php echo $lang["CrearTorneo"]?></button>
        <div class="table-responsive">
        <table id="tablaTorneos" class="table table-striped">
            <thead>
                <tr>
                    <th class="text-nowrap"><?php echo $lang["Descripcion"]?></th>
                    <th><?php echo $lang["CierreInscripciones"]?></th>
                    <th ><?php echo $lang["Fecha"]?></th>
                    <th><?php echo $lang["Inscripciones"]?></th>
                    <th><?php echo $lang["Finalizado"]?></th>
                    <td><strong><?php echo $lang["Categorias"]?></strong></td>
                    <td><strong><?php echo $lang["Competidores"]?></strong></td>
                    <td><strong><?php echo $lang["Arbitros"]?></strong></td>
                     <td><strong><?php echo $lang["Editar"]?></strong></td>
                    <td><strong><?php echo $lang["Borrar"]?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($torneos as $torneo) {
                    $gestiones = $modeloGestion->obtenerGestionesPorIdTorneo($torneo);
                    $numArbitros = count($gestiones);

                    $fechaInscripcion = date('d/m/Y', strtotime($torneo->getFechaInscripcion()));
                    $fechaTorneo = date('d/m/Y', strtotime($torneo->getFechatorneo()));

                    
                    print "<tr>";
                    print "<td>" . $torneo->getDescripcion(). "</td>";
                    print "<td>" . $fechaInscripcion . "</td>";
                    print "<td class='text-nowrap'>" . $fechaTorneo . "</td>";
                    if($torneo->getEstado() == 1){
                       print "<td>".$lang["Activas"]."</td>"; 
                    }else{
                      print "<td>".$lang["Inactivas"]."</td>";   
                    }
                    if($torneo->getFinalizado() == 1){
                       print "<td>".$lang["Si"]."</td>"; 
                    }else{
                      print "<td>No</td>";   
                    }
                    print "<td><a href='administrarCategorias.php?idtorneo=". $torneo->getIdtorneo() ."'><button type='button'  class='btn btn-success'>".$lang["Visualizar"]."</button></a></td>";
                    print "<td><a href='administrarRegistrados.php?idtorneo=" . $torneo->getIdtorneo() . "'><button type='button' class='btn btn-success'>".$lang["Visualizar"]."</button></td>";
                    if ($numArbitros > 0) {
                        print "<td><a href='administrarArbitrosTorneos.php?idtorneo=" . $torneo->getIdtorneo() . "'><button type='button' class='btn btn-success'>".$lang["Visualizar"]."</button></a></td>";
                    } else {
                        print "<td class='text-nowrap'><a href='administrarArbitrosTorneos.php?idtorneo=" . $torneo->getIdtorneo() . "'><i class='fas fa-exclamation-triangle'style='color:#ffc107 ; margin-right: 5px;' title='".$lang["NoHayArbitrosAsociados"]."'></i><button type='button' class='btn btn-warning'>".$lang["Visualizar"]."</button></a></td>";
                    }
                    print "<td><button type='button' name='editar' id='" . $torneo->getIdtorneo() . "'  class='btn btn-warning-custom editar'>".$lang["Editar"]."</button></td>";
                    print "<td><button type='button' name='eliminar' id='" . $torneo->getIdtorneo() . "'  class='btn btn-danger eliminar'>".$lang["Eliminar"]."</button></td>";
                    print "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>    
    </div>
</div>
<!-- CREAR NUEVO TORNEO -->
<div class="oculto" id="crearTorneo" title="<?php echo $lang["CrearTorneo"]; ?>">
    <form action="" method="post" id="formularioTorneo" name="formularioTorneo">
    <fieldset id="datosTorneo">
        <!-- Campo oculto, no necesita estar en un form-group ya que no se muestra -->
        <input class="oculto form-control" type="text" id="idTorneo" name="idTorneo" maxlength="30">

        <div class="form-group row">
            <div class="col-md-6">
                <label for="TorneoDescripcion"><?php echo $lang["Descripcion"]; ?>:</label>
                <input type="text" class="form-control" id="TorneoDescripcion" name="TorneoDescripcion" maxlength="30">
            </div>
            <div class="col-md-6">
                <label for="TorneoFechaInscripcion"><?php echo $lang["FechaLimiteInscripcion"]; ?>:</label>
                <input type="date" class="form-control" id="TorneoFechaInscripcion" name="TorneoFechaInscripcion" maxlength="40">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="TorneoFecha"><?php echo $lang["Fecha"]; ?>:</label>
                <input type="date" class="form-control" id="TorneoFecha" name="TorneoFecha" maxlength="40">
            </div>
            <div class="col-md-6">
                                
                <label for="estadoTorneo"><?php echo $lang["Inscripciones"]; ?>:</label>
                <select class="form-control" id="estadoTorneo" name="estadoTorneo">
                    <option value="" disabled="disabled"><?php echo $lang["SeleccioneUnaOpcion"]; ?>...</option>
                    <option  value="1"  selected="selected"><?php echo $lang["Activas"]; ?></option>
                    <option value="0"><?php echo $lang["Inactivas"]; ?></option>
                </select>
                
                
                
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="generoTorneo"><?php echo $lang["Genero"]; ?>:</label>
                <select class="form-control" id="generoTorneo" name="generoTorneo">
                    <option value="ambos"><?php echo $lang["Ambos"]; ?></option>
                    <option value="masculino"><?php echo $lang["Masculino"]; ?></option>
                    <option value="femenino"><?php echo $lang["Femenino"]; ?></option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="modalidadTorneo"><?php echo $lang["Modalidad"]; ?>:</label>
                <select class="form-control" id="modalidadTorneo" name="modalidadTorneo">
                    <option value="todas"><?php echo $lang["TodasLasModalidades"]; ?></option>
                    <option value="lowkick">Low Kick</option>
                    <option value="fullcontact">Full Contact</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="categoriaEdadTorneo"><?php echo $lang["CategoriaEdad"]; ?>:</label>
                <select class="form-control" id="categoriaEdadTorneo" name="categoriaEdadTorneo">
                    <option value="todas"><?php echo $lang["TodasCategoriasEdad"]; ?></option>
                    <option value="junior">Junior</option>
                    <option value="senior">Senior</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="numeroPlazasTorneo"><?php echo $lang["NumeroDePlazas"]; ?>:</label>
                <input type="number" class="form-control" id="numeroPlazasTorneo" name="numeroPlazasTorneo" min="2" max="8">
            </div>
        </div>
        <br>
        <fieldset id="btnAgregar" style="text-align: center">
            <input type="button" id="crear" value="<?php echo $lang["CrearTorneo"]; ?>" class="btn btn-primary">
        </fieldset>
    </fieldset>
</form>

</div>
<!-- EDITAR TORNEO -->
<div class="oculto" id="editarTorneo" title="<?php echo $lang["EditarTorneo"]; ?>">
    <form action="" method="post" id="formularioTorneoEditar" name="formularioTorneoEditar">
    <fieldset id="datosTorneoEditar">
        <!-- Campo oculto, no necesita estar en un form-group ya que no se muestra -->
        <input type="text" id="TorneoIdEditar" name="TorneoIdEditar" required maxlength="30" class="span3 oculto">

        <div class="form-group row">
            <div class="col-md-6">
                <label for="TorneoDescripcionEditar"><?php echo $lang["Descripcion"]; ?>:</label>
                <input type="text" class="form-control" id="TorneoDescripcionEditar" name="TorneoDescripcionEditar" required maxlength="30">
            </div>
            <div class="col-md-6">
                <label for="TorneoFechaInscripcionEditar"><?php echo $lang["FechaLimiteInscripcion"]; ?>:</label>
                <input type="date" class="form-control" id="TorneoFechaInscripcionEditar" name="TorneoFechaInscripcionEditar" required maxlength="40">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="TorneoFechaEditar"><?php echo $lang["Fecha"]; ?>:</label>
                <input type="date" class="form-control" id="TorneoFechaEditar" name="TorneoFechaEditar" required maxlength="40">
            </div>
            <div class="col-md-6">
                <label for="estadoTorneoEditar"><?php echo $lang["Inscripciones"]; ?>:</label>
                <select class="form-control" id="estadoTorneoEditar" name="estadoTorneoEditar" required>
                    <option value="1"><?php echo $lang["Activas"]; ?></option>
                    <option value="0"><?php echo $lang["Inactivas"]; ?></option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="finalizadoTorneoEditar"><?php echo $lang["Finalizado"]; ?>:</label>
                <select class="form-control" id="finalizadoTorneoEditar" name="finalizadoTorneoEditar" required>
                    <option value="1"><?php echo $lang["Finalizado"]; ?></option>
                    <option value="0"><?php echo $lang["NoFinalizado"]; ?></option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="numeroPlazasTorneoEditar"><?php echo $lang["NumeroDePlazas"]; ?>:</label>
                <input type="number" class="form-control" id="numeroPlazasTorneoEditar" name="numeroPlazasTorneoEditar" min="2" max="8">
            </div>
        </div>
        <br>
        <fieldset id="btnAgregar" style="text-align: center">
            <input type="button" id="editar" value="<?php echo $lang["EditarTorneo"]?>" class="btn btn-primary">
        </fieldset>
    </fieldset>
</form>

</div>
<!-- CONFIRMAR ELIMINACION -->
<div id="DialogoBorrar" title="<?php echo $lang["EliminarTorneo"]?>" class="oculto">
    <p><?php echo $lang["¿EliminarTorneo"]?></p>
</div>
<!-- CONFIRMAR CREACION DE TORNEO -->
<div id="dlgInsertar" title="<?php echo $lang["CrearTorneo"]?>" class="oculto">
    <p><?php echo $lang["TorneoCreado"]?></p>
</div>
<!-- CONFIRMAR MODIFICACION DE TORNEO -->
<div id="dlgEditar" title="<?php echo $lang["EditarTorneo"]?>" class="oculto">
    <p><?php echo $lang["TorneoEditado"]?></p>
</div>
        <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
        <script src="../Scripts/adminTorneo.js" type="text/javascript"></script>
        
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
        $('#tablaTorneos').DataTable({
            "language": {
                "url": urlIdioma
            },
            "columnDefs": [
                {"searchable": false, "orderable": false, "targets": [5, 6,7,8,9] } // Ajusta los índices según las columnas que quieras hacer no ordenables
            ]
        });
    });
    </script>
     <script type="text/javascript">
            // Definir un objeto en JavaScript para los mensajes de error
            var mensajesError = {
                errorCamposVacios: "<?php echo $lang['ErrorCamposVacios']; ?>",
                errorPlazas:"<?php echo $lang['ErrorPlazas']; ?>",
                errorFechasTorneos:"<?php echo $lang['ErrorFechasTorneos']; ?>",
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
