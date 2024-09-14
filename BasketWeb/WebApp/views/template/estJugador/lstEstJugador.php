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
                include_once('../../../controllers/EstJugadorController.php');
                include_once('../../../controllers/TorneosController.php');

                $idTorneo = $_GET['idTorneo'];

                $objEstJugadorControlador = new estJugadorController ();
                $lstEstJugador = $objEstJugadorControlador->selectAllEstJugador($idTorneo);

                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

            ?>

            <h1 class=""> Estadisticas del Jugador: </h1>
            <p class="text-desert"> <b> Estadisticas de los Jugadores </b> </p>
            <div class="horizontal-line"> </div>

            <div class="d-flex flex-column flex-sm-row">
                <a href="../torneo/infoTorneo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"> <i class="fa-solid fa-angle-left"> </i> Regresar al Torneo</a>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-5 m-3 justify-content-center">
                <?php foreach ($lstEstJugador as $EstJugador): ?>
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

    <?php
        require("../../template/footer.php")
    ?>