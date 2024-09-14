
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    
    <title>BasketApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

	<?php 
        require("../header.php");
        require_once("../../../controllers/TorneosController.php");

        $objTorneosControllador = new torneosController();
        $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

        $lstTorneoPatrocinador = $objTorneosControllador->selectOneTorneoComplete($_GET['idTorneo']);

    ?>
    <main>
        <div class="body-text">
            <h1 class="">Informacion del Torneo</h1>
            <p class="text-desert"><b>Datos del Torneo</b></p>
            <div class="horizontal-line"></div>

            <div class="d-flex flex-column flex-sm-row">
                <?php if (isset($_SESSION['idRol']) && $_SESSION['idRol'] != '2') { ?>
                <a href="../panelControl.php" class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar al Panel</a>
                <?php } ?>
                <a href="../grupo/frmGrupo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-basketball"></i> Añadir Grupo</a>

                <a href="../grupo/lstGrupo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-barron mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-user-group"></i> Ver Grupos</a>

                <a href="../calendario/infoCalendario.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-calendar-days"></i> Ver Calendario</a>

                <a href="../estJugador/lstEstJugador.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-rubio mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-chart-simple"></i> Estadisticas Jugador</a>

                <a href="../estEquipo/lstEstEquipo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-miel mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-chart-line"></i> Estadisticas Equipo</a>
            </div>

            <div class="row justify-content-center g-5 m-2">
                <div class="col-md-4">
                    <div class="card mb-3 border-0 h-100">
                        <center>
                            <div class="text-decoration-none text-reset">
                                <div class="card h-100 shadow border-0 elevate-card rounded-top">
                                    <div class="card-header border-0" style="background-image: url('../../assets/image/<?= $lstTorneo['vImagenTorneo']?>');height: 302px; background-size: cover;"></div>
                                    <div class="card-body">
                                        <div class="horizontal-line-card"></div>
                                    </div>
                                    <div class="card-footer border-0">
                            
                                    </div>
                                </div>
                            </div>
                        </center>                    
                    </div>
                </div>
              
                <div class="col-md-8">
                    <div class="card mb-3 border-0 h-100">
                        <div class="text-decoration-none text-reset">
                            <div class="card h-100 shadow border-0 elevate-card rounded-top">
                                <div class="border-0"></div>
                                <div class="card-body" style="padding: 15px 35px 15px 35px;">
                                    <div>
                                        <h2 class="card-title text-barron"><?= $lstTorneo['vNombreTorneo'] ?></h2>
                                        <span class="badge bg-desert text-white"><?= $lstTorneo['vSedeTorneo']; ?></span><br><br>
                                        
                                        <div class="text-barron"><b class="text-desert">Organizador:</b> <?= $lstTorneo['vNombreOrganizador'] ?></div>
                                        
                                        <div class="py-3"><b class="text-desert">Premios:</b>
                                            <i class="text-barron"> (Primer Lugar, Segundo Lugar, Tercer Lugar)</i><br>
                                            <span class="badge bg-terracota text-white px-4 ">1° <?= $lstTorneo['vPremio01']; ?></span>
                                            <span class="badge bg-barron text-white px-4 mx-2">2° <?= $lstTorneo['vPremio02']; ?></span>
                                            <span class="badge bg-desert text-white px-4">3° <?= $lstTorneo['vPremio03']; ?></span>
                                        </div> 
                                        <div>
                                            <b class="text-desert">Otros Premios:</b><br>
                                            <span class="badge bg-miel text-white px-4">4° <?= $lstTorneo['vOtroPremio']; ?></span>
                                        </div>
                                        <br>
                                        <div class="">
                                            <b class="text-desert">Usuario: </b><br>
                                            <div class="text-barron"><i><?= $lstTorneo['vUsuarioOrganizador']; ?></i></div>
                                        </div>
                                    </div>         
                                </div>

                                <div class="card-footer border-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-5 m-2 justify-content-center">
                <?php foreach ($lstTorneoPatrocinador as $imgPatrocinador): ?>
                    <div class="col">
                        <div class="card border-0 h-100">
                            <center>
                                <div class="text-decoration-none text-reset">
                                    <div class="card h-100 shadow border-0 elevate-card rounded-top">
                                        <div class="card-header border-0" 
                                             style="background-image: url('../../assets/imgPatrocinador/<?= $imgPatrocinador['vImgPatrocinador'] ?>'); 
                                                    height: 300px; 
                                                    background-size: 100% 100%;
                                                    background-position: center;">
                                        </div>

                                        <div class="card-body"><span class="badge bg-barron"> </span> <h4><?= $imgPatrocinador['vNombrePatrocinador']?></h4></div>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php require("../footer.php") ?>