<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Agregar Torneo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>
    <?php require("../headerAdm.php") ?>
    <main>
        <div class="body-text">
            <?php
            
                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                if (isset($_GET['danger'])) {
                    
                    $danger = $_GET['danger'];
                    
                    if ($danger === 'error') {

                        $_SESSION['success_danger'] = '<a href="frmTorneo.php" class="text-decoration-none" style="color: #58151C">
                                                        <i class="fa-solid fa-xmark"></i> El nombre de usuario ya existe.</a>';
                    }
                }

                if (isset($_SESSION['success_danger'])) {

                    echo '<div class="alert alert-danger text-center">' . $_SESSION['success_danger']. '</div>';
                    unset($_SESSION['success_danger']);
                }

            ?>
            <h1 class="">Agregar Torneo</h1>
            <p class="text-desert"><b>Nuevo Torneo</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../panelControl.php" class="btn button-terracota"><i class="fa-solid fa-angle-left"></i> Regresar al Panel</a>
            </div>
                <div class="py-4">
                    <div class="form-block">
                        <form action="insertTorneo.php" method="POST" enctype="multipart/form-data">
                    
                            <div class="row mb-4">
                                <div class="col-md-8 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Torneo</span>
                                    <input type="text" class="form-control" id="vNombreTorneo" name="vNombreTorneo"required/>
                                </div>
                                                
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Foto del Torneo</span>
                                    <input type="file" class="form-control" name="vImagenTorneo" id="vImagenTorneo" 
                                            placeholder="Agregar Foto"
                                            accept="image/png, image/jpeg, image/jpg" required>                                
                                </div>                                               
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Sede del Torneo</span>
                                    <input type="text" class="form-control" id="vSede" name="vSedeTorneo"required/>
                                </div>        
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > 1er Lugar</span>
                                    <input type="text" class="form-control" id="vPremio01" name="vPremio01"required/>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > 2do Lugar</span>
                                    <input type="text" class="form-control" id="vPremio02" name="vPremio02"required/>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > 3er Lugar</span>
                                    <input type="text" class="form-control" id="vPremio03" name="vPremio03"required/>
                                </div>
                                
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Otro Premio</span>
                                    <input type="text" class="form-control" id="vOtroPremio" name="vOtroPremio"required/>
                                </div>            
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Organizador del Torneo</span>
                                    <input type="text" class="form-control" id="vNombreOrganizador" name="vNombreOrganizador"required/>
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
                                            title="El usuario debe tener al menos 8 caracteres"required >
                                </div>
                                
                                <div class="col-md-6 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font">Contraseña del Organizador</span>
                                    <input type="password" class="form-control" id="vContrasenaOrganizador" 
                                        name="vContrasenaOrganizador"
                                        pattern="^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$"
                                        maxlength="8" 
                                        title="La Contraseña debe tener al menos 8 caracteres, un número, una mayúscula y un carácter especial: !@#$%^&*"
                                        required>
                                </div>         
                            </div>
                            <div class="d-flex flex-column flex-sm-row">
                                <input  type="submit" class="btn button-terracota" value="Agregar Torneo">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>