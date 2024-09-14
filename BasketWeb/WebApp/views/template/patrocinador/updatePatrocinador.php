<?php 
    /* La línea `require_once("../../../controllers/PatrocinadorController.php");` incluye el archivo
    `PatrocinadorController.php` en el script PHP actual. Es probable que este archivo contenga la
    definición de la clase `PatrocinadorController` y cualquier función o método relacionado que sea
    necesario para que el script se ejecute correctamente. Al incluir este archivo, el script puede
    acceder y utilizar la funcionalidad proporcionada por la clase `PatrocinadorController`. */
    require_once("../../../controllers/PatrocinadorController.php");
    /* El código crea una nueva instancia de la clase `PatrocinadorController` y las asigna a las
    variables ``. */

    $ObjController = new PatrocinadorController();

    $idPatrocinador = $_POST['idPatrocinador'];
    $vNombrePatrocinador = $_POST['vNombrePatrocinador'];
    $vImgPatrocinador = $_FILES['vImgPatrocinador'];
    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;
    $imagen_actual = $_POST['imagen_actual'];

    $targetDir = "../../assets/imgPatrocinador/";
    /* Este bloque de código verifica si la variable `vImgPatrocinador` no está vacía. Si no está vacío,
   procede a subir el archivo al directorio especificado y luego llama al método
   `updatePatrocinador` del objeto `PatrocinadorController`, pasando los parámetros necesarios. Si
   hay algún problema con la carga del archivo, muestra un mensaje de error. Si la variable
   `vImgPatrocinador` está vacía, llama al método `updatePatrocinador` con el nombre del archivo de
   imagen existente. */
    if (!empty($vImgPatrocinador['name'])) {

        $nombreArchivo = basename($vImgPatrocinador['name']);
        $targetFile = $targetDir . $nombreArchivo;

        if (move_uploaded_file($vImgPatrocinador['tmp_name'], $targetFile)) {
            $ObjController->updatePatrocinador(
                $idPatrocinador,
                $vNombrePatrocinador,
                $nombreArchivo,
                $idTorneo
            );
        } else {
            
            echo "Hubo un problema al subir el archivo.";
        }

    } else {
        /* El código llama al método `updatePatrocinador` del objeto ``. Este método
       probablemente esté definido en la clase `PatrocinadorController` y es responsable de
       actualizar un registro de patrocinador (patrocinador) en una base de datos o realizar alguna
       otra acción relacionada con la actualización de un patrocinador. */
        $ObjController->updatePatrocinador(
            $idPatrocinador,
            $vNombrePatrocinador,
            $imagen_actual,
            $idTorneo
        );
    }
?>
