<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    
    <title>BasketApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="views/assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="views/assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

    <?php require("views/template/headerAdm.php") ?>

    <main>
        <div class="body-text">
            <?php
    
                require_once('controllers/TorneosController.php');
                require_once("Controllers/UsuarioController.php");

                $objTorneosControllador = new torneosController();
                $torneos = $objTorneosControllador->selectAllTorneos();

                $objUsuariosControllador = new UsuarioController();
                $lstMaxAnotacion = $objUsuariosControllador->selectAllMaxAnotacion();

            ?>
            <h1 class="">   Lista de Torneos</h1>
            <p class="text-desert"><b>Lista de Torneos</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">

            </div>


            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-5 m-2 text-justify">
                <?php foreach ($torneos as $torneo): ?>
                <div class="col">
                    <a href="views/template/usuario/infoUsuario.php?idTorneo=<?= $torneo['idTorneo']?>" class="text-decoration-none">
                        <center>
                            <div class="text-decoration-none text-reset">
                                <div class="card h-100 shadow border-0 elevate-card rounded-top" id="elevating-card1">
                                    <div class="card-header border-0" style="background-image: url('views/assets/image/<?= $torneo['vImagenTorneo']?>');height: 300px; background-size: cover;"></div>
                                    <div class="card-body">
                                        <h5 class="card-title text-desert"><?= $torneo['vNombreTorneo'] ?></h5>
                                        <div class="text-barron"><b>Organizador: </b><?= $torneo['vNombreOrganizador'] ?></div>
                                        <span class="badge bg-desert text-white">Sede <?= $torneo['vSedeTorneo']; ?></span>
                                        <div class="py-3"><h5 class="text-desert">Premios</h5>
                                            <i class="text-barron"> </i>
                                            <span class="badge bg-terracota text-white px-4 ">1° <?= $torneo['vPremio01']; ?></span>
                                            <span class="badge bg-barron text-white px-4 mx-2">2° <?= $torneo['vPremio02']; ?></span>
                                            <span class="badge bg-desert text-white px-4">3° <?= $torneo['vPremio03']; ?></span>
                                        </div>
                                        <h5 class="text-desert">Otros Premios</h5>
                                            <span class="badge bg-miel text-white px-4">4° <?= $torneo['vOtroPremio']; ?></span> 
                                    </div>
                                    <div class="card-footer border-0">
                                    </div>
                                </div>
                            </div>
                        </center>
                    </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="table-responsive py-5">
                <h1 class="">Lista de Anotadores Por Partido</h1>
                <p class="text-desert"><b>Lista de Partidos</b></p>
                <div class="horizontal-line"></div>
                <table class="table text-center">
                    <thead>
                        <!-- <th class="text-start"> <span class="badge bg-barron text-white"># </span></th> -->
                        <th class="text-start"> <span class="badge bg-barron text-white">Fecha </span></th>
                        <th> <span class="badge bg-barron text-white">Nombre Equipo  </span></th>
                        <th> <span class="badge bg-barron text-white">Jugador con mayor Puntuntos </span></th>
                        <th> <span class="badge bg-barron text-white">Puntos del Jugador </span></th>
                        <th> <span class="badge bg-barron text-white">Nombre Equipo  </span></th>
                        <th> <span class="badge bg-barron text-white">Jugador con Mayor Puntuntos </span></th>
                        <th> <span class="badge bg-barron text-white">Puntos del Jugador </span></th>

                    </thead>
                    <?php foreach ($lstMaxAnotacion as $MaxAnotacion): ?>
                    <tbody>
                        <tr>
           
                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-start">
                                <?= $MaxAnotacion['vFecha']; ?>     
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $MaxAnotacion['NombreEqLocal']; ?>     
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $MaxAnotacion['NombreJugadorMaxAnotadorLocal']; ?>          
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $MaxAnotacion['MaxAnotadorLocal']; ?>         
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $MaxAnotacion['NombreEqVisitante']; ?>         
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $MaxAnotacion['NombreJugadorMaxAnotadorVisitante']; ?>              
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $MaxAnotacion['MaxAnotadorVisitante']; ?>         
                            </td>
                                
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </main>

    <?php require("views/template/footer.php") ?>