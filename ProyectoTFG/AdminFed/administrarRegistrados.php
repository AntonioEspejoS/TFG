<?php
//Vista para los competidores registrados
session_start();
include '../idioma/idioma.php';
// Verifica si hay una sesión de administrador de federación activa

if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloBD.php';
    include_once '../Modelo/ModeloRegistrado.php';
    $idTorneo = $_GET['idtorneo'];
    $modeloRegistrado = new ModeloRegistrado();
    $listaCompetidores=$modeloRegistrado->obtenerListaCompetidoresRegistradosTorneo($idTorneo);
    
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
        <title><?php echo $lang["CompetidoresRegistrados"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">
    </head>
        <body>
        <?php include '../header.php'; ?>
        <?php include '../menus/menuAdminFed.php'; ?>
            <section>
                <div class="container">
                <h2 class="textoCentrado"><?php echo $lang["CompetidoresRegistrados"]?></h2>
                <div class="table-responsive">
                <table id="tablaRegistrados" class="table table-striped">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th><?php echo $lang["Nombre"]?></th>
                            <th><?php echo $lang["Sexo"]?></th>
                            <th><?php echo $lang["Peso"]?></th>
                            <th><?php echo $lang["Edad"]?></th>
                            <th><?php echo $lang["Modalidad"]?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listaCompetidores as $item) {  
                            print "<tr>";
                                print "<td>". $item['competidor']->getDni()."</td>"; 
                                print "<td>". $item['competidor']->getNombre()."</td>"; 
                                if($item['detallesInscripcion']['sexoInscripcion']=="m"){
                                 print "<td>".$lang["Masculino"]."</td>";   
                                }else{
                                   print "<td>".$lang["Masculino"]."</td>";   
                                }
                                if($item['detallesInscripcion']['pesoInscripcion']==90){
                                            print "<td>>";
                                        }else{
                                            print "<td><";
                                        }
                                print  $item['detallesInscripcion']['pesoInscripcion'] . " Kg</td>";
                                print "<td>". $item['competidor']->getCatedad()."</td>"; 
                                print "<td>". $item['detallesInscripcion']['modalidad']."</td>"; 
                            print "</tr>";
                        }
                        
                        ?>
                    </tbody>
                </table>
                </div>    
                </div>   
            </section>
           

            <script src="../libreria/jquery-3.2.1.min.js" type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.js" type="text/javascript"></script>
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
                {"searchable": false, "orderable": false, "targets": [] } // Ajusta los índices según las columnas que quieras hacer no ordenables
            ]
        });
    });
</script>
        </body>
    </html>
    <?php
} else{
    header("Location: ../index.php");
}