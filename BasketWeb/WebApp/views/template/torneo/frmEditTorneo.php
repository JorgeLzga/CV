<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Editar Torneo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>
    <?php require("../headerAdm.php") ?>

    <main>
        <div class="body-text">
            <?php
                require_once("../../../controllers/TorneosController.php");
                
                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);
            ?>
            <h1 class="">Editar Torneo</h1>
            <p class="text-desert"><b>Editar Torneo</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../panelControl.php" class="btn button-terracota"><i class="fa-solid fa-angle-left"></i> Regresar al Panel</a>
            </div>
                <div class="py-4">
                    <div class="form-block">
                            <form action="updateTorneo.php" method="POST" enctype="multipart/form-data">
                                <div class="row mb-4">
                                    <div class="col-md-6 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font" > Nombre del Torneo</span>
                                        <input type="text" class="form-control" id="vNombreTorneo" 
                                                name="vNombreTorneo" value="<?= $lstTorneo['vNombreTorneo'] ?>" required/>
                                    </div>
                                                    
                                    <div class="col-md-4 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font">Foto del Torneo</span>
                                        <input type="file" class="form-control" name="vImagenTorneo" id="vImagenTorneo" 
                                               accept="image/png, image/jpeg, image/jpg">                      
                                    </div>
                                    
                                    <div class="col-md-2 col-sm-3 col-xs-3">
                                            <span class="help-block text-muted small-font">Nombre Imagen</span>
                                            <input type="text" class="form-control" value="<?= $lstTorneo['vImagenTorneo']?>" readonly>
                                            <input type="hidden" name="imagen_actual" value="<?= $lstTorneo['vImagenTorneo'] ?>">

                                    </div>
                                                                               
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font" > Sede del Torneo</span>
                                        <input type="text" class="form-control" id="vSede" 
                                                name="vSedeTorneo" value="<?= $lstTorneo['vSedeTorneo'] ?>" required/>
                                    </div>        
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font" > 1er Lugar</span>
                                        <input type="text" class="form-control" id="vPremio01" 
                                                name="vPremio01" value="<?= $lstTorneo['vPremio01'] ?>" required/>
                                    </div>

                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font" > 2do Lugar</span>
                                        <input type="text" class="form-control" id="vPremio02" 
                                                name="vPremio02" value="<?= $lstTorneo['vPremio02'] ?>" required/>
                                    </div>

                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font" > 3er Lugar</span>
                                        <input type="text" class="form-control" id="vPremio03" 
                                                name="vPremio03" value="<?= $lstTorneo['vPremio03'] ?>" required/>
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font" > Otro Premio</span>
                                        <input type="text" class="form-control" id="vOtroPremio" 
                                                name="vOtroPremio" value="<?= $lstTorneo['vOtroPremio'] ?>" required/>
                                    </div>            
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font" > Organizador del Torneo</span>
                                        <input type="text" class="form-control" id="vNombreOrganizador" 
                                                name="vNombreOrganizador" value="<?= $lstTorneo['vNombreOrganizador'] ?>" required/>
                                    </div>        
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6 col-sm-3 col-xs-3">
                                        <span class="help-block text-muted small-font" > Usuario del Organizador</span>
                                        <input type="text" class="form-control" id="vUsuarioOrganizador" 
                                                name="vUsuarioOrganizador"
                                                minlength="5" 
                                                maxlength="8"
                                                required
                                                value="<?= $lstTorneo['vUsuarioOrganizador'] ?>" 
                                                title="El usuario debe tener al menos 5 caracteres"required >
                                    </div>
                                             
                                </div>
                                <input type="hidden" class="form-control" name="idTorneo" id="idTorneo" value="<?= $lstTorneo['idTorneo'] ?>">
                                <div class="d-flex flex-column flex-sm-row">
                                    <input  type="submit" class="btn button-terracota" value="Actualizar Torneo">
                                </div>
                            </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>