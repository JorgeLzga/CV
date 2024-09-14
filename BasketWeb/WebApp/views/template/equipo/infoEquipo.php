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


                $idGrupo = $_GET['idGrupo']; 
                $idTorneo = $_GET['idTorneo']; 
                $idEquipo = $_GET['idEquipo'];

                $objEquiposController = new EquiposController();
                $equipo = $objEquiposController->selectOneEquipo($idGrupo, $idTorneo);
                $equipoCompleto = $objEquiposController->selectOneEquipoComplete($idEquipo, $idGrupo, $idTorneo);

                $objJugadorController = new JugadoresController();
                $jugador = $objJugadorController->selectOneJugador($idGrupo, $idTorneo, $idEquipo);


                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                    if (isset($_GET['success'])) {
                        
                        $success = $_GET['success'];
                        
                        if ($success === 'inserted') {

                            $_SESSION['success_message'] = '<a href="infoEquipo.php?idTorneo=' . $equipoCompleto['idTorneo'] . '&idGrupo=' . $equipoCompleto['idGrupo'] . '&idEquipo=' .$equipoCompleto['idEquipo']. '
                                                            "class="text-decoration-none" style="color: #0A3622"><i class="fa-solid fa-check"></i> El Jugador se ha insertado correctamente.</a>';

                        } elseif ($success === 'updated') {

                            $_SESSION['success_message'] = '<a href="infoEquipo.php?idTorneo=' . $equipoCompleto['idTorneo'] . '&idGrupo=' . $equipoCompleto['idGrupo'] . '&idEquipo=' .$equipoCompleto['idEquipo']. '
                                                            "class="text-decoration-none" style="color: #0A3622"><i class="fa-solid fa-check"></i> El Jugdor se ha actualizado correctamente.</a>';

                        } elseif ($success === 'deleted') {

                            $_SESSION['success_message'] = '<a href="infoEquipo.php?idTorneo=' . $equipoCompleto['idTorneo'] . '&idGrupo=' . $equipoCompleto['idGrupo'] . '&idEquipo=' .$equipoCompleto['idEquipo']. '
                                                            "class="text-decoration-none" style="color: #0A3622"><i class="fa-solid fa-check"></i> El jugador se ha eliminado correctamente.</a>';
                        }
                    }

                    if (isset($_SESSION['success_message'])) {

                        echo '<div class="alert alert-success text-center">' . $_SESSION['success_message']. '</div>';
                        unset($_SESSION['success_message']);

                    }
            ?>

            <h1 class="">Informacion del Equipo</h1>
            <p class="text-desert"><b>Informacion Equipos</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                
               <a href="../grupo/infoGrupo.php?idTorneo=<?= $equipoCompleto['idTorneo'] ?>&idGrupo=<?= $equipoCompleto['idGrupo'] ?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Ver Equipos</a>

                <a href="../jugador/frmJugador.php?idTorneo=<?= $equipoCompleto['idTorneo'] ?>&idGrupo=<?= $equipoCompleto['idGrupo'] ?>&idEquipo=<?= $equipoCompleto['idEquipo'] ?>" 
                    class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-user"></i> Agregar Jugador</a>

                <a href="../torneo/infoTorneo.php?idTorneo=<?= $equipoCompleto['idTorneo'] ?>&idGrupo=<?= $equipoCompleto['idGrupo'] ?>&idEquipo=<?= $equipoCompleto['idEquipo'] ?>" 
                    class="btn button-barron mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-house"></i> Ver Inicio</a>
            </div>
            
            <div class="row row-cols-1 row-cols-md g-4 m-4 justify-content-center">
                <div class="col">
                    <div class="card border-0 shadow">
                        <div class="row g-0">
                            <div class="col-md-4 rounded img-fluid custom-img" 
                                 style="background-image: url('../../assets/imgEquipo/<?= $equipoCompleto['vImgEquipo']?>');
                                        height: 270px; /* Puedes ajustar la altura según tus necesidades */
                                        background-size: cover;
                                        background-position: center;">
                                <!-- Imagen con clases img-fluid -->
                                <!-- <img src="../../assets/imgEquipo/<?= $equipoCompleto['vImgEquipo']?>" alt="Descripción de la imagen" class="card-img img-fluid"> -->
                            </div>
                            <div class="col-md-8 card-body p-4">
                                <h5 class="card-title text-desert"><b><?= $equipoCompleto['vNombreEquipo']?></b></h5>
                                <div class="text-barron"><?= $equipoCompleto['vNombreCapitan']?></div>
                                <p><div class="horizontal-line-card"></div></p>
                                <div class="text-barron">
                                    <?= $equipoCompleto['vCorreoCapitan']?><br>
                                    <?= $equipoCompleto['vCelularCapitan']?>
                                </div><br>
                                <h6 class="text-barron">Lista de Jugadores del Equipo</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-5 m-3 justify-content-center">
            <?php foreach ($jugador as $jugadores): ?>        
                <div class="col">
                    <center>
                        <div class="text-decoration-none text-reset">
                            <div class="card h-100 shadow border-0 elevate-card rounded-top" id="elevating-card1">
                                <!--    <div class="card-header border-0" 
                                        style="background-image: url('../../assets/imgJugador/<?= $jugadores['vImgJugador']?>');height: 300px; background-size: cover;">
                                        <img src="../../assets/imgBg/Bg-Basket.jpg" alt="Descripción de la imagen" class="card-img img-fluid">

                                </div> -->
                                <div class="border-0 card-img-top">
                                    <img src="../../assets/imgJugador/<?= $jugadores['vImgJugador']?>" class="card-img img-fluid custom-img">
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title text-desert"><b><?= $jugadores['vNombreJugador']. ' ' . $jugadores['vApellidoJugador']?></b></h5>

                                    <div class="text-barron"><b>Fecha de Nacimiento: </b><?= $jugadores['vFechaNacimiento']?><br>
                                                            <b>Correo: </b><?= $jugadores['vCorreoJugador']?><br>
                                                            <b>Celular: </b><?= $jugadores['vCelularJugador']?></div>
                                    <p><div class="horizontal-line-card"></div></p>
                                    <h6 class="text-desert"><b>Emergencia</b></h6>
                                    <div class="text-barron"><b>Tipo Sangre:</b> <?= $jugadores['vTipoSangre']?><br>
                                            <b>Num Emergencia:</b> <?= $jugadores['vContactoEmergencia']?>
                                    </div>
                                </div>
                                
                                <div class="card-footer border-0">
                                    <tr>
                                        <td style="vertical-align: middle;">
                                            <a href="">
                                                <i class="fa-solid fa-list-check size-icon text-desert"></i></a></td>&ensp;

                                        <td style="vertical-align: middle;">
                                            <a href="../jugador/frmEditJugador.php?idTorneo=<?= $jugadores['idTorneo'] ?>&idGrupo=<?= $jugadores['idGrupo'] ?>&idEquipo=<?= $jugadores['idEquipo'] ?>&idJugador=<?= $jugadores['idJugador'] ?>" title="Ver Jugador" title="Editar Jugador" >
                                                <i class="fa-solid fa-pen-to-square size-icon text-desert"></i></a></td>&ensp;

                                        <td style="vertical-align: middle;">
                                            <a href="../jugador/deleteJugador.php?idTorneo=<?= $jugadores['idTorneo'] ?>&idGrupo=<?= $jugadores['idGrupo'] ?>&idEquipo=<?= $jugadores['idEquipo'] ?>&idJugador=<?= $jugadores['idJugador'] ?>" title="Eliminar jugador">
                                                <i class="fas fa-delete-left size-icon text-desert"></i></a></td>&ensp;
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
    <?php require("../../template/footer.php")?>