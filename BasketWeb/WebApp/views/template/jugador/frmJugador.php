<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Agregar Jugador</title>
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
                require_once("../../../Controllers/EquiposController.php");

                $idGrupo = $_GET['idGrupo']; 
                $idTorneo = $_GET['idTorneo']; 
                $idEquipo = $_GET['idEquipo'];

                $objEquiposController = new EquiposController();
                $equipoCompleto = $objEquiposController->selectOneEquipoComplete($idEquipo, $idGrupo, $idTorneo);
            ?>
            <h1 class="">Agregar Jugador</h1>
            <p class="text-desert"><b>Nuevo Jugador</b></p>
            <div class="horizontal-line"></div>
    
            <div class="d-flex flex-column flex-sm-row">
                <a href="../equipo/infoEquipo.php?idTorneo=<?= $equipoCompleto['idTorneo'] ?>&idGrupo=<?= $equipoCompleto['idGrupo'] ?>&idEquipo=<?= $equipoCompleto['idEquipo'] ?>" class="btn button-terracota"><i class="fa-solid fa-angle-left"></i> Regresar</a>
            </div>
                <div class="py-4">
                    <div class="form-block">
                        <form action="insertJugador.php" method="POST" enctype="multipart/form-data">
                            <div class="row mb-4">
                                <div class="col-md-12 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Equipo</span>
                                    <p type="text" class="form-control" id="vNombreEquipo"><?= $equipoCompleto['vNombreEquipo']?> </p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Jugador</span>
                                    <input type="text" class="form-control" id="vNombreJugador" name="vNombreJugador"required/>
                                </div>

                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Apellidos</span>
                                    <input type="text" class="form-control" id="vApellidoJugador" name="vApellidoJugador"required/>
                                </div>

                                 <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Fecha de Nacimiento</span>
                                    <input type="date" class="form-control" id="vFechaNacimiento" name="vFechaNacimiento"required/>
                                </div>
                            </div>

                            <div class="row mb-4">
                                 <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Correo Electronico</span>
                                    <input type="email" class="form-control" id="vCorreoJugador" name="vCorreoJugador"required/>
                                </div> 

                                 <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Celular</span>
                                    <input type="tel" class="form-control" id="vCelularJugador" 
                                            name="vCelularJugador" inputmode="numeric" pattern="[0-9]{10}" title="Por favor, introduce un número de 10 dígitos." 
                                            minlength="10" 
                                            maxlength="10" required/>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Tipo de Sangre</span>
                                    <input type="text" class="form-control" id="vTipoSangre" name="vTipoSangre"required
                                            maxlength="3" />
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Contacto de Emergencia</span>
                                    <input type="text" class="form-control" id="vContactoEmergencia" 
                                    name="vContactoEmergencia" inputmode="numeric" pattern="[0-9]{10}" title="Por favor, introduce un número de 10 dígitos." 
                                            minlength="10" 
                                            maxlength="10" required/>
                                </div>
                            </div>

                            <div class="row mb-4">       
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Foto del Jugador</span>
                                    <input type="file" class="form-control" name="vImgJugador" 
                                    id="vImgJugador" 
                                            placeholder="Agregar Foto"
                                            accept="image/png, image/jpeg, image/jpg" required>                                
                                </div>                                               
                            </div>
                            <div class="d-flex flex-column flex-sm-row">
                                <input type="hidden" name="idGrupo" value="<?= $equipoCompleto['idGrupo']?>">
                                <input type="hidden" name="idTorneo" value="<?= $equipoCompleto['idTorneo']?>">
                                <input type="hidden" name="idEquipo" value="<?= $equipoCompleto['idEquipo']?>">
 
                                <input  type="submit" class="btn button-terracota" value="Agregar Jugador">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>