<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Informacion Grupo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

    <?php require("../../template/header.php") ?>
    <main>
        <div class="body-text">
            <?php
                require_once("../../../controllers/CategoriasController.php");
                require_once("../../../controllers/TorneosController.php");
                require_once("../../../controllers/GruposController.php");
                require_once("../../../Controllers/EquiposController.php");

                $objTorneosControllador = new torneosController();
                $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

                $idGrupo = $_GET['idGrupo']; 
                $idTorneo = $_GET['idTorneo']; 

                $objGruposController = new GruposController();
                $grupo = $objGruposController->selectOneGrupo($idGrupo, $idTorneo);

                $objCategoriasController = new CategoriasController();
                $categorias = $objCategoriasController->selectAllCategorias();
                $idCategoria = $objCategoriasController->selectOneCategoria($idGrupo, $idTorneo);

                $objEquiposController = new EquiposController();
                $equipo = $objEquiposController->selectOneEquipo($idGrupo, $idTorneo);


                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                    if (isset($_GET['success'])) {
                        
                        $success = $_GET['success'];
                        
                        if ($success === 'inserted') {

                          $_SESSION['success_message'] = '<a href="infoGrupo.php?idTorneo=' . $grupo['idTorneo'] . '&idGrupo=' . $grupo['idGrupo'] . '" class="text-decoration-none" style="color: #0A3622"><i class="fa-solid fa-check">
                                                            </i> El equipo se ha insertado correctamente.</a>';

                        } elseif ($success === 'updated') {

                            $_SESSION['success_message'] = '<a href="infoGrupo.php?idTorneo=' . $grupo['idTorneo'] . '&idGrupo=' . $grupo['idGrupo'] . '" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El equipo se ha actualizado correctamente.</a>';

                        } elseif ($success === 'deleted') {

                            $_SESSION['success_message'] = '<a href="infoGrupo.php?idTorneo=' . $grupo['idTorneo'] . '&idGrupo=' . $grupo['idGrupo'] . '" class="text-decoration-none" style="color: #0A3622">
                                                            <i class="fa-solid fa-check"></i> El equipo se ha eliminado correctamente.</a>';
                        }
                    }

                    if (isset($_SESSION['success_message'])) {

                        echo '<div class="alert alert-success text-center">' . $_SESSION['success_message']. '</div>';
                        unset($_SESSION['success_message']);

                    }
            ?>

            <h1 class="">Informacion del Grupo</h1>
            <p class="text-desert"><b>Informacion Grupo</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                
                <a href="lstGrupo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                    class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-angle-left"></i> Ver Grupos</a>

                <a href="../equipo/frmEquipo.php?idTorneo=<?= $grupo['idTorneo'] ?>&idGrupo=<?= $grupo['idGrupo'] ?>" 
                    class="btn button-desert mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-users"></i> Agregar Equipos</a>

                <a href="../torneo/infoTorneo.php?idTorneo=<?= $grupo['idTorneo'] ?>&idGrupo=<?= $grupo['idGrupo'] ?>" 
                    class="btn button-barron mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-house"></i> Ver Inicio</a>
            </div>
            
            <div class="row row-cols-1 row-cols-md g-4 m-4 justify-content-center">
                <div class="col">
                    <div class="card border-0 shadow">
                        <div class="row g-0">
                            <div class="col-md-4 rounded  img-fluid custom-img" style="background-image: url('../../assets/imgBg/Bg-Basket.jpg');height: 270px; background-size: cover;">
                                <!-- <img src="../../assets/imgBg/Bg-Basket.jpg" alt="Descripción de la imagen" class="card-img img-fluid"> -->
                            </div>
                            <div class="col-md-8 card-body p-5">
                                <h3 class="text-barron">Torneo: <?= $lstTorneo['vNombreTorneo'] ?></h3>
                                <h4 class="text-desert">Grupo: <?= $grupo['vNombreGrupo']?></h4>
                                <?php
                                    $categoriaSeleccionada = '';
                                    foreach ($categorias as $categoria) {
                                        if ($categoria['idCategoria'] === $idCategoria) {
                                            $categoriaSeleccionada = $categoria['vCategoria'];
                                            break;
                                        }
                                    }
                                ?>
                                <h6 class="text-desert">Categoría: <?php echo $categoriaSeleccionada; ?></h6><br>
                                <h6 class="text-barron">Lista de Equipos del Grupo</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-5 m-3 justify-content-center">
                <?php foreach ($equipo as $equipos): ?>
                <div class="col">
                    <center>
                        <div class="text-decoration-none text-reset">
                            <div class="card h-100 shadow border-0 elevate-card rounded-top" id="elevating-card1">
                                <div class="border-0 card-img-top">
                                    <img src="../../assets/imgEquipo/<?= $equipos['vImgEquipo']?>" alt="Imagen del Equipo" class="card-img img-fluid custom-img">
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title text-desert"><b><?= $equipos['vNombreEquipo']?></b></h5>
                                    <div class="text-barron"><?= $equipos['vNombreCapitan']?></div>
                                    <p><div class="horizontal-line-card"></div></p>
                                    <h6 class="text-desert"><Inf></Inf>Informacion de Contacto</h6>
                                    <div class="text-barron">
                                        <b>Correo: </b><?= $equipos['vCorreoCapitan']?><br>
                                        <b>Celular: </b><?= $equipos['vCelularCapitan']?>
                                    </div>
                                </div>
                                
                                <div class="card-footer border-0">
                                    <tr>
                                        <td style="vertical-align: middle;">
                                            <a href="../equipo/infoEquipo.php?idTorneo=<?= $equipos['idTorneo'] ?>&idGrupo=<?= $equipos['idGrupo']?>&idEquipo=<?= $equipos['idEquipo']?>" title="Ver Equipos">
                                                <i class="fa-solid fa-list-check size-icon text-desert"></i></a></td>&ensp;

                                        <td style="vertical-align: middle;">
                                            <a href="../equipo/frmEditEquipo.php?idTorneo=<?= $equipos['idTorneo'] ?>&idGrupo=<?= $equipos['idGrupo']?>&idEquipo=<?= $equipos['idEquipo']?>" title="Editar Equipo" >
                                                <i class="fa-solid fa-pen-to-square size-icon text-desert"></i></a></td>&ensp;

                                        <td style="vertical-align: middle;">
                                            <a href="../equipo/deleteEquipo.php?idTorneo=<?= $equipos['idTorneo'] ?>&idGrupo=<?= $equipos['idGrupo']?>&idEquipo=<?= $equipos['idEquipo']?>" title="Eliminar Equipo">
                                                <i class="fas fa-delete-left size-icon text-desert"></i></a></td>&ensp;
                                    </tr>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>