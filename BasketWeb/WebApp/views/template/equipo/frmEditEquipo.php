<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Editar Equipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>
    <?php require("../../template/header.php") ?>
    <main>
        <?php
            require_once("../../../Controllers/EquiposController.php");

            $idGrupo = $_GET['idGrupo']; 
            $idTorneo = $_GET['idTorneo'];
            $idEquipo = $_GET['idEquipo']; 

            $objEquipoController = new EquiposController();
            $equipo = $objEquipoController->selectOneEquipoComplete($idEquipo, $idGrupo, $idTorneo);
        ?>
        <div class="body-text">
            <h1 class="">Editar Equipo</h1>
            <p class="text-desert"><b>Editar Equipo</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
               <a href="../grupo/infoGrupo.php?idTorneo=<?= $equipo['idTorneo'] ?>&idGrupo=<?= $equipo['idGrupo'] ?>" 
                    class="btn button-terracota"><i class="fa-solid fa-angle-left"></i> Ver Equipos</a>
            </div>

                <div class="py-4">
                    <div class="form-block">
                        <form action="updateEquipo.php" method="POST" enctype="multipart/form-data">
                    
                            <div class="row mb-4">
                                <div class="col-md-6 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Equipo</span>
                                    <input type="text" class="form-control" id="vNombreEquipo" 
                                            value="<?= $equipo['vNombreEquipo']?>" name="vNombreEquipo"required/>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Foto del Equipo</span>
                                    <input type="file" class="form-control" name="vImgEquipo" id="vImgEquipo" 
                                            placeholder="Agregar Foto"
                                            accept="image/png, image/jpeg, image/jpg">                                
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font">Nombre Imagen</span>
                                    <input type="text" class="form-control" value="<?= $equipo['vImgEquipo']?>" readonly>
                                    <input type="hidden" name="imagen_actual" value="<?= $equipo['vImgEquipo'] ?>">
                                </div>                                                                
                            </div>

                             <div class="row mb-4">
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Capitan</span>
                                    <input type="text" class="form-control" id="vNombreCapitan" 
                                            value="<?= $equipo['vNombreCapitan']?>" name="vNombreCapitan"required/>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Correo del Capitan</span>
                                    <input type="email" class="form-control" id="vCorreoCapitan" 
                                            value="<?= $equipo['vCorreoCapitan']?>" name="vCorreoCapitan"required/>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Celular del Capitan</span>
                                    <input type="text" class="form-control" 
                                            value="<?= $equipo['vCelularCapitan']?>" id="vCelularCapitan" name="vCelularCapitan"
                                            title="Por favor, introduce un número de 10 dígitos." 
                                            maxlength="10" 
                                            pattern="[0-9]{10}"
                                            required/>
                                </div>
                                                              
                            </div>

                            <div class="d-flex flex-column flex-sm-row">
                                <input  type="hidden" name="idTorneo" value="<?= $equipo['idTorneo']?>">
                                <input  type="hidden" name="idGrupo" value="<?= $equipo['idGrupo']?>">
                                <input  type="hidden" name="idEquipo" value="<?= $equipo['idEquipo']?>">
                                <input  type="submit" class="btn button-terracota" value="Actualizar Equipo">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>