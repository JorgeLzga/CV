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
                require_once("../../../Controllers/UsuarioController.php");

                $idTorneo = $_GET['idTorneo'];
                $idGrupo = $_GET['idGrupo'];

                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

                $objCalendarioModel = new CalendarioController();
                $calendarioTodo = $objCalendarioModel->selectOneCalendario($idTorneo,);
 
                $objUsuariosControllador = new UsuarioController();
                $lstUsuarioGrupoSt = $objUsuariosControllador->selectAllEstGrupoUsuario($idTorneo, $idGrupo);


            ?>

            <h1 class=""> Stading General </h1>
            <p class="text-desert"> <b> Estadisticas de los Equipos </b> </p>
            <div class="horizontal-line"> </div>

            <div class="d-flex flex-column flex-sm-row">
                <a href="infoUsuario.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar al Inicio
                </a>
            </div>
            <div class="table-responsive py-4">
                <table class="table text-center">
                    <thead>
                        <th class="text-start"> <span class="badge bg-barron text-white">Nombre Equipo </span></th>
                        <th> <span class="badge bg-barron text-white">Partidos </span></th>
                        <th> <span class="badge bg-barron text-white">Ganados </span></th>
                        <th> <span class="badge bg-barron text-white">Perdidos </span></th>
                        <th> <span class="badge bg-barron text-white">Puntos a Favor </span></th>
                        <th> <span class="badge bg-barron text-white">Puntos en Contra </span></th>
                        <th> <span class="badge bg-barron text-white">Diferencia de Puntos </span></th>
                        <th> <span class="badge bg-barron text-white">Puntaje </span></th>

                    </thead>
                    <?php foreach ($lstUsuarioGrupoSt as $EstEquipo): ?>
                    <tbody>
                        <tr>
                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-start">        
                                <b class="text-decoration-none text-barron"><?= $EstEquipo['vNombreEquipo']; ?></b>
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $EstEquipo['VecesJugo']; ?>     
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $EstEquipo['VecesGanadas']; ?>     
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $EstEquipo['VecesPerdidas']; ?>          
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $EstEquipo['PuntosAFavor']; ?>         
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $EstEquipo['PuntosEnContra']; ?>         
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $EstEquipo['DiferenciaDePuntos']; ?>              
                            </td>

                            <td style="vertical-align: middle; color: #A62F14 !important;" class="border-0 text-center">
                                <?= $EstEquipo['Puntos']; ?>         
                            </td>
                                
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </main>

<?php
    require("../../template/footer.php")
?>