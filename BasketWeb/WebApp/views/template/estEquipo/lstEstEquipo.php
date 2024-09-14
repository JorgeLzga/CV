<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title> Listado de las Estadisticas de los Jugadores </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>
</head>

<?php
    require("../../template/header.php")  
?>

<main>
    <div class="body-text">
        <?php
            include_once('../../../controllers/EstEquipoController.php');
            include_once('../../../controllers/TorneosController.php');

            $idTorneo = $_GET['idTorneo'];


            $objTorneosControllador = new torneosController();
            $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);


            $objEstEqControllador = new estEquipoController();
            $lstEstEquipo = $objEstEqControllador->selectAllEstEquipo($idTorneo);
        ?>

        <h1 class=""> Estadisticas: </h1>
        <p class="text-desert"> <b> Estadisticas de los Equipos </b> </p>
        <div class="horizontal-line"> </div>

        <div class="d-flex flex-column flex-sm-row">
            <a href="../torneo/infoTorneo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"> <i class="fa-solid fa-angle-left"> </i> Regresar al Torneo</a>

        </div>

        <div class="table-responsive py-4">
            <table class="table text-center">
                <thead>
                    <th style="color:#A62F14 !important" class="text-start"> Nombre Equipo </th>
                    <th style="color:#A62F14 !important"> Partidos </th>
                    <th style="color:#A62F14 !important"> Ganados </th>
                    <th style="color:#A62F14 !important"> Perdidos </th>
                    <th style="color:#A62F14 !important"> Puntos a Favor </th>
                    <th style="color:#A62F14 !important"> Puntos en Contra </th>
                    <th style="color:#A62F14 !important"> Diferencia de Puntos </th>
                    <th style="color:#A62F14 !important"> Puntaje </th>

                </thead>
                <?php foreach ($lstEstEquipo as $EstEquipo): ?>
                <tbody>
                    <tr>
                        <td style="vertical-align: middle;" class="text-start">
                            <?= $EstEquipo['vNombreEquipo']; ?>
                        </td>

                        <td style="vertical-align: middle;">
                            <?= $EstEquipo['VecesJugo']; ?>     
                        </td>

                        <td style="vertical-align: middle;">
                            <?= $EstEquipo['VecesGanadas']; ?>     
                        </td>

                        <td style="vertical-align: middle;">
                            <?= $EstEquipo['VecesPerdidas']; ?>          
                        </td>

                        <td style="vertical-align: middle;">
                            <?= $EstEquipo['PuntosAFavor']; ?>         
                        </td>

                        <td style="vertical-align: middle;">
                            <?= $EstEquipo['PuntosEnContra']; ?>         
                        </td>

                        <td style="vertical-align: middle;">
                            <?= $EstEquipo['DiferenciaDePuntos']; ?>              
                        </td>

                        <td style="vertical-align: middle;">
                            <?= $EstEquipo['Puntos']; ?>         
                        </td>
                            
                    </tr>
                </tbody>
                <?php endforeach; ?>

            </table>
        </div>
    </div>
</main>

<?php
    require("../../template/footer.php")
?>