<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perfiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require("../headerAdm.php") ?>
    <main>
        <div class="body-text">
            <?php

                if (session_status() == PHP_SESSION_NONE) { session_start(); }

                if (isset($_GET['success'])) {
                    
                    $success = $_GET['success'];
                    
                    if ($success === 'inserted') {

                        $_SESSION['success_message'] = '<a href="infoPerfil.php" class="text-decoration-none" style="color: #0A3622">
                                                        <i class="fa-solid fa-check"></i> El perfil se ha actualizado correctamente.</a>';
                      
                    }
                }

                if (isset($_SESSION['success_message'])) {

                    echo '<div class="alert alert-success text-center">' . $_SESSION['success_message']. '</div>';
                    unset($_SESSION['success_message']);

                }

                include_once(__DIR__ .'/../../../controllers/PerfilController.php');

                $objPerfilControllador = new PerfilController();
                $datosPerfil = $objPerfilControllador->obtenerPerfil();

            ?>
            <h1 class="">Lista Perfiles</h1>
            <p class="text-desert"><b>Lista perfiles</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="../panelControl.php" class="btn button-terracota mb-2 mb-sm-0 mr-sm-2 mx-2"><i class="fa-solid fa-house"></i> Regresar al Panel</a>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-5 m-3 justify-content-center">
                <?php foreach ($datosPerfil as $perfil): ?>
                    <div class="col">
                        <center>
                            <div class="text-decoration-none text-reset">
                                <div class="card h-100 shadow border-0 elevate-card rounded-top" id="elevating-card1">
                                    <div class="border-0 card-img-top">
                                        <img src="../../assets/image/<?= $perfil['vImagenTorneo']?>" alt="Imagen del Equipo" class="card-img img-fluid custom-img">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title text-desert"><b><?php echo $perfil['vNombreOrganizador']; ?></b></h5>
                                        <h6 class="text-desert"><Inf></Inf><?php echo $perfil['vUsuarioOrganizador']; ?></h6>
                                        <div class="horizontal-line-card"></div>
                                    </div>
                                    <div class="card-footer border-0">
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                <a href="frmEditPerfil.php?idTorneo=<?= $perfil['idTorneo'] ?>" title="Editar Torneo" >
                                                    <i class="fa-solid fa-pen-to-square size-icon text-desert"></i>
                                                </a>
                                            </td>
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
    <?php require("../footer.php") ?>
</body>
</html>|