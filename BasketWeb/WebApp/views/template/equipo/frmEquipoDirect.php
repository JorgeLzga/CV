<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Agregar Equipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>
    <?php
        require_once("../../../controllers/GruposController.php");
        require_once("../../../controllers/TorneosController.php");


        $idTorneo = $_GET['idTorneo']; 

        $objGrupos = new GruposController();
        $grupos = $objGrupos->selectAllGruposById($_GET['idTorneo']);

        $objTorneosControllador = new torneosController();
        $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);
    ?>

    <?php require("../../template/header.php") ?>
    <main>
        <div class="body-text">
            <h1 class="">Agregar Equipo</h1>
            <p class="text-desert"><b>Nuevo Equipo</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
             <!-- -->
            </div>

                <div class="py-4">
                    <div class="form-block">
                        <form action="insertEquipo.php" method="POST" enctype="multipart/form-data">
                    
                            <div class="row mb-4">

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font">Seleccionar un Grupo</span>
                                        <select name="idGrupo" id="idGrupo" class="form-select" required>
                                            <option value="0" disabled selected>Seleccione un Grupo</option>
                                            <?php foreach ($grupos as $grupo) : ?>
                                                <option value="<?= $grupo['idGrupo'] ?>"><?= $grupo['vNombreGrupo'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                            
                                <div class="col-md-5 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Equipo</span>
                                    <input type="text" class="form-control" id="vNombreEquipo" name="vNombreEquipo"required/>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Foto del Equipo</span>
                                    <input type="file" class="form-control" name="vImgEquipo" id="vImgEquipo" 
                                            placeholder="Agregar Foto"
                                            accept="image/png, image/jpeg, image/jpg" required>                                
                                </div>                                                              
                            </div>

                             <div class="row mb-4">
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Capitan</span>
                                    <input type="text" class="form-control" id="vNombreCapitan" name="vNombreCapitan"required/>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Correo del Capitan</span>
                                    <input type="email" class="form-control" id="vCorreoCapitan" name="vCorreoCapitan"required/>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Celular del Capitan</span>
                                    <input type="tel" class="form-control" id="vCelularCapitan" name="vCelularCapitan" 
                                            inputmode="numeric" pattern="[0-9]{10}" title="Por favor, introduce un número de 10 dígitos." 
                                            minlength="10" 
                                            maxlength="10" required/>
                                </div>
                                                              
                            </div>

                            <div class="d-flex flex-column flex-sm-row">
                                <input  type="hidden" name="idTorneo" value="<?= $lstTorneo['idTorneo']?>">
                                <input  type="submit" class="btn button-terracota" value="Agregar Equipo">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>