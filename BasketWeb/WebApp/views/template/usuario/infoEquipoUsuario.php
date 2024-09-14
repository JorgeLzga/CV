<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Informacion Equipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

    <?php require("../../template/header.php") ?>
    <main>
        <div class="body-text">
            <?php
                require_once("../../../controllers/TorneosController.php");
                require_once("../../../Controllers/EquiposController.php");
                require_once("../../../Controllers/JugadoresController.php");
                require_once("../../../Controllers/UsuarioController.php");


                $idTorneo = $_GET['idTorneo']; 
                $idEquipo = $_GET['idEquipo']; 


                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

                $objUsuariosControllador = new UsuarioController();
                $lstUsuarioEquipo = $objUsuariosControllador->selectOneUsuarioEquipoComplete($idTorneo,$idEquipo);
                $lstUsuarioEquipoSt = $objUsuariosControllador->selectAllEstEquipoUsuario($idTorneo,$idEquipo);
                $lstEstJugadorUsuario = $objUsuariosControllador->selectAllEstJugadorUsuario($idTorneo, $idEquipo);

            ?>

            <h1 class="">Informacion del Equipo</h1>
            <p class="text-desert"><b>Informacion Equipos</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">

                <a href="infoUsuario.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Ver Stading</a>
            </div>

            <div class="row row-cols-1 row-cols-md g-4 m-4 justify-content-center">
                <div>
                    <center>
                        <div class="text-decoration-none text-reset">
                            <div class="card h-100 shadow border-0 elevate-card rounded-top" id="elevating-card1">
                                <div class="card-header border-0" style="background-image: url('../../assets/imgEquipo/<?= $lstUsuarioEquipo['vImgEquipo']?>'); height: 400px; background-size: cover; background-position: center;">
                                </div>

                                <div class="card-body" style="padding: 15px 35px 15px 35px;">
                                    <h2 class="card-title text-desert"><b><?= $lstUsuarioEquipo['vNombreEquipo']?></b></h2>
                                    <p><div class="horizontal-line-card"></div></p>
                                    <div class="text-barron" style="font-size: 20px;"><b>Capitan </b><?= $lstUsuarioEquipo['vNombreCapitan']?></div>

                                    <div class="text-barron" style="font-size: 20px;">
                                            <b>Correo: </b><?= $lstUsuarioEquipo['vCorreoCapitan']?><br>
                                            <b>Celular: </b><?= $lstUsuarioEquipo['vCelularCapitan']?>
                                    </div>
                                    <h5  class="text-barron py-3"><b>Lista de Jugadores del Equipo</b></h5>

                                    <h2 class="text-desert py-2"> Stading del Equipo</h2>
                                    <div class="horizontal-line-card"></div>

                                    <div class="table-responsive py-4">
                                        <table class="table text-center">
                                            <thead>
                                                <th class="text-start"> <span class="badge bg-barron text-white">Nombre Equipo </span></th>
                                                <th> <span class="badge bg-barron text-white">Partidos </span></th>
                                                <th> <span class="badge bg-barron text-white">Ganados </span></th>
                                                <th> <span class="badge bg-barron text-white">Perdidos </span></th>
                                                <th> <span class="badge bg-barron text-white">Puntos a Favor </span></th>
                                                <th> <span class="badge bg-barron text-white">Puntos en Contra </span></th>
                                                <th> <span class="badge bg-barron text-white">Diferencia de Puntos </span></th>
                                                <th> <span class="badge bg-barron text-white">Puntaje </span></th>

                                            </thead>
                                            <?php foreach ($lstUsuarioEquipoSt as $EstEquipo): ?>
                                            <tbody>
                                                <tr>
                                                    <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-start">        
                                                        <b class="text-decoration-none text-barron"><?= $EstEquipo['vNombreEquipo']; ?></b>
                                                    </td>

                                                    <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                                        <?= $EstEquipo['VecesJugo']; ?>     
                                                    </td>

                                                    <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                                        <?= $EstEquipo['VecesGanadas']; ?>     
                                                    </td>

                                                    <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                                        <?= $EstEquipo['VecesPerdidas']; ?>          
                                                    </td>

                                                    <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                                        <?= $EstEquipo['PuntosAFavor']; ?>         
                                                    </td>

                                                    <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                                        <?= $EstEquipo['PuntosEnContra']; ?>         
                                                    </td>

                                                    <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                                        <?= $EstEquipo['DiferenciaDePuntos']; ?>              
                                                    </td>

                                                    <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                                        <?= $EstEquipo['Puntos']; ?>         
                                                    </td>
                                                        
                                                </tr>
                                            </tbody>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-5 m-3 justify-content-center">
                <?php foreach ($lstEstJugadorUsuario as $EstJugador): ?>
                <div class="col">
                    <center>
                        <div class="text-decoration-none text-reset">
                            <div class="card h-100 shadow border-0 elevate-card rounded-top" id="elevating-card1">
                         
                                <div class="border-0 card-img-top">
                                    <img src="../../assets/imgJugador/<?= $EstJugador['vImgJugador']?>" class="card-img img-fluid custom-img">
                                </div>
                                
                                <div class="card-body">
                                    <div class="text-desert">
                                        <h5><?= $EstJugador['vNombreJugador']. ' ' . $EstJugador['vApellidoJugador']?></h5>
                                        <b class="text-barron"><?= $EstJugador['vNombreEquipo']?></b> <br>
                                   
                                    <p><div class="horizontal-line-card"></div></p>

                                    <h6 class="text-desert"><b>Estadisticas del Torneo</b></h6>
                                    <div class="text-barron">
                                        <b>Puntos Total:</b> <?= $EstJugador['TotalPuntos']?><br>
                                        <b>Tiros de 3:</b> <?= $EstJugador['TotalTirosde3']?><br>
                                        <b>Faltas:</b> <?= $EstJugador['TotalFaltas']?><br>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer border-0"></div>
                            </div>
                        </div>
                    </center>
                </div>
                
                <?php endforeach;?>
            </div> 
        </div>
    </main>
    <?php require("../../template/footer.php")?>