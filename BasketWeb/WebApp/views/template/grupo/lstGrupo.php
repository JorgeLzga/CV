<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Agregar Grupo</title>
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
                require_once("../../../controllers/GruposController.php");

                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);
                
                $objGruposControllador = new gruposController();
                $lstGrupo = $objGruposControllador->selectOneGrupoComplete($_GET['idTorneo']);

                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                    if (isset($_GET['success'])) {
                        
                        $success = $_GET['success'];
                        
                        if ($success === 'inserted') {

                            $_SESSION['success_message'] = '<a href="lstGrupo.php?idTorneo=' . $lstTorneo['idTorneo'] . '" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El grupo se ha insertado correctamente.</a>';


                        } elseif ($success === 'updated') {

                            $_SESSION['success_message'] = '<a href="lstGrupo.php?idTorneo=' . $lstTorneo['idTorneo'] . '" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El grupo se ha actualizado correctamente.</a>';

                        } elseif ($success === 'deleted') {

                            $_SESSION['success_message'] = '<a href="lstGrupo.php?idTorneo=' . $lstTorneo['idTorneo'] . '" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El grupo se ha eliminado correctamente.</a>';
                        }
                    }

                    if (isset($_SESSION['success_message'])) {

                        echo '<div class="alert alert-success text-center">' . $_SESSION['success_message']. '</div>';
                        unset($_SESSION['success_message']);

                    }
            ?>

            <h1 class="">Lista de Grupos</h1>
            <p class="text-desert"><b>Lista Grupo</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../torneo/infoTorneo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar al Torneo</a>
                <a href="frmGrupo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-basketball"></i> Agregar Grupo</a>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4 m-4 justify-content-center">
                <?php foreach ($lstGrupo as $grupo): ?>
                    <div class="col-md-3 mb-3">
                        <div class="text-decoration-none">
                            <div class="col">
                                <div class="card border-0 h-100">
                                    <center>
                                        <div class="text-decoration-none text-reset">
                                            <div class="card h-100 shadow border-0 elevate-card rounded-top">
                                                <div class="card-header border-0" 
                                                    style="background-image: url('../../assets/imgBg/bg-basket.jpg');height: 300px; background-size: cover;">
                                                </div>
                                                
                                                <div class="card-body text-terracota"><br>
                                                    <h4><?= $grupo['vNombreGrupo']?></h4>
                                                    <p class="text-desert"><?= $grupo['vCategoria']?></p>
                                                </div>

                                                <div class="card-footer border-0">
                                                    <a href="infoGrupo.php?idTorneo=<?= $grupo['idTorneo'] ?>&idGrupo=<?= $grupo['idGrupo'] ?>" title="Ver Grupo">
                                                        <i class="fa-solid fa-list-check size-icon text-desert"></i></a>&ensp;

                                                    <a href="frmEditGrupo.php?idTorneo=<?= $grupo['idTorneo'] ?>&idGrupo=<?= $grupo['idGrupo'] ?>" title="Editar Grupos" >
                                                        <i class="fa-solid fa-pen-to-square size-icon text-desert"></i></a>&ensp;
                                                        
                                                    <a href="deleteGrupo.php?idTorneo=<?= $grupo['idTorneo'] ?>&idGrupo=<?= $grupo['idGrupo'] ?>" title="Eliminar Grupo">
                                                        <i class="fas fa-delete-left size-icon text-desert"></i></a></td>&ensp;
                                                </div>                            
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div> 
                    </div>
                <?php endforeach; ?>   
            </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>