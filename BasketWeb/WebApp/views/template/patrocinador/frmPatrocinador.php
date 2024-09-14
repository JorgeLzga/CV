<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Agregar Patrocinador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

    <?php

        include_once("../../../controllers/TorneosController.php");

        $torneoModel = new torneosController();
        $torneos = $torneoModel->selectAllTorneos();
    ?>

    <?php require("../../template/headerAdm.php") ?>
    <main>
        <div class="body-text">
            <h1 class="">Agregar Patrocinador</h1>
            <p class="text-desert"><b>Nuevo Patrocinador</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="lstPatrocinador.php" class="btn button-terracota"><i class="fa-solid fa-angle-left"></i> Ver Patrocinadores</a>
            </div>
                <div class="py-4">
                    <div class="form-block">
                        <form action="insertPatrocinador.php" method="POST" enctype="multipart/form-data">
                    
                            <div class="row mb-4">
                                <div class="col-md-8 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Patrocinador</span>
                                    <input type="text" class="form-control" id="vNombrePatrocinador" name="vNombrePatrocinador"required/>
                                </div>
                                                
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Foto del Torneo</span>
                                    <input type="file" class="form-control" name="vImgPatrocinador" id="vImgPatrocinador" 
                                            placeholder="Agregar Foto"
                                            accept="image/png, image/jpeg, image/jpg" required>                                
                                </div>                                               
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 col-sm-3 col-xs-3">
                                <span class="help-block text-muted small-font">Seleccionar un Torneo</span>
                                    <select name="idTorneo" id="idTorneo" class="form-select" required>
                                        <option value="0" disabled selected>Seleccione un Torneo</option>
                                        <?php foreach ($torneos as $torneo) : ?>
                                            <option value="<?= $torneo['idTorneo'] ?>"><?= $torneo['vNombreTorneo'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row">
                                <input  type="submit" class="btn button-terracota" value="Agregar Patrocinador">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>