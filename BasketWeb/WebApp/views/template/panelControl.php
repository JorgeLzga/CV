
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    
    <title>BasketApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

	<?php require("headerAdm.php") ?>
    <main>

        <div class="body-text">
            <?php
            
                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                if (isset($_GET['success'])) {
                    
                    $success = $_GET['success'];
                    
                    if ($success === 'inserted') {

                        $_SESSION['success_message'] = '<a href="panelControl.php" class="text-decoration-none" style="color: #0A3622">
                                                        <i class="fa-solid fa-check"></i> El torneo se ha insertado correctamente.</a>';

                    } elseif ($success === 'updated') {

                        $_SESSION['success_message'] = '<a href="panelControl.php" class="text-decoration-none" style="color: #0A3622">
                                                        <i class="fa-solid fa-check"></i> El torneo se ha actualizado correctamente.</a>';

                    } elseif ($success === 'deleted') {

                        $_SESSION['success_message'] = '<a href="panelControl.php" class="text-decoration-none" style="color: #0A3622">
                                                        <i class="fa-solid fa-check"></i> El torneo se ha eliminado correctamente.</a>';
                    }
                }

                if (isset($_SESSION['success_message'])) {

                    echo '<div class="alert alert-success text-center">' . $_SESSION['success_message']. '</div>';
                    unset($_SESSION['success_message']);

                }


                include_once(__DIR__ .'/../../controllers/TorneosController.php');

                $objTorneosControllador = new torneosController();
                $torneos = $objTorneosControllador->selectAllTorneos();

            ?>
        	<h1 class="">Panel de Control</h1>
        	<p class="text-desert"><b>Lista de Torneos</b></p>
        	<div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../../index.php" class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-house"></i> Ver Inicio</a>
                <a href="torneo/frmTorneo.php" class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-trophy"></i> Agregar Torneo</a>
                <a href="patrocinador/frmPatrocinador.php" class="btn button-barron mx-2"><i class="fa-solid fa-users-gear"></i> Agregar Patrocinadores</a>
            </div>


            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-5 m-2 text-justify">
                <?php foreach ($torneos as $torneo): ?>
                <div class="col">
                    <center>
                        <div class="text-decoration-none text-reset">
                            <div class="card h-100 shadow border-0 elevate-card rounded-top" id="elevating-card1">
                                <div class="card-header border-0" style="background-image: url('../assets/image/<?= $torneo['vImagenTorneo']?>');height: 300px; background-size: cover;"></div>
                                <div class="card-body">
                                    <h5 class="card-title text-desert"><?= $torneo['vNombreTorneo'] ?></h5>
                                    <p class="text-negro"><?= $torneo['vNombreOrganizador'] ?></p>

                                    <div class="horizontal-line-card"></div>
                                </div>
                                <div class="card-footer border-0">
                                    <tr>
                                        <td style="vertical-align: middle;">
                                            <a href="torneo/infoTorneo.php?idTorneo=<?= $torneo['idTorneo'] ?>" title="Ver Torneo"><i class="fa-solid fa-list-check size-icon text-desert"></i></a></td>&ensp;

                                        <td style="vertical-align: middle;">
                                            <a href="torneo/frmEditTorneo.php?idTorneo=<?= $torneo['idTorneo'] ?>" title="Editar Torneo" >
                                                <i class="fa-solid fa-pen-to-square size-icon text-desert"></i></a></td>&ensp;

                                        <td style="vertical-align: middle;">
                                            <a href="torneo/deleteTorneo.php?idTorneo=<?= $torneo['idTorneo'] ?>" title="Eliminar Torneo"><i class="fas fa-delete-left size-icon text-desert"></i></a></td>&ensp;
                                    </tr>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
	<?php require("footer.php") ?>