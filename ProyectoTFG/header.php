<header>
    <div class="row" id="cabecera">
        <div class="col-md-2 col-sm-3 col-xs-3"></div>
        <div class="col-md-8 col-sm-6 col-xs-6" id="logo">
            <?php
            //Cambio en la ruta del logo según la esión iniciada
            $logoUrl = "/ProyectoTFG/index.php";
            if (isset($_SESSION["admin"])) {
                $logoUrl = "/ProyectoTFG/perfiles/perfilAdmin.php";
            } else if (isset($_SESSION["adminFed"])) {
                $logoUrl = "/ProyectoTFG/perfiles/perfilAdminFed.php";
            } else if (isset($_SESSION["arbitro"])) {
                $logoUrl = "/ProyectoTFG/perfiles/perfilArbitro.php";
            } else if (isset($_SESSION["coach"])) {
                $logoUrl = "/ProyectoTFG/listados/listaMiClub.php";
            } else if (isset($_SESSION["competidor"])) {
                $logoUrl = "/ProyectoTFG/listados/listaMiClub.php";
            }
            ?>
            <a href="<?php echo $logoUrl; ?>">
                <img src="/ProyectoTFG/img/NOMBRERecortado.png" class="img-fluid"/>
            </a>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-3">
            <div id="banderas">
                <?php
                //Compruebo si estamos en index ya que las rutas son distintas porque está en la raiz
                if(basename($_SERVER['PHP_SELF']) == "index.php"){
                    $rutaImagenes="img/";
                }else{
                    $rutaImagenes="../img/"; 
                }     
                //Url para el idioma
                $esUrl = '?' . http_build_query(array_merge($parametros, ['idioma' => 'es']));
                $inUrl = '?' . http_build_query(array_merge($parametros, ['idioma' => 'in']));
                ?>
                <a href="<?php echo $esUrl; ?>"><img src="<?php echo $rutaImagenes; ?>espana.png" class="bandera" alt="Español"></a>
                <a href="<?php echo $inUrl; ?>"><img src="<?php echo $rutaImagenes; ?>reino-unido.png" class="bandera" alt="Inglés"></a>
            </div>
        </div>
    </div>
</header>