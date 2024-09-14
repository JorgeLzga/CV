<?php
    session_start();

    function isLoggedIn() {

        return isset($_SESSION['vUsuario']) || isset($_SESSION['vUsuarioOrganizador']);
    }

    $isAuthenticated = isLoggedIn();

    if ($isAuthenticated) {

        include_once(__DIR__ .'/../../controllers/TorneosController.php');

        if (isset($_SESSION['vUsuarioOrganizador'])) {

            $vUsuarioOrganizador = $_SESSION['vUsuarioOrganizador'];

            $objTorneosControllador = new torneosController();
            $torneos = $objTorneosControllador->mostrarTorneosDelOrganizador($vUsuarioOrganizador);

        } else {

        }
    }

?>

    <header class="">
        <nav class="navbar navbar-expand-lg navbar-dark p-3 shadow" aria-label="Eighth navbar example">
            <div class="container">
                <a class="navbar-brand text-terracota" href="/WebApp/index.php"><b>BasketApp</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsHeader" aria-controls="navbarsHeader" aria-expanded="        false" aria-label="Toggle navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                            <image href="/WebApp/views/assets/svg/iList.svg" width="24" height="24" />
                        </svg>
                </button>
                <div class="collapse navbar-collapse " id="navbarsHeader">
                    <?php if (!$isAuthenticated) : ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  
                    </ul>
                    <?php endif; ?>

                    <!-- AQUI ESTOY TRABAJANDO -->
                    <?php if ($isAuthenticated) : if (isset($_SESSION['vUsuario'])) : ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-terracota" href="#" data-bs-toggle="dropdown" aria-expanded="false">Panel de Control</a>
                            <ul class="dropdown-menu text-small">
                                <li><a class="dropdown-item" href="/webApp/views/template/panelControl.php">Ver Torneos</a></li>

                                <li><hr class="dropdown-divider"></li>    
                                <li><a class="dropdown-item" href="/WebApp/views/template/perfil/infoPerfil.php">Perfiles</a></li>           
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-terracota" href="#" data-bs-toggle="dropdown" aria-expanded="false">Patrocinadores</a>
                            <ul class="dropdown-menu text-small">
                                <li><a class="dropdown-item" href="/WebApp/views/template/patrocinador/lstPatrocinador.php">Ver Patrocinadores</a></li>
                                <li><a class="dropdown-item" href="/WebApp/views/template/patrocinador/frmPatrocinador.php">Agregar Patrocinador</a></li>       
                            </ul>
                        </li>
                    
                    </ul>
                    <?php endif;?>

                    <!-- AQUI PARA ARRIBA ESTOY TRABAJANDO -->

                    <?php if ($isAuthenticated && isset($_SESSION['vUsuarioOrganizador'])) : ?>
                                
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
  
                        <?php foreach ($torneos as $torneo) : ?>

                        <li class="nav-item">
                            <a class="nav-link text-terracota" 
                                href="/WebApp/views/template/torneo/infoTorneo.php?idTorneo=<?= $torneo['idTorneo'] ?>">Torneo</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-terracota" href="#" data-bs-toggle="dropdown" aria-expanded="false">Agregar</a>
                            <ul class="dropdown-menu text-small">
                                <li><a class="dropdown-item" href="/WebApp/views/template/grupo/frmGrupo.php?idTorneo=<?= $torneo['idTorneo']?>">Agregar Grupo</a></li>
                                <li><a class="dropdown-item" href="#">Agregar Equipo</a></li>
                            </ul>
                        </li>
                        <?php endforeach; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-terracota" href="#" data-bs-toggle="dropdown" aria-expanded="false">Calendario</a>
                            <ul class="dropdown-menu text-small">
                                <li><a class="dropdown-item" href="/WebApp/views/template/calendario/infoCalendario.php?idTorneo=<?= $torneo['idTorneo'] ?>">Ver Calendario</a></li>
                                <li><a class="dropdown-item" href="/WebApp/views/template/calendario/frmCalendario.php?idTorneo=<?= $torneo['idTorneo'] ?>">Agregar Calendario</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-terracota" href="#" data-bs-toggle="dropdown" aria-expanded="false">Estadisticas</a>
                            <ul class="dropdown-menu text-small">
                                <li><a class="dropdown-item" href="/WebApp/views/template/estEquipo/lstEstEquipo.php?idTorneo=<?= $torneo['idTorneo']?>">Equipos</a></li>
                                <li><a class="dropdown-item" href="/WebApp/views/template/estJugador/lstEstJugador.php?idTorneo=<?= $torneo['idTorneo']?>">Jugadores</a></li>
                            </ul>
                        </li>

                    </ul>
                    <?php endif; endif; ?>

                    <center> 
                       <div class="nav-item dropdown navbar-nav me-auto mb-2 mb-lg-0">
                            <a href="/WebApp/views/template/login/login.php" class="nav-link dropdown-toggle text-terracota" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                                    <image href="/WebApp/views/assets/svg/iLogin.svg" width="32" height="32" />
                                </svg>
                            </a>    
                            <ul class="dropdown-menu text-small">
                                <?php if ($isAuthenticated) : ?>
                                    <li><a class="dropdown-item text-terracota" href="/WebApp/views/template/login/logout.php"><i class="fa-solid fa-right-from-bracket text-terracota"></i> Cerrar Sesión</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item text-terracota" href="/WebApp/views/template/login/login.php"><i class="fa-solid fa-user-plus text-terracota"></i> Iniciar Sesión</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </center>
                </div>
            </div>
        </nav>
    </header>
    
    <body>
