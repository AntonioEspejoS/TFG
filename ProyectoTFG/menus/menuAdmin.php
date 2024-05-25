<?php
//Menu del administrador del sistema
 if (isset($_SESSION["admin"]) ) {
     include_once '../Modelo/ModeloAdminFed.php';
      //Obtener cantidad de administradores de la federación sin estar verificados para mostrarlo en el menú

     $modeloAdminFed = new ModeloAdminFed();
     $administradores=$modeloAdminFed->obtenerAdminsFed();
     $adminFedNoVerificados = [];
        foreach ($administradores as $admin) {
            if ($admin->getEstado() == 0) {
                $adminFedNoVerificados[] = $admin;
            }
        }
    $numeroAdminNoVerificados= count($adminFedNoVerificados);
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">        <ul class="navbar-nav">
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/Admin/administrarAdminFed.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="/ProyectoTFG/Admin/administrarAdminFed.php"><img id="iconos" src="/ProyectoTFG/img/administrador.png" alt=""/><?php echo $lang["AdminsFed"]?>
                <?php if ($numeroAdminNoVerificados > 0): ?>
                        <span class="badge badge-warning"><?php echo $numeroAdminNoVerificados ?></span>
                <?php endif; ?>
                </a>
            </li>
            </ul> 
            <ul class="navbar-nav ml-auto" >
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/perfiles/perfilAdminFed.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="../perfiles/perfilAdmin.php"><img id="iconos" src="/ProyectoTFG/img/avatar.png" alt=""/><?php echo $lang["MiPerfil"]?></a>
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