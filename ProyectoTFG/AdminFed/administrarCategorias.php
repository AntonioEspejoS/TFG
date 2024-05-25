<?php
//Vista de las categorías de un torneo
session_start();
include '../idioma/idioma.php';
// Verifica si hay una sesión de administrador de federación activa
if (isset($_SESSION["adminFed"])) {
    include_once '../Modelo/ModeloBD.php';
    include_once '../Modelo/ModeloCategoria.php';
    $idTorneo = $_GET['idtorneo'];
    $modeloCategoria = new ModeloCategoria();
    $categorias=$modeloCategoria->obtenerCategoriasPorTorneo($idTorneo);
    ?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="../CSS/principal.css" rel="stylesheet" type="text/css"/>
        <link href="../libreria/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <title><?php echo $lang["AdminCategorias"]?></title>
        <link rel="icon" type="image/x-icon" href="/ProyectoTFG/img/iconoRing.ico">        
    </head>
        <body>
        <?php include '../header.php'; ?>
        <?php include '../menus/menuAdminFed.php'; ?>
            <section>
                <div class="container">
               <h2 class="textoCentrado"><?php echo $lang["Categorias"]?></h2>
               <div class="table-responsive">
                <table id="tablaCategorias" class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo $lang["Modalidad"]?></th>
                            <th><?php echo $lang["Edad"]?></th>
                            <th><?php echo $lang["Sexo"]?></th>
                            <th><?php echo $lang["Peso"]?></th>
                       
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($categorias as $categoria) {
                            print "<tr>";
                            print "<td>". $categoria->getModalidad() ."</td>"; 
                            print "<td>". $categoria->getEdad() ."</td>"; 
                            if($categoria->getSexo()=="m"){
                             print "<td>Masculino</td>";   
                            }else{
                               print "<td>Femenino</td>";   
                            }
                            if($categoria->getPeso()==90){
                                print "<td>>";
                            }else if($categoria->getPeso()==79 && $categoria->getSexo()=="f"){
                                print "<td>>";
                            }else{
                                print "<td><";
                            }
                            print $categoria->getPeso() . " Kg</td>";
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

        $('#tablaCategorias').DataTable({
            "language": {
                "url":urlIdioma
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