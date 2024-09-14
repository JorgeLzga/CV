<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    
    <title>info Jornada</title>
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
                require_once("../../../controllers/JornadaController.php");
                require_once("../../../controllers/CalendarioController.php");

                $fechaSeleccionada = $_GET['vFecha'];
                $idCalendario = $_GET['idCalendario'];
                $idTorneo = $_GET['idTorneo'];

                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);
                
                $objJornadaControllador = new JornadaController();
                $lstJornadaEqLocal = $objJornadaControllador->selectAllJornadaEqLocal($idCalendario, $idTorneo); 
                $lstJornadaEqVisitante = $objJornadaControllador->selectAllJornadaEqVisitante($idCalendario, $idTorneo);

                $lstJornadaEquipoLocal = $objJornadaControllador->selectAllJornadaEquipoLocal($idCalendario,$idTorneo);
                $lstJornadaEquipoVisitante = $objJornadaControllador->selectAllJornadaEquipoVisitante($idCalendario,$idTorneo);


                $objCalendarioModel = new CalendarioController();
                $calendarioTodo = $objCalendarioModel->selectOneCalendario($idTorneo);

                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                if (isset($_GET['success'])) {
                    
                    $success = $_GET['success'];
                    
                    if ($success === 'inserted') {

                        $_SESSION['success_message'] = '<a href="infoJornada.php?idTorneo='. $lstTorneo['idTorneo'] .'&idCalendario='.$idCalendario.'&vFecha='.$fechaSeleccionada.'" class="text-decoration-none" style="color: #0A3622">
                                                        <i class="fa-solid fa-check"></i> El resultado se ha agregado correctamente.</a>';

                    } 
                }

                if (isset($_SESSION['success_message'])) {

                    echo '<div class="alert alert-success text-center">' . $_SESSION['success_message']. '</div>';
                    unset($_SESSION['success_message']);

                }


            ?>
        	<h1 class="">Lista Resultados </h1>
        	<p class="text-desert"><b>Lista de Jugadores</b></p>
        	<div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../calendario/lstCalendarioInfo.php?idTorneo=<?= $lstTorneo['idTorneo'] ?>&vFecha=<?= $fechaSeleccionada ?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar a Partido(s)</a>
                
                <a href="frmJornada.php?idTorneo=<?= $lstTorneo['idTorneo']?>&idCalendario=<?= !empty($lstJornadaEquipoLocal) ? $lstJornadaEquipoLocal[0]['idCalendario'] : '' ?>&vFecha=<?= $fechaSeleccionada ?>" 
                    class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-calendar-days"></i>  Agregar Resultados</a>

                <a href="frmEditJornada.php?idTorneo=<?= $lstTorneo['idTorneo']?>&idCalendario=<?= !empty($lstJornadaEquipoLocal) ? $lstJornadaEquipoLocal[0]['idCalendario'] : '' ?>&vFecha=<?= $fechaSeleccionada ?>" 
                    class="btn button-barron mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-pen-to-square"></i>  Editar Resultados</a>
            </div>
            
            <h1 class="text-center text-desert py-5">Torneo <?= $lstTorneo['vNombreTorneo']?></h1>
            <div class="row justify-content-center ">
                  
                <div class="col-md-6 mb-3   ">
                    <div class="text-decoration-none text-reset">
                        <div class="card h-100 shadow border-0 elevate-card rounded-top">
                            <div class="border-0"></div>
                            <div class="card-body" style="padding: 15px 35px 15px 35px;">
                                <h2 class="card-title text-terracota text-center">
                                    Equipo <?= !empty($lstJornadaEquipoLocal) ? $lstJornadaEquipoLocal[1]['nombreEquipoLocal'] : "Sin Nombre" ?>
                                </h2>
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%;" colspan="2" class="text-start">
                                                            <span class="badge bg-terracota text-white">Nombre del Jugador</span>
                                                </th> 
                                                <th style="width: 20%;"><span class="badge bg-barron text-white">Puntos Total</span></th>
                                                <th style="width: 20%;"><span class="badge bg-barron text-white">Tiros de 3</span></th>
                                                <th style="width: 10%;"><span class="badge bg-barron text-white">Faltas</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lstJornadaEqLocal as $index => $JornadaEqLocal): ?>
                                            <tr>
                                                <td colspan="2" style="vertical-align: middle; width: 60%;" class="border-0 text-start">
                                                    <?= $JornadaEqLocal['vNombreJugador']. ' '. $JornadaEqLocal['vApellidoJugador']?>
                                                </td>
                                                
                                                <td style="vertical-align: middle; width: 20%;" class="border-0 text-center">
                                                    <?= empty($JornadaEqLocal['vPuntosTotal']) ? 0 : $JornadaEqLocal['vPuntosTotal'] ?>
                                                </td>
                                                
                                                <td style="vertical-align: middle; width: 10%;" class="border-0 text-center">
                                                    <?= empty($JornadaEqLocal['vTirosde3']) ? 0 : $JornadaEqLocal['vTirosde3'] ?>
                                                </td>
                                                
                                                <td style="vertical-align: middle; width: 10%;" class="border-0 text-center">
                                                    <?= empty($JornadaEqLocal['vFaltas']) ? 0 : $JornadaEqLocal['vFaltas'] ?>
                                                </td>
                                                    <input type="hidden" name="jugadores[<?= $index ?>][idTorneo]" value="<?= $lstTorneo['idTorneo'] ?>">
                                                    <input type="hidden" name="jugadores[<?= $index ?>][idCalendario]" value="<?= $lstJornadaEquipos['idCalendario'] ?>">
                                                    <input type="hidden" name="jugadores[<?= $index ?>][idEquipo]" value="<?= $JornadaEqLocal['idEquipo'] ?>">
                                                    <input type="hidden" name="jugadores[<?= $index ?>][idJugador]" value="<?= $JornadaEqLocal['idJugador'] ?>">
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer border-0"></div>
                        </div>
                    </div>
                </div>                  

                <div class="col-md-6 mb-3   ">
                    <div class="text-decoration-none text-reset">
                        <div class="card h-100 shadow border-0 elevate-card rounded-top">
                            <div class="border-0"></div>
                            <div class="card-body" style="padding: 15px 35px 15px 35px;">
                                <h2 class="card-title text-terracota text-center">
                                    Equipo <?= !empty($lstJornadaEquipoVisitante) ? $lstJornadaEquipoVisitante[1]['nombreEquipoVisitante'] : "Sin Nombre" ?>    
                                </h2>
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%;" colspan="2" class="text-start">
                                                        <span class="badge bg-terracota text-white">Nombre del Jugador</span>
                                                </th> 
                                                <th style="width: 20%;"><span class="badge bg-barron text-white">Puntos Total</span></th>
                                                <th style="width: 20%;"><span class="badge bg-barron text-white">Tiros de 3</span></th>
                                                <th style="width: 10%;"><span class="badge bg-barron text-white">Faltas</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lstJornadaEqVisitante as $index => $JornadaEqVisitante): ?>
                                            <tr>
                                                <td colspan="2" style="vertical-align: middle; width: 60%;" class="border-0 text-start">
                                                    <?= $JornadaEqVisitante['vNombreJugador']. ' '. $JornadaEqVisitante['vApellidoJugador']?>
                                                </td>
                                                
                                                <td style="vertical-align: middle; width: 20%;" class="border-0 text-center">
                                                    <?= empty($JornadaEqVisitante['vPuntosTotal']) ? 0 : $JornadaEqVisitante['vPuntosTotal'] ?>
                                                </td>
                                                
                                                <td style="vertical-align: middle; width: 10%;" class="border-0 text-center">
                                                    <?= empty($JornadaEqVisitante['vTirosde3']) ? 0 : $JornadaEqVisitante['vTirosde3'] ?>
                                                </td>
                                                
                                                <td style="vertical-align: middle; width: 10%;" class="border-0 text-center">
                                                    <?= empty($JornadaEqVisitante['vFaltas']) ? 0 : $JornadaEqVisitante['vFaltas'] ?>
                                                </td>
                                                    <input type="hidden" name="jugadores[<?= $index ?>][idTorneo]" value="<?= $lstTorneo['idTorneo'] ?>">
                                                    <input type="hidden" name="jugadores[<?= $index ?>][idCalendario]" value="<?= $lstJornadaEquipos['idCalendario'] ?>">
                                                    <input type="hidden" name="jugadores[<?= $index ?>][idEquipo]" value="<?= $JornadaEqVisitante['idEquipo'] ?>">
                                                    <input type="hidden" name="jugadores[<?= $index ?>][idJugador]" value="<?= $JornadaEqVisitante['idJugador'] ?>">
                                                </tr>
                                                <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer border-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>            
    </main>
    <?php require("../../template/footer.php")?>