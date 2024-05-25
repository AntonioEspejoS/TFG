<?php
//Vista de la lista de torneos para ver los resultados y enfrentamiento para usuarios no registrados
session_start();
include '../idioma/idioma.php';
    include_once '../Modelo/ModeloTorneo.php';
    $modeloTorneo = new ModeloTorneo();
    $torneos = $modeloTorneo->obtenerTorneos();  
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $lang["TorneoResultados"]?></title>
            <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            <link href="../CSS/principal.css" rel="stylesheet" type="text/css"/>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        </head>
        <body>
            <?php include '../header.php'; 
                include '../menus/menuInvitado.php';    
            ?>
            <div class="container">  
                <h2 class="textoCentrado "><?php echo $lang["Torneos"]?></h2>
                <div class="table-responsive">
                <table id="tablaTorneosResultados" class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $lang["Torneo"]?></th>
                            <th><?php echo $lang["Fecha"]?></th>
                            <td><strong><?php echo $lang["EnfrentamientosYResultados"]?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($torneos as $torneo) {
                            if($torneo->getEstado()==0){
                                print "<tr>";
                                print "<td>" . $torneo->getDescripcion()  . "</td>";
                                print "<td>" . $torneo->getFechatorneo() . "</td>";
                                print "<td><a href='listaCategoriasResultadosInvitados.php?idtorneo=" . $torneo->getIdtorneo() . "'><button type='button' name='resultados' class='btn btn-success'>".$lang["VerCategorias"]."</button></a></td>";
                                print "</tr>";    
                            }                       
                        }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>

        </body>
                 <!-- Incluir CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <!-- Incluir JS de DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
    $(document).ready(function() {
        var idiomaSeleccionado = "<?php echo (isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'es'); ?>"; // 'es' como valor predeterminado
        var urlIdioma;
        console.log(idiomaSeleccionado);
        if (idiomaSeleccionado === "es") {
            urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json";
        } else if (idiomaSeleccionado === "in") {
            urlIdioma = "https://cdn.datatables.net/plug-ins/1.10.25/i18n/English.json";
        }
        $('#tablaTorneosResultados').DataTable({
            "language": {
                "url": urlIdioma
            },
            "columnDefs": [
                {"searchable": false, "orderable": false, "targets": [2] } // Ajusta los índices según las columnas que quieras hacer no ordenables
            ]
        });
    });
</script>
    </html>
    

