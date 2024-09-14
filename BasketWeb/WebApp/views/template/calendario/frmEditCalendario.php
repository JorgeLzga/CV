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

        $idCalendario = $_GET['idCalendario'];
        $idTorneo = $_GET['idTorneo'];
        $fechaSeleccionada = $_GET['vFecha'];

        $objCalendarioController = new CalendarioController();
        $CalendarioInfo = $objCalendarioController->selectOneCalendarioCompleto($idCalendario, $idTorneo);
        $calendario = $objCalendarioController->selectAllCalendario($_GET['idTorneo']);
        $calendarioTodo = $objCalendarioController->selectOneCalendario($idTorneo);

        $objCategoriasController = new CategoriasController();
        $categorias = $objCategoriasController->selectAllCategorias();
        $idCategoria = $objCategoriasController->selectOneCategoriaCalendario($idCalendario, $idTorneo);

        $objTorneosControllador = new torneosController();
        $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

    ?>
    <main>
        <div class="body-text">

            <h1 class="">Editar  Partido</h1>
            <p class="text-desert"><b>Editar Partido</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../calendario/lstCalendarioInfo.php?idTorneo=<?= $lstTorneo['idTorneo'] ?>&vFecha=<?= $fechaSeleccionada ?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Regresar a Partido(s)</a>
            </div>
                <div class="py-4">
                    <div class="form-block">
                        <form action="updateCalendario.php" method="POST">
                    
                            <div class="row mb-4">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Equipo Local</span>
                                    <select name="vEqLocal" id="vEqLocal" class="form-select" required>
                                        <?php foreach ($calendario as $lscalendario) : ?>
                                            <option value="<?= $lscalendario['idEquipo'] ?>" <?= ($CalendarioInfo['vEqLocal'] == $lscalendario['idEquipo']) ? 'selected' : '' ?>>
                                                <?= $lscalendario['vNombreEquipo'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Equipo Visitante</span>

                                    <select name="vEqVisitante" id="vEqVisitante" class="form-select" required>
                                        <?php foreach ($calendario as $lscalendario) : ?>
                                            <option value="<?= $lscalendario['idEquipo'] ?>" <?= ($CalendarioInfo['vEqVisitante'] == $lscalendario['idEquipo']) ? 'selected' : '' ?>>
                                                <?= $lscalendario['vNombreEquipo'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>  
      
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Hora</span>
                                    <input type="time" class="form-control" id="vHora" name="vHora" value="<?= $CalendarioInfo['vHora'] ?>" required/>
                                </div>  

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Fecha</span>
                                    <input type="date" class="form-control" id="vFecha" name="vFecha" value="<?= $CalendarioInfo['vFecha'] ?>"  required/>
                                </div>       
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Sede</span>
                                    <input type="text" class="form-control" id="vSede" name="vSede" value="<?= $CalendarioInfo['vSede'] ?>" required/>
                                </div>    

                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font">Seleccionar una Categoria</span>
                                    <select name="idCategoria" id="idCategoria" class="form-select" required>
                                        <?php foreach ($categorias as $categoria) : ?>
                                            <option value="<?= $categoria['idCategoria'] ?>" <?php if ($categoria['idCategoria'] == $idCategoria) echo 'selected' ?>>
                                                <?= $categoria['vCategoria'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Tipo de Juego</span>
                               <select name="vTipoJuego" id="vTipoJuego" class="form-select" required>
                                    <option value="" disabled>Seleccione un Juego</option>
                                    <option value="<?= $CalendarioInfo['vTipoJuego'] ?>" selected><?= $CalendarioInfo['vTipoJuego'] ?></option>
                                      <option value="Regular" <?= ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['vTipoJuego'] === 'Regular') ? 'selected' : '' ?>>Regular</option>
                                                                        <option value="Exhibicion" <?= ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['vTipoJuego'] === 'Exhibicion') ? 'selected' : '' ?>>Exhibicion</option>
                                                                        <option value="Semifinal" <?= ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['vTipoJuego'] === 'Semifinal') ? 'selected' : '' ?>>Semifinal</option>
                                                                        <option value="Final" <?= ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['vTipoJuego'] === 'Final') ? 'selected' : '' ?>>Final</option>
                                    <?php
                                    $selectedTipoJuego = $CalendarioInfo['vTipoJuego']; // Guarda el valor seleccionado para evitar duplicados
                                    
                                    foreach ($tipoJuego as $vTipoJuego) : ?>
                                        <?php if ($vTipoJuego['vTipoJuego'] !== $selectedTipoJuego) : ?>
                                            <option value="<?= $vTipoJuego['vTipoJuego'] ?>"><?= $vTipoJuego['vTipoJuego'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>                                   
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row">
                                <input type="hidden" name="idCalendario" value="<?= $CalendarioInfo['idCalendario']?>">
                                <input type="hidden" name="idTorneo" value="<?= $CalendarioInfo['idTorneo']?>">
                                <input  type="submit" class="btn button-terracota" value="Actualizar Calendario">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>