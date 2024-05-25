<!-- Menu del usuario no registrado-->
<nav class="navbar navbar-expand-lg navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">    
        <ul class="navbar-nav">
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/Admin/administrarAdminFed.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="/ProyectoTFG/index.php"><img id="iconos" src="/ProyectoTFG/img/guantes-de-boxeo.png" alt=""/><?php echo $lang["Inicio"]?></a>
            </li>
            </ul> 
        <ul class="navbar-nav" >
            <li class="nav-item <?php echo ($_SERVER['REQUEST_URI'] == "/ProyectoTFG/Invitado/listaTorneosResultadosInvitados.php") ? 'active' : ''; ?>">
                <a class="nav-link" href="../Invitado/listaTorneosResultadosInvitados.php"><img id="iconos" src="/ProyectoTFG/img/podio.png" alt=""/><?php echo $lang["Torneos"]?></a>
            </li>
        </ul>
    </div>
</nav>
