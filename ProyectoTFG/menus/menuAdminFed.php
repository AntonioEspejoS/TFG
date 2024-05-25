<?php
//Menu del administrador de la federación
 if (isset($_SESSION["adminFed"]) ) {
     include_once '../Modelo/ModeloArbitro.php';
     include_once '../Modelo/ModeloCoach.php';
     include_once '../Modelo/ModeloCompetidor.php';
     
     //Obtener cantidad de usuarios sin estar verificados para mostrarlo en el menú
    $modeloArbitro = new ModeloArbitro();
    $modeloCoach = new ModeloCoach();
    $modeloCompetidor = new ModeloCompetidor();
//Arbitros
     $arbitros=$modeloArbitro->obtenerArbitros();
     $arbitrosNoVerificados = [];
        foreach ($arbitros as $arbitro) {
            if ($arbitro->getEstado() == 0) {
                $arbitrosNoVerificados[] = $arbitro;
            }
        }
    $numeroArbitrosNoVerificados= count($arbitrosNoVerificados);
//Coachs
     $coaches=$modeloCoach->obtenerCoaches();
     $coachesNoVerificados = [];
        foreach ($coaches as $coach) {
            if ($coach->getEstado() == 0) {
                $coachesNoVerificados[] = $coach;
            }
        }
    $numeroCoachesNoVerificados= count($coachesNoVerificados);    
    
//Competidores   
     $competidores=$modeloCompetidor->obtenerCompetidores();
     $competidoresNoVerificados = [];
        foreach ($competidores as $competidor) {
            if ($competidor->getEstado() == 2 || $competidor->getEstado() == 0) {
                $competidoresNoVerificados[] = $competidor;
            }
        }
    $numeroCompetidoresNoVerificados= count($competidoresNoVerificados);
   
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/AdminFed/administrarArbitros.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="/ProyectoTFG/AdminFed/administrarArbitros.php"><img id="iconos" src="/ProyectoTFG/img/arbitro.png" alt=""/><?php echo $lang["Arbitros"]?>
                <?php if ($numeroArbitrosNoVerificados > 0): ?>
                        <span class="badge badge-warning"><?php echo $numeroArbitrosNoVerificados ?></span>
                <?php endif; ?>
                </a>
            </li>
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/AdminFed/administrarClubes.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="/ProyectoTFG/AdminFed/administrarClubes.php"><img id="iconos" src="/ProyectoTFG/img/yin-yang.png" alt=""/>Clubes</a>
            </li>
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/AdminFed/administrarCoach.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="/ProyectoTFG/AdminFed/administrarCoach.php"><img id="iconos" src="/ProyectoTFG/img/puno.png" alt=""/>Coaches
                <?php if ($numeroCoachesNoVerificados > 0): ?>
                        <span class="badge badge-warning"><?php echo $numeroCoachesNoVerificados ?></span>
                <?php endif; ?></a>
            </li>
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/AdminFed/administrarCompetidores.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="/ProyectoTFG/AdminFed/administrarCompetidores.php"><img id="iconos" src="/ProyectoTFG/img/artes-marciales.png" alt=""/><?php echo $lang["Competidores"]?>
                <?php if ($numeroCompetidoresNoVerificados > 0): ?>
                        <span class="badge badge-warning"><?php echo $numeroCompetidoresNoVerificados ?></span>
                <?php endif; ?></a>
            </li>
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/AdminFed/administrarTorneos.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="/ProyectoTFG/AdminFed/administrarTorneos.php"><img id="iconos" src="/ProyectoTFG/img/karate.png" alt=""/><?php echo $lang["Torneos"]?></a>
            </li>
            </ul> 
            <ul class="navbar-nav ml-auto" >
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/perfiles/perfilAdminFed.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="../perfiles/perfilAdminFed.php"><img id="iconos" src="/ProyectoTFG/img/avatar.png" alt=""/><?php echo $lang["MiPerfil"]?></a>
            </li>
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/sesiones/cerrarSesion.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="../sesiones/cerrarSesion.php"><img id="iconos" src="/ProyectoTFG/img/salida.png" alt=""/><?php echo $lang["Salir"]?></a>
            </li>
        </ul>
    </div>
</nav>
  <?php   
 } else {
    header("Location: ../index.php");
} 