<?php 
    /*Ruta que incluye el archivo `EquiposController.php` para acceder a la clase `EquiposController`.*/
    require_once("../../../controllers/EquiposController.php");

    /*Crea una instancia de `EquiposController` para actualizar la información del equipo.*/
    $ObjController = new EquiposController();

    /*Recupera valores del array $_POST y $_FILES para la actualización de información del equipo.*/
    $idEquipo = $_POST['idEquipo'];
    $vNombreEquipo = $_POST['vNombreEquipo'];
    $vImgEquipo = $_FILES['vImgEquipo'];
    $vNombreCapitan = $_POST['vNombreCapitan'];
    $vCorreoCapitan = $_POST['vCorreoCapitan'];
    $vCelularCapitan = $_POST['vCelularCapitan'];
    $idGrupo = isset($_POST['idGrupo']) ? $_POST['idGrupo'] : null;
    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;
    $imagen_actual = $_POST['imagen_actual']; 

    /*Establece la ruta de destino para la imagen del equipo.*/
    $targetDir = "../../assets/imgEquipo/";

    /*Verifica si se ha proporcionado una nueva imagen para actualizar.*/
    if (!empty($vImgEquipo['name'])) {

        $nombreArchivo = basename($vImgEquipo['name']);
        $targetFile = $targetDir . $nombreArchivo;

         /*Mueve el nuevo archivo cargado a la ubicación de destino y actualiza 
         la información del equipo.*/
        if (move_uploaded_file($vImgEquipo['tmp_name'], $targetFile)) {
            $ObjController->updateEquipo(
                                            $idEquipo,
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

    } else {
         
    /*Si no se proporciona una nueva imagen, utiliza la imagen actual.*/
    $nombreArchivo = $imagen_actual;
    
    /*Actualiza la información del equipo*/
    $ObjController->updateEquipo(
                                $idEquipo,
                                $vNombreEquipo, 
                                $nombreArchivo,
                                $vNombreCapitan,
                                $vCorreoCapitan,
                                $vCelularCapitan,
                                $idGrupo,
                                $idTorneo
                                );
    }
?>

