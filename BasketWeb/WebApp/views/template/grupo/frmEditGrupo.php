<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Editar Grupo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <script src="https://kit.fontawesome.com/614cbb4c2c.js" crossorigin="anonymous"></script>

</head>

    <?php
        require_once("../../../controllers/CategoriasController.php");
        require_once("../../../controllers/GruposController.php");
        require_once("../../../controllers/TorneosController.php");  

        $objTorneosControllador = new torneosController();
        $lstTorneo = $objTorneosControllador->selectOneTorneo($_GET['idTorneo']);

        $idGrupo = $_GET['idGrupo']; 
        $idTorneo = $_GET['idTorneo']; 

        $objGruposController = new GruposController();
        $grupo = $objGruposController->selectOneGrupo($idGrupo, $idTorneo);

        $objCategoriasController = new CategoriasController();
        $categorias = $objCategoriasController->selectAllCategorias();
        $idCategoria = $objCategoriasController->selectOneCategoria($idGrupo, $idTorneo);
    ?>

    <?php require("../../template/header.php") ?>
    <main>
        <div class="body-text">
            <h1 class="">Editar Grupo</h1>
            <p class="text-desert"><b>Editar Grupo</b></p>
            <div class="horizontal-line"></div>
            <div class="d-flex flex-column flex-sm-row">
                <a href="lstGrupo.php?idTorneo=<?= $lstTorneo['idTorneo']?>" 
                class="btn button-terracota"><i class="fa-solid fa-angle-left"></i> Ver Grupos</a>
            </div>

                <div class="py-4">
                    <div class="form-block">
                        <form action="updateGrupo.php" method="POST" enctype="multipart/form-data">
                            <div class="row mb-4">
                                <div class="col-md-8 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font" > Nombre del Grupo</span>
                                    <input type="text" class="form-control" id="vNombreGrupo" name="vNombreGrupo" value="<?= $grupo['vNombreGrupo'] ?>" required/>
                                </div>                                                            
                                
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <span class="help-block text-muted small-font">Seleccionar una Categoria</span>
                                    <select name="idCategoria" id="idCategoria" class="form-select" required>
                                        <?php foreach ($categorias as $categoria) : ?>
                                            <option value="<?= $categoria['idCategoria'] ?>" <?php if ($categoria['idCategoria'] == $idCategoria) echo 'selected' ?>>
                                                <?= $categoria['vCategoria'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <input type="hidden" name="idGrupo" value="<?= $grupo['idGrupo'] ?>">
                            <input type="hidden" name="idTorneo" value="<?= $lstTorneo['idTorneo'] ?>">
                            <div class="d-flex flex-column flex-sm-row">
                                <input  type="submit" class="btn button-terracota" value="Actualizar Grupo">
                            </div>
                        </form>

                    </div>
                </div>
        </div>
    </main>
    <?php require("../../template/footer.php")?>