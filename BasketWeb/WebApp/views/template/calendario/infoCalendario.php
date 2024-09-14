<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    
    <title>Calendario</title>
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

                include_once("../../../controllers/CalendarioController.php");
                
                $idTorneo = $_GET['idTorneo'];

                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                    if (isset($_GET['success'])) {
                        
                        $success = $_GET['success'];
                        
                        if ($success === 'inserted') {

                            $_SESSION['success_message'] = '<a href="infoCalendario.php?idTorneo='. $lstTorneo['idTorneo'].'" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El partido se ha insertado correctamente.</a>';

                        } elseif ($success === 'updated') {

                            $_SESSION['success_message'] = '<a href="infoCalendario.php?idTorneo='. $lstTorneo['idTorneo'].'" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El partido se ha actualizado correctamente.</a>';

                        } elseif ($success === 'deleted') {

                            $_SESSION['success_message'] = '<a href="infoCalendario.php?idTorneo='. $lstTorneo['idTorneo'].'" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El partido se ha eliminado correctamente.</a>';
                        }
                    }

                    if (isset($_SESSION['success_message'])) {

                        echo '<div class="alert alert-success text-center">' . $_SESSION['success_message']. '</div>';
                        unset($_SESSION['success_message']);

                    }
                

                $objCalendarioModel = new CalendarioController();
                $calendario = $objCalendarioModel->selectAllCalendario($_GET['idTorneo']);

                $objCalendarioModel = new CalendarioController();
                $calendarioTodo = $objCalendarioModel->selectOneCalendario($idTorneo,);

            ?>
            <h1 class="">Lista de Juegos</h1>
            <p class="text-desert"><b>Juegos</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../torneo/infoTorneo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar al Torneo</a>

                <a href="frmCalendario.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-calendar-days"></i> Agregar Calendario</a>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4 m-4 justify-content-center">
            <?php 
                $fecha_anterior = null;
                $contador_partidos = 0;

                foreach ($calendarioTodo as $partido):
                    $fecha_actual = $partido['vFecha'];

                    if ($fecha_anterior !== $fecha_actual):
                        if ($fecha_anterior !== null): 
            ?>
                <a class="text-decoration-none" href="lstCalendarioInfo.php?idTorneo=<?= $lstTorneo['idTorneo'] ?>&vFecha=<?= $fecha_anterior ?>">
                    <div class="col mb-3">
                        <div class="text-decoration-none">
                            <div class="card border-0 h-100">
                                <center>
                                    <div class="text-decoration-none text-reset">
                                        <div class="card h-100 shadow border-0 elevate-card rounded-top">
                                            <div class="card-body text-desert">
                                                <div class="text-terracota text-start">
                                                    <h6><b><i>Fecha:</b> <?= $fecha_anterior ?></i></h6>
                                                    <h1><?= $contador_partidos ?></h1>
                                                    <b>Partido(s) por Dia</b>
                                                </div>       
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </div>
                        </div> 
                    </div>
                </a>
            <?php
                        endif;
                    $contador_partidos = 0;
                endif;

                $fecha_anterior = $fecha_actual;
                $contador_partidos++;

            endforeach;

            if ($fecha_anterior !== null):
        ?>
                <a class="text-decoration-none" href="lstCalendarioInfo.php?idTorneo=<?= $lstTorneo['idTorneo'] ?>&vFecha=<?= $fecha_anterior ?>">
                <div class="col mb-3">
                    <div class="text-decoration-none">
                        <div class="card border-0 h-100">
                            <center>
                                <div class="text-decoration-none text-reset">
                                    <div class="card h-100 shadow border-0 elevate-card rounded-top">
                                        <div class="card-body text-desert">
                                            <div class="text-terracota text-start">
                                                <h6><b><i>Fecha:</b> <?= $fecha_anterior ?></i></h6>
                                                <h1><?= $contador_partidos ?></h1>
                                                <b>Partido(s) por Dia</b>
                                            </div>       
                                        </div>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div> 
                </div>
            </a>
        <?php endif; ?>
  
            </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>