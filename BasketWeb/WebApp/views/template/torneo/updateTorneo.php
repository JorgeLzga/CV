<?php 
    require_once("../../../controllers/TorneosController.php");
    
    /* El código inicializa variables y recupera datos de las entradas del formulario y la carga de
        archivos. */
    $ObjController = new torneosController();

    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;
    $vNombreTorneo = $_POST['vNombreTorneo'];
    $vImagenTorneo = $_FILES['vImagenTorneo'];
    $vSedeTorneo = $_POST['vSedeTorneo'];
    $vPremio01 = $_POST['vPremio01'];
    $vPremio02 = $_POST['vPremio02'];
    $vPremio03 = $_POST['vPremio03'];
    $vOtroPremio = $_POST['vOtroPremio'];
    $vNombreOrganizador = $_POST['vNombreOrganizador'];
    $vUsuarioOrganizador = $_POST['vUsuarioOrganizador'];
    $imagen_actual = $_POST['imagen_actual']; 

    $targetDir = "../../assets/image/";
    /* Este bloque de código verifica si se ha cargado un nuevo archivo de imagen. Si el campo `nombre`
   de la entrada del archivo `vImagenTorneo` no está vacío, significa que se ha seleccionado un
   nuevo archivo. */
    if (!empty($vImagenTorneo['name'])) {

        $nombreArchivo = basename($vImagenTorneo['name']);
        $targetFile = $targetDir . $nombreArchivo;

        if (move_uploaded_file($vImagenTorneo['tmp_name'], $targetFile)) {
            $ObjController->updateTorneo(
                                 $idTorneo,
                                 $vNombreTorneo,
                                 $nombreArchivo,
                                 $vSedeTorneo,
                                 $vPremio01,
                                 $vPremio02,
                                 $vPremio03,
                                 $vOtroPremio,
                                 $vNombreOrganizador,
                                 $vUsuarioOrganizador
            );

        } else {
            
            echo "Hubo un problema al subir el archivo.";
        }

    } else {

    $nombreArchivo = $imagen_actual;
    /* El código actualiza un registro de torneo en una base de datos. */
    $ObjController->updateTorneo(
                                 $idTorneo,
                                 $vNombreTorneo,
                                 $nombreArchivo,
                                 $vSedeTorneo,
                                 $vPremio01,
                                 $vPremio02,
                                 $vPremio03,
                                 $vOtroPremio,
                                 $vNombreOrganizador,
                                 $vUsuarioOrganizador
                             );
    }
?>

