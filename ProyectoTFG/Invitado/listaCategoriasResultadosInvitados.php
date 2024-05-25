<?php
//Vista de la lista de categorías  de los resultados y enfrentamientos de los torneos para usuarios no registrados
session_start();
include '../idioma/idioma.php';

    include_once '../Modelo/ModeloCategoria.php';
    $modeloCategoria = new ModeloCategoria();
    $idTorneo=$_GET['idtorneo'];
    $categorias = $modeloCategoria->obtenerCategoriasPorTorneoConEnfrentamientos($idTorneo);
    
    
    // Extraer valores únicos para los selectores
    $modalidades = [];
    $edades = [];
    $sexos = [];
    $pesos = [];

    foreach ($categorias as $categoria) {
        $modalidades[$categoria->getModalidad()] = $categoria->getModalidad();
        $edades[$categoria->getEdad()] = $categoria->getEdad();
        if($categoria->getSexo()=="m"){
            $sexos[$categoria->getSexo()] = "Masculino";
        }else{
            $sexos[$categoria->getSexo()] = "Femenino";
        }
        if($categoria->getPeso()==90){
            $pesos[$categoria->getPeso()] = ">".$categoria->getPeso() . " kg";
        }else{
            $pesos[$categoria->getPeso()] = "<".$categoria->getPeso() . " kg";
        }
    }

    // Ordenar valores
    asort($modalidades);
    asort($edades);
    asort($pesos);
    
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $lang["CategoriasResultados"]?></title>
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
            <?php    
            if (empty($categorias)) {
                print "<h2 class='textoCentrado'>No hay resultados para este torneo</h2>";
            }else{
            ?>
                <h2 class="textoCentrado"><?php echo $lang["Resultados"]?></h2>
                <div class="filtros">
                    <select id="filtroModalidad">
                        <option value=""><?php echo $lang["TodasModalidades"]?></option>
                        <?php foreach ($modalidades as $modalidad){
                            print "<option value=". $modalidad .">".$modalidad."</option>";
                        } 
                        ?>
                    </select>
                    <select id="filtroEdad">
                        <option value=""><?php echo $lang["TodasCategoriasEdad"]?></option>
                        <?php foreach ($edades as $edad){
                            print "<option value=". $edad .">".$edad."</option>";
                        }
                        ?>
                    </select>
                    <select id="filtroSexo">
                        <option value=""><?php echo $lang["AmbosSexos"]?></option>
                        <?php foreach ($sexos as $key => $sexo){
                            if($sexo=="Masculino"){
                              print "<option value=". $key .">".$lang["Masculino"]."</option>";
                            }else{
                              print "<option value=". $key .">".$lang["Femenino"]."</option>";
                            }
                        }
                        ?>
                    </select>
                    <select id="filtroPeso">
                        <option value=""><?php echo $lang["TodosPesos"]?></option>
                        <?php foreach ($pesos as $peso => $texto){
                              print "<option value=". $peso .">".$texto."</option>";
                        }
                        ?>
                    </select>
                    <button  class='btn btn-primary' id="filtrarResultados"><?php echo $lang["Filtrar"]?></button>
                </div>
                <div class="table-responsive">
                 <table class="table table-striped" id="tablaResultados">
                    <thead>
                        <tr>
                            <th><?php echo $lang["Modalidad"]?></th>
                            <th><?php echo $lang["Edad"]?></th>
                            <th><?php echo $lang["Sexo"]?></th>
                            <th><?php echo $lang["Peso"]?></th>
                            <td><strong><?php echo $lang["EnfrentamientosYResultados"]?></strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($categorias as $categoria) {
                            print "<tr>";
                            print "<td>" . $categoria->getModalidad()  . "</td>";
                            print "<td>" . $categoria->getEdad() . "</td>";
                            if($categoria->getSexo()=="m" ){
                                print "<td>".$lang["Masculino"]."</td>";
                            }else{
                                print "<td>".$lang["Femenino"]."</td>";
                            }
                            if($categoria->getPeso()==90){
                                print "<td>>".$categoria->getPeso() . " kg</td>";
                            }else{
                                print "<td><".$categoria->getPeso() . " kg</td>";
                            }
                            print "<td><a href='listaResultadosInvitados.php?idtorneo=" . $idTorneo . "&peso=" . $categoria->getPeso() . "&sexo=" . $categoria->getSexo() . "&edad=" . $categoria->getEdad() . "&modalidad=" . $categoria->getModalidad() . "'><button type='button' name='resultados' class='btn btn-success'>".$lang["VerInformacion"]."</button></a></td>";
                            print "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>
                <?php
                }
                ?>
            </div>

        </body>
     <script src="../Scripts/filtrarCategoriasResultados.js" type="text/javascript"></script>
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
        $('#tablaResultados').DataTable({
            "language": {
                "url": urlIdioma
            },
            "columnDefs": [
                {"searchable": false, "orderable": false, "targets": [4] }
            ]
        });
    });
</script>
    </html>
