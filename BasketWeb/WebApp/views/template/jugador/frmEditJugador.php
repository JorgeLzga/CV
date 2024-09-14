<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Editar Jugador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

 <?php require("../../template/header.php") ?>
    <main>
        <div class="body-text">
            <?php
                require_once("../../../Controllers/JugadoresController.php");
              
                $idJugador = $_GET['idJugador'];
                $idGrupo = $_GET['idGrupo']; 
                $idTorneo = $_GET['idTorneo']; 
                $idEquipo = $_GET['idEquipo'];

                $objJugadoresController = new JugadoresController();
                $jugador = $objJugadoresController->selectOneJugadorComplete($idJugador, $idGrupo, $idTorneo, $idEquipo);
            ?>
            <h1 class="">Editar Jugador</h1>
            <p class="text-desert"><b>Actualizar Jugador</b></p>
            <div class="horizontal-line"></div>
    
            <div class="d-flex flex-column flex-sm-row">
                <a href="../equipo/infoEquipo.php?idTorneo=<?= $jugador['idTorneo'] ?>&idGrupo=<?= $jugador['idGrupo'] ?>&idEquipo=<?= $jugador['idEquipo'] ?>" class="btn button-terracota"><i class="fa-solid fa-angle-left"></i> Regresar</a>
            </div>
                <div class="py-4">
                    <div class="form-block">
                        <form action="updateJugador.php" method="POST" enctype="multipart/form-data">
                            <div class="row mb-4">
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Jugador</span>
                                    <input type="text" class="form-control" id="vNombreJugador" 
                                            name="vNombreJugador" value="<?= $jugador['vNombreJugador']?>" required/>
                                </div>

                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Apellidos</span>
                                    <input type="text" class="form-control" id="vApellidoJugador" 
                                            name="vApellidoJugador" value="<?= $jugador['vApellidoJugador']?>"required/>
                                </div>

                                 <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Fecha de Nacimiento</span>
                                    <input type="date" class="form-control" id="vFechaNacimiento" 
                                            name="vFechaNacimiento" value="<?= $jugador['vFechaNacimiento']?>"required/>
                                </div>
                            </div>

                            <div class="row mb-4">
                                 <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Correo Electronico</span>
                                    <input type="email" class="form-control" id="vCorreoJugador" 
                                            name="vCorreoJugador" value="<?= $jugador['vCorreoJugador']?>"required/>
                                </div> 

                                 <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Celular</span>
                                    <input type="text" class="form-control" id="vCelularJugador" 
                                            name="vCelularJugador" value="<?= $jugador['vCelularJugador']?>"
                                            maxlength="10" 
                                            pattern="[0-9]{10}" required/>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Tipo de Sangre</span>
                                    <input type="text" class="form-control" id="vTipoSangre" 
                                            name="vTipoSangre" value="<?= $jugador['vTipoSangre']?>"required/>
                                </div>

                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" >Contacto de Emergencia</span>
                                    <input type="text" class="form-control" id="vContactoEmergencia" 
                                            name="vContactoEmergencia" value="<?= $jugador['vContactoEmergencia']?>"
                                            maxlength="10" 
                                            pattern="[0-9]{10}" required/>
                                </div>
                            </div>

                            <div class="row mb-4">       
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Foto del Jugador</span>
                                    <input type="file" class="form-control" name="vImgJugador" 
                                    id="vImgJugador" 
                                            placeholder="Agregar Foto"
                                            accept="image/png, image/jpeg, image/jpg">                                
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font">Nombre Imagen</span>
                                    <input type="text" class="form-control" value="<?= $jugador['vImgJugador']?>" readonly>
                                    <input type="hidden" name="imagen_actual" value="<?= $jugador['vImgJugador'] ?>">
                                </div>                                                 
                            </div>
                            <div class="d-flex flex-column flex-sm-row">
                                <input type="hidden" name="idJugador" value="<?= $jugador['idJugador']?>">
                                <input type="hidden" name="idGrupo" value="<?= $jugador['idGrupo']?>">
                                <input type="hidden" name="idTorneo" value="<?= $jugador['idTorneo']?>">
                                <input type="hidden" name="idEquipo" value="<?= $jugador['idEquipo']?>">
 
                                <input  type="submit" class="btn button-terracota" value="Actualizar Jugador">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>