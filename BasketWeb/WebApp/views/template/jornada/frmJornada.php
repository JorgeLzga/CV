<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    
    <title>Agregar Jornada</title>
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

                $idCalendario = $_GET['idCalendario'];
                $idTorneo = $_GET['idTorneo'];
                $fechaSeleccionada = $_GET['vFecha'];                
                
                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);
                
                $objJornadaControllador = new JornadaController();
                // $lstJornadaEqLocal = $objJornadaControllador->selectAllJornadaEqLocal($idCalendario, $idTorneo); 
                // $lstJornadaEqVisitante = $objJornadaControllador->selectAllJornadaEqVisitante($idCalendario, $idTorneo);

                $lstJornadaEquipoLocal = $objJornadaControllador->selectAllJornadaEquipoLocal($idCalendario,$idTorneo);
                $lstJornadaEquipoVisitante = $objJornadaControllador->selectAllJornadaEquipoVisitante($idCalendario,$idTorneo);

            ?>
            <h1 class="">Agregar Resultados </h1>
            <p class="text-desert"><b>Lista de Resultados</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="infoJornada.php?idTorneo=<?= $lstTorneo['idTorneo'] ?>&idCalendario=<?= !empty($lstJornadaEquipoLocal) ? $lstJornadaEquipoLocal[0]['idCalendario'] : '' ?>&vFecha=<?= $fechaSeleccionada ?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2">
                    <i class="fa-solid fa-angle-left"></i> Regresar a Resultados
                </a>
            </div>
            
            <h1 class="text-center text-desert py-5">Torneo <?= $lstTorneo['vNombreTorneo']?></h1>

            <form action="insertJornada.php" method="POST">
                <input type="hidden" name="fechaSeleccionada" value="<?= $fechaSeleccionada ?>">
                <div class="row justify-content-center ">
                      
                    <div class="col-md-6 mb-3">
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
                                                    
                                                <?php foreach ($lstJornadaEquipoLocal as $index => $JornadaEqLocal): ?>
                                                    <tr>
                                                        <td colspan="2" style="vertical-align: middle; width: 60%;" class="border-0 text-start">
                                                            <?= $JornadaEqLocal['vNombreJugador']. ' '. $JornadaEqLocal['vApellidoJugador']?>
                                                        </td>
                                                    
                                                        <td style="vertical-align: middle; width: 20%;" class="border-0 text-start">
                                                            <input class="form-control text-center border-0" type="number" 
                                                                name="jugadores[local][<?= $index ?>][vPuntosTotal]" 
                                                                value="<?= empty($JornadaEqLocal['vPuntosTotal']) ? 0 : $JornadaEqLocal['vPuntosTotal'] ?>">
                                                        </td>
                                                    
                                                        <td style="vertical-align: middle; width: 10%;" class="border-0 text-start">
                                                            <input class="form-control text-center border-0" type="number" 
                                                                name="jugadores[local][<?= $index ?>][vTirosde3]"
                                                                value="<?= empty($JornadaEqLocal['vTirosde3']) ? 0 : $JornadaEqLocal['vTirosde3'] ?>">

                                                        </td>
                                                    
                                                        <td style="vertical-align: middle; width: 15%;" class="border-0 text-start">
                                                            <input class="form-control text-center border-0" type="number" 
                                                                name="jugadores[local][<?= $index ?>][vFaltas]"
                                                                value="<?= empty($JornadaEqLocal['vFaltas']) ? 0 : $JornadaEqLocal['vFaltas'] ?>">
                                                        </td>

                                                        <input type="hidden" name="jugadores[local][<?= $index ?>][idTorneo]" value="<?= $JornadaEqLocal['idTorneo'] ?>">
                                                        <input type="hidden" name="jugadores[local][<?= $index ?>][idCalendario]" value="<?= $JornadaEqLocal['idCalendario'] ?>">
                                                        <input type="hidden" name="jugadores[local][<?= $index ?>][idEquipo]" value="<?= $JornadaEqLocal['idEquipo'] ?>">
                                                        <input type="hidden" name="jugadores[local][<?= $index ?>][idJugador]" value="<?= $JornadaEqLocal['idJugador'] ?>">
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <label>
                                            <input type="radio" name="ganadorDefault" value="<?= $JornadaEqLocal['idEquipo'] . ',' . $JornadaEqLocal['idCalendario'] . ',' . $JornadaEqLocal['idTorneo'] ?>" />
                                            <input type="hidden" name="vPuntosDefault" value="20" />
                                                Ganador por Default
                                        </label>

                                      </div>
                                <div class="card-footer border-0"></div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
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
                                                <?php foreach ($lstJornadaEquipoVisitante as $index => $JornadaEqVisitante): ?>
                                                    <tr>
                                                        <td colspan="2" style="vertical-align: middle; width: 60%;" class="border-0 text-start">
                                                            <?= $JornadaEqVisitante['vNombreJugador']. ' '. $JornadaEqVisitante['vApellidoJugador']?>
                                                        </td>
                                                            
                                                        <td style="vertical-align: middle; width: 20%;" class="border-0 text-start">
                                                            <input class="form-control text-center border-0" type="number" 
                                                                    name="jugadores[visitante][<?= $index ?>][vPuntosTotal]"
                                                                    value="<?= empty($JornadaEqVisitante['vPuntosTotal']) ? 0 : $JornadaEqVisitante['vPuntosTotal'] ?>">
                                                        </td>
                                                            
                                                        <td style="vertical-align: middle; width: 10%;" class="border-0 text-start">
                                                            <input class="form-control text-center border-0" type="number" 
                                                                    name="jugadores[visitante][<?= $index ?>][vTirosde3]"
                                                                    value="<?= empty($JornadaEqVisitante['vTirosde3']) ? 0 : $JornadaEqVisitante['vTirosde3'] ?>">
                                                        </td>
                                                            
                                                        <td style="vertical-align: middle; width: 15%;" class="border-0 text-start">
                                                                <input class="form-control text-center border-0" type="number" 
                                                                    name="jugadores[visitante][<?= $index ?>][vFaltas]"
                                                                    value="<?= empty($JornadaEqVisitante['vFaltas']) ? 0 : $JornadaEqVisitante['vFaltas'] ?>">
                                                        </td>
                                                            <input type="hidden" name="jugadores[visitante][<?= $index ?>][idTorneo]" value="<?= $JornadaEqVisitante['idTorneo'] ?>">
                                                            <input type="hidden" name="jugadores[visitante][<?= $index ?>][idCalendario]" value="<?= $JornadaEqVisitante['idCalendario'] ?>">
                                                            <input type="hidden" name="jugadores[visitante][<?= $index ?>][idEquipo]" value="<?= $JornadaEqVisitante['idEquipo'] ?>">
                                                            <input type="hidden" name="jugadores[visitante][<?= $index ?>][idJugador]" value="<?= $JornadaEqVisitante['idJugador'] ?>">
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <label>
                                            <input type="radio" name="ganadorDefault" value="<?= $JornadaEqVisitante['idEquipo'] . ',' . $JornadaEqVisitante['idCalendario'] . ',' . $JornadaEqVisitante['idTorneo'] ?>" />
                                            Ganador por Default 
                                        </label>
                                    </div>
                                <div class="card-footer border-0"></div>
                            </div>
                        </div>    
                    </div> 
                    
                    <div class="d-flex flex-column flex-sm-row">
                        <input  type="submit" class="btn button-terracota" value="Agregar Resultados">
                    </div>

                </div>
            </form>
        </div>
             
    </main>
    <?php require("../../template/footer.php")?>