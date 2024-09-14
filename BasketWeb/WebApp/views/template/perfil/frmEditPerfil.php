<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Actualizar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>
</head>
    <?php require("../header.php") ?>
    <main>
    <?php
    require_once("../../../controllers/PerfilController.php");

    $objPerfilControllador = new PerfilController();

    if (isset($_GET['idTorneo'])) {

        $idTorneo = $_GET['idTorneo'];

        $perfil = $objPerfilControllador->obtenerPerfilPorId($idTorneo);

        if ($perfil) {
    ?>
        <div class="body-text">
            <h1 class="">Editar Perfil</h1>
            <div class="horizontal-line"></div>
                <div class="py-4">
                    <div class="form-block">
                        <form action="updatePerfil.php" method="POST" enctype="multipart/form-data">
                            
                            <div class="row mb-4">
                                <div class="col-md-6 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Usuario del Organizador</span>
                                    <input type="text" class="form-control" id="vUsuarioOrganizador" 
                                            name="vUsuarioOrganizador"
                                            minlength="5" 
                                            maxlength="8"
                                            required
                                            title="El usuario debe tener al menos 8 caracteres" value="<?php echo $perfil['vUsuarioOrganizador']; ?>"required >
                                </div>
                                
                                <div class="col-md-6 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font">Contraseña del Organizador</span>
                                    <input type="password" class="form-control" id="vContrasenaOrganizador" 
                                        name="vContrasenaOrganizador"
                                        pattern="^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$"
                                        maxlength="8" 
                                        title="La Contraseña debe tener al menos 8 caracteres, un número, una mayúscula y un carácter especial: !@#$%^&*"
                                        value="<?php echo $perfil['vContrasenaOrganizador']; ?>"required>
                                </div>         
                            </div>
                            
                            <input type="hidden" name="idTorneo" value="<?= $perfil['idTorneo'] ?>">
                            <div class="d-flex flex-column flex-sm-row">
                                <input  type="submit" class="btn button-terracota" value="Actualizar Perfil">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php 
        require("../footer.php"); 
            }
        }
    ?>

