<?php
    /* La línea `require_once("../../../controllers/PatrocinadorController.php");` incluye el archivo
   `PatrocinadorController.php` del directorio `controllers`. Esto permite que el script PHP actual
   acceda a las funciones y clases definidas en el archivo `PatrocinadorController.php`. */
    require_once("../../../controllers/PatrocinadorController.php");

   /* El código recupera datos del envío de un formulario utilizando las variables superglobales
   `` y ``. */

    $vNombrePatrocinador = $_POST['vNombrePatrocinador'];
    $vImgPatrocinador = $_FILES['vImgPatrocinador'];
    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;

    $targetDir = "../../assets/imgPatrocinador/";
    $targetFile = $targetDir . basename($vImgPatrocinador['name']);
    /* Este bloque de código es responsable de manejar el archivo cargado. */
    if (move_uploaded_file($vImgPatrocinador['tmp_name'], $targetFile)) {
        $nombreArchivo = basename($vImgPatrocinador['name']);
        /* El código crea una nueva instancia de la clase `PatrocinadorController` y la asigna a la
        variable ``. Luego llama al método `insertarPatrocinador` sobre el objeto
        ``, pasando las variables ``, `` y
        `` como argumentos. */
        $ObjController = new patrocinadorController();
        $ObjController->insertarPatrocinador(
            $vNombrePatrocinador, 
            $nombreArchivo,
            $idTorneo);
            
    } else {
        echo "Hubo un problema al subir el archivo.";
    }
?>

