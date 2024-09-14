<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Agregar Calendario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>
    <?php

        require("../../template/header.php");
        include_once("../../../controllers/CalendarioController.php");
        require_once("../../../controllers/TorneosController.php");
        include_once("../../../controllers/CategoriasController.php");


        $idTorneo = $_GET['idTorneo'];

        $objCalendarioModel = new CalendarioController();
        $calendario = $objCalendarioModel->selectAllCalendario($_GET['idTorneo']);

        $objCategoriasModel = new CategoriasController();
        $categorias = $objCategoriasModel->selectAllCategorias();

        $objTorneosControllador = new torneosController();
        $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

    ?>
    <main>
        <div class="body-text">

            <h1 class="">Agregar Calendario</h1>
            <p class="text-desert"><b>Nuevo Calendario</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="infoCalendario.php?idTorneo=<?= $lstTorneo['idTorneo']?>" class="btn button-terracota"><i class="fa-solid fa-angle-left"></i> Regresar al Calendario</a>
            </div>
                <div class="py-4">
                    <div class="form-block">
                        <form action="insertCalendario.php" method="POST">
                    
                            <div class="row mb-4">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Equipo Local</span>
                                    <select name="vEqLocal" id="vEqLocal" class="form-select" required>
                                        <option value="0" disabled selected>Seleccione un Equipo</option>
                                        <?php foreach ($calendario as $calendarioEqLocal) : ?>
                                            <option value="<?= $calendarioEqLocal['idEquipo'] ?>"><?= $calendarioEqLocal['vNombreEquipo'] ?></option>
                                        <?php endforeach; ?>
                                    </select>      
                                </div>
                                
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Equipo Visitante</span>
                                    <select name="vEqVisitante" id="vEqVisitante" class="form-select" required>
                                        <option value="0" disabled selected>Seleccione un Equipo</option>
                                        <?php foreach ($calendario as $calendarioEqVisitante) : ?>
                                            <option value="<?= $calendarioEqVisitante['idEquipo'] ?>"><?= $calendarioEqVisitante['vNombreEquipo'] ?></option>
                                        <?php endforeach; ?>
                                    </select>      
                                </div>
      
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Hora</span>
                                    <input type="time" class="form-control" id="vHora" name="vHora"required/>
                                </div>  

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Fecha</span>
                                    <input type="date" class="form-control" id="vFecha" name="vFecha"required/>
                                </div>       
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Sede</span>
                                    <input type="text" class="form-control" id="vSede" name="vSede"required/>
                                </div>    
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Categoria</span>
                                    <select name="idCategoria" id="idCategoria" class="form-select" required>
                                        <option value="0" disabled selected>Seleccione una Categoria</option>
                                        <?php foreach ($categorias as $categoria) : ?>
                                            <option value="<?= $categoria['idCategoria'] ?>"><?= $categoria['vCategoria'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Tipo de Juego</span>
                                    <select name="vTipoJuego" id="vTipoJuego" class="form-select" required>
                                        <option value="0" disabled selected>Seleccione un Tipo de Juego</option>
                                        <option value="Regular">Regular</option>
                                        <option value="Exhibicion">Exhibicion</option>
                                        <option value="Semifinal">Semifinal</option>
                                        <option value="Final">Final</option>
                                    </select>                                
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row">
                                <input type="hidden" name="idTorneo" value="<?= $lstTorneo['idTorneo']?>">
                                <input  type="submit" class="btn button-terracota" value="Agregar Calendario">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>