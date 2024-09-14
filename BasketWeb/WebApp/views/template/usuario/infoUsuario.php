<?php date_default_timezone_set('America/Mazatlan'); ?>
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
                include_once('../../../controllers/CalendarioController.php');
                require_once("../../../controllers/GruposController.php");

                $idTorneo = $_GET['idTorneo'];

                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

                $objCalendarioModel = new CalendarioController();
                $calendarioTodo = $objCalendarioModel->selectOneCalendario($idTorneo,);
                
                $objGruposControllador = new gruposController();
                $lstGrupo = $objGruposControllador->selectOneGrupoComplete($_GET['idTorneo']);
            ?>

            <h1 class=""> Stading General </h1>
            <p class="text-desert"> <b> Estadisticas de los Equipos </b> </p>
            <div class="horizontal-line"> </div>

            <div class="d-flex flex-column flex-sm-row">
                <a href="../../../index.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar al Inicio
                </a>
            
                <a href="pdfRol.php?idTorneo=<?= $lstTorneo['idTorneo']?>" target="_blank" 
                    class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-print"></i> Imprimir Partidos
                </a>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <form action="lstCalendarioUsuario.php" method="GET">
                        <input type="hidden" name="idTorneo" value="<?= $lstTorneo['idTorneo'] ?>" />
                        <select class="form-select" name="vFecha" value="asd"onchange="this.form.submit()">
                            <option value="<?= date('Y-m-d') ?>" readonly>Fecha De Hoy: <?= date('Y-m-d') ?></option>
                            <?php 
                                $fecha_actual = date('Y-m-d');
                                $hay_partido_hoy = false;

                                foreach ($calendarioTodo as $partido):
                                    $fecha_partido = new DateTime($partido['vFecha']);
                                    $fecha_partido->setTimezone(new DateTimeZone('America/Mazatlan'));
                                    $fecha_partido = $fecha_partido->format('Y-m-d');

                                    if ($fecha_partido === $fecha_actual) {
                                        $hay_partido_hoy = true;
                                        ?>
                                        <option value="<?= $fecha_actual ?>">
                                            Ver Partido de Hoy
                                        </option>
                                        <?php
                                        break;
                                    }
                                endforeach;

                                $fecha_anterior = null;
                                $contador_partidos = 0;

                                foreach ($calendarioTodo as $partido):
                                    $fecha_partido = new DateTime($partido['vFecha']);
                                    $fecha_partido->setTimezone(new DateTimeZone('America/Mazatlan'));
                                    $fecha_partido = $fecha_partido->format('Y-m-d');

                                    if ($fecha_anterior !== $fecha_partido):
                                        if ($fecha_anterior !== null): 
                            ?>
                            <option value="<?= $fecha_anterior ?>">
                                Fecha: <?= $fecha_anterior ?> - Partidos: <?= $contador_partidos ?>
                            </option>
                            <?php
                                        endif;
                                        $contador_partidos = 0;
                                    endif;

                                    $fecha_anterior = $fecha_partido;
                                    $contador_partidos++;
                                endforeach;

                                if ($fecha_anterior !== null):
                            ?>
                            <option value="<?= $fecha_anterior ?>">
                                Fecha: <?= $fecha_anterior ?> - Partidos: <?= $contador_partidos ?>
                            </option>
                            <?php endif; ?>

                            <?php if (!$hay_partido_hoy) : ?>
                            <option value="<?= $fecha_actual ?>">
                                Fecha actual: No hay partidos hoy
                            </option>
                            <?php endif; ?>
                        </select>
                    </form>
                </div>
            </div>

            <div class="table-responsive py-4">
            
            <?php

                function consumirAPIConsultaOne($idTorneo){return json_decode(file_get_contents('http://localhost/WebApp/API/stadingOne.php?idTorneo='.$idTorneo.''));}
                    $StadingTorneo = consumirAPIConsultaOne($idTorneo);
            ?>

                <table class="table text-center">
                    <thead>
                        <th class="text-start"><span class="badge bg-barron text-white"> Nombre Equipo </span></th>
                        <th> <span class="badge bg-barron text-white">Partidos </span></th>
                        <th> <span class="badge bg-barron text-white">Ganados </span></th>
                        <th> <span class="badge bg-barron text-white">Perdidos </span></th>
                        <th> <span class="badge bg-barron text-white">Puntos a Favor </span></th>
                        <th> <span class="badge bg-barron text-white">Puntos en Contra </span></th>
                        <th> <span class="badge bg-barron text-white">Diferencia de Puntos </span></th>
                        <th> <span class="badge bg-barron text-white">Puntaje </span></th>

                    </thead>
                   <?php foreach ($StadingTorneo as $EstEquipo): ?>
                        <tbody>
                            <tr>
                                <td style="vertical-align: middle;" class="border-0 text-start">
                                    <a href="infoEquipoUsuario.php?idTorneo=<?= $lstTorneo['idTorneo']?>&idEquipo=<?= $EstEquipo->idEquipo; ?>" class="text-decoration-none text-barron">
                                        <b><?= $EstEquipo->vNombreEquipo; ?></b>
                                    </a>
                                </td>
                                <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                    <?= $EstEquipo->VecesJugo; ?>
                                </td>
                                <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                    <?= $EstEquipo->VecesGanadas; ?>
                                </td>
                                <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                    <?= $EstEquipo->VecesPerdidas; ?>
                                </td>
                                <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                    <?= $EstEquipo->PuntosAFavor; ?>
                                </td>
                                <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                    <?= $EstEquipo->PuntosEnContra; ?>
                                </td>
                                <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                    <?= $EstEquipo->DiferenciaDePuntos; ?>
                                </td>
                                <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                    <?= $EstEquipo->Puntos; ?>
                                </td>
                            </tr>
                        </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
            
            <div class="row row-cols-1 row-cols-md-4 g-4 m-2 justify-content-center">
                <?php foreach ($lstGrupo as $grupo): ?>
                <a class="text-decoration-none" href="infoGrupoUsuario.php?idTorneo=<?= $grupo['idTorneo'] ?>&idGrupo=<?= $grupo['idGrupo'] ?>">
                    <div class="col mb-3">
                        <div class="text-decoration-none">
                            <div class="card border-0 h-100">
                                <center>
                                    <div class="text-decoration-none text-reset">
                                        <div class="card h-100 shadow border-0 elevate-card rounded-top">
                                            <div class="card-body text-desert">
                                                <div class="text-terracota text-start">
                                                    <!-- <h6><?= $grupo['vNombreGrupo']?></i></h6> -->
                                                    <h1><?= $grupo['vNombreGrupo']?></h1>
                                                    <p class="text-desert"><?= $grupo['vCategoria']?></p>
                                                </div>       
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </div>
                        </div> 
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

        </div>
    </main>

<?php
    require("../../template/footer.php")
?>