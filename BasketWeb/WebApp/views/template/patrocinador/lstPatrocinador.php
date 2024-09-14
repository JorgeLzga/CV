<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    
    <title>Lista Patrocinadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

    <?php require("../../template/headerAdm.php") ?>
    <main>

        <div class="body-text">
            <?php
                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                    if (isset($_GET['success'])) {
                        
                        $success = $_GET['success'];
                        
                        if ($success === 'inserted') {

                            $_SESSION['success_message'] = '<a href="lstPatrocinador.php" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El patrocinador se ha insertado correctamente.</a>';

                        } elseif ($success === 'updated') {

                            $_SESSION['success_message'] = '<a href="lstPatrocinador.php" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El patrocinador se ha actualizado correctamente.</a>';

                        } elseif ($success === 'deleted') {

                            $_SESSION['success_message'] = '<a href="lstPatrocinador.php" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El patrocinador se ha eliminado correctamente.</a>';
                        }
                    }

                    if (isset($_SESSION['success_message'])) {

                        echo '<div class="alert alert-success text-center">' . $_SESSION['success_message']. '</div>';
                        unset($_SESSION['success_message']);

                    }

                include_once(__DIR__ . '/../../../controllers/PatrocinadorController.php');

                $objPatrocinadoresControllador = new patrocinadorController();
                $lstPatrocinadores = $objPatrocinadoresControllador->selectAllPatrocinadores();
        
                $contador = 0;

            ?>
        	<h1 class="">Patrocinadores</h1>
        	<p class="text-desert"><b>Lista de Patrocinadores</b></p>
        	<div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../panelControl.php" class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar al Panel</a>
                <a href="frmPatrocinador.php" class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-user-plus"></i> Agregar Patrocinador</a>
            </div>
            <div class="table-responsive py-4">
                <table class="table text-center">
                    <thead>
                        <th style="color:#A62F14 !important">#</th>
                        <th style="color:#A62F14 !important">Nombre del Patrocinador(es)</th>
                        <th style="color:#A62F14 !important">Imagen Patrocinador(es)</th>
                        <th style="color:#A62F14 !important">Nombre del Torneo</th>
                        <th style="color:#A62F14 !important"colspan="3">Opciones</th>
                    </thead>

                    <?php foreach ($lstPatrocinadores as $lstPatrocinador): ?>

                    <tbody>
                        <tr>
                            <td style="vertical-align: middle;">
                                <a style="text-decoration: none; color: inherit;" href="#"><?php echo ++$contador; ?></a></td>

                            <td style="vertical-align: middle;">
                                <a style="text-decoration: none; color: inherit;" href="#"><?= $lstPatrocinador['vNombrePatrocinador'] ?></a></td>

                            <td style="vertical-align: middle;">
                                <a style="text-decoration: none; color: inherit;" href="#">
                                    <img src="../../assets/imgPatrocinador/<?= $lstPatrocinador['vImgPatrocinador']?>" height="100px" width="150px" style="background-size: cover; border-radius: 15px;"></a></td>

                            <td style="vertical-align: middle;">
                                <a style="text-decoration: none; color: inherit;" href="#"><?= $lstPatrocinador['vNombreTorneo']?></a></td>

                            <td style="vertical-align: middle;">
                                <a href="frmEditPatrocinador.php?idPatrocinador=<?= $lstPatrocinador['idPatrocinador']?>"><i class="fa-solid fa-pen-to-square fa-2x text-desert"></i></a></td>

                            <td style="vertical-align: middle;">
                                <a href="deletePatrocinador.php?idPatrocinador=<?= $lstPatrocinador['idPatrocinador']?>"><i class="fas fa-delete-left fa-2x text-desert"></i></a></td>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>