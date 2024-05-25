<?php
//Menu del arbitro
 if (isset($_SESSION["arbitro"]) ) {
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/listados/listaTorneosResultados.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="../listados/listaTorneosResultados.php"><img id="iconos" src="/ProyectoTFG/img/podio.png" alt=""/><?php echo $lang["EnfrentamientosYResultados"]?></a>
            </li>
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/listados/listaTorneos.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="../listados/listaTorneos.php"><img id="iconos" src="/ProyectoTFG/img/karate.png" alt=""/><?php echo $lang["GestionarTorneos"]?></a>
            </li>
            </ul> 
            <ul class="navbar-nav ml-auto" >
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/perfiles/perfilArbitro.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="../perfiles/perfilArbitro.php"><img id="iconos" src="/ProyectoTFG/img/avatar.png" alt=""/><?php echo $lang["MiPerfil"]?></a>
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