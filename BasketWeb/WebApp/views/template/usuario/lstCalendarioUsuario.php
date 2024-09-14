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
                
                $fechaSeleccionada = $_GET['vFecha'];
                $idTorneo = $_GET['idTorneo'];

                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

                $objCalendarioModel = new CalendarioController();
                $calendarioTodo = $objCalendarioModel->selectOneCalendario($idTorneo, $fechaSeleccionada);

            ?>
            <h1 class="">Calendario de Juegos</h1>
            <p class="text-desert"><b>Calendario de Juegos</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="infoUsuario.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar al Stading</a>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4 m-4 justify-content-center">
                <?php foreach ($calendarioTodo as $partido): ?>
                <a class="text-decoration-none"
                    href="infoJornadaUsuario.php?idTorneo=<?= $partido['idTorneo'] ?>&idCalendario=<?= $partido['idCalendario']?>&vFecha=<?= $fechaSeleccionada ?>">
                    <div class="col mb-3">
                        <div class="text-decoration-none">
                            <div class="card border-0 h-100">
                                <center>
                                    <div class="text-decoration-none text-reset">
                                        <div class="card h-100 shadow border-0 elevate-card rounded-top">
                                            <div class="card-header border-0"                                                    
                                                style="background-image: url('../../assets/imgBg/bg-basket.jpg');height: 140px; background-size: cover;">
                                            </div>
                                            <div class="card-body text-barron"><br>
                                                <div class="text-desert"><h4>Informacion del Partido</h4></div>
                                                    Juego <?= $partido['vTipoJuego'] ?><br>
                                                <p><div class="horizontal-line-card"></div></p>

                                                <div>
                                                    <b class="text-desert">Local: </b><?= $partido['nombreLocal'] ?><br>
                                                    <b class="text-desert">Visitante: </b><?= $partido['nombreVisitante']?><br>
                                                    <b class="text-desert">Sede:</b> <?= $partido['vSede'] ?>
                                                </div>

                                                <div class=""><b>Fecha:</b> <?= $partido['vFecha'] . ' <b>Hora: </b> ' . $partido['vHora']?>
                                                </div>
                                            </div>

                                            <div class="card-footer border-0">
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
    <?php require("../../template/footer.php")?>