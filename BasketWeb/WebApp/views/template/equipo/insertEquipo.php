<?php
    /*Ruta que incluye el archivo `EquiposController.php` para acceder a la clase `EquiposController`.*/
    require_once("../../../controllers/EquiposController.php");

    /*Recupera valores del array $_POST y $_FILES para la inserción de información del equipo.*/
    $vNombreEquipo = $_POST['vNombreEquipo'];
    $vImgEquipo = $_FILES['vImgEquipo'];
    $vNombreCapitan = $_POST['vNombreCapitan'];
    $vCorreoCapitan = $_POST['vCorreoCapitan'];
    $vCelularCapitan = $_POST['vCelularCapitan'];
    $idGrupo = isset($_POST['idGrupo']) ? $_POST['idGrupo'] : null;
    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;

    /*Establece la ruta de destino y el nombre del archivo para la imagen del equipo.*/
    $targetDir = "../../assets/imgEquipo/";
    $targetFile = $targetDir . basename($vImgEquipo['name']);

    /*Mueve el archivo cargado a la ubicación de destino y verifica si la operación fue exitosa.*/
    if (move_uploaded_file($vImgEquipo['tmp_name'], $targetFile)) {
        $nombreArchivo = basename($vImgEquipo['name']);

        /*Crea una instancia de `EquiposController` para insertar la información del equipo 
        en la base de datos.*/
        $ObjController = new equiposController();
        $ObjController->insertarEquipo(
                                            $vNombreEquipo, 
                                            $nombreArchivo,
                                            $vNombreCapitan,
                                            $vCorreoCapitan,
                                            $vCelularCapitan,
                                            $idGrupo,
                                            $idTorneo
                                        );
            
    } else {
        echo "Hubo un problema al subir el archivo.";
    }
?>

