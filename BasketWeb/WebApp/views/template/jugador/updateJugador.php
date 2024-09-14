<?php 
    /* La declaración `require_once` se utiliza para incluir y evaluar el archivo especificado durante
    la ejecución del script. En este caso, incluye el archivo `JugadoresController.php` del
    directorio `controllers`, que contiene el código necesario para manejar las operaciones
    relacionadas con el reproductor. */
    require_once("../../../controllers/JugadoresController.php");

   /* En este código, ` = new JugadoresController();` crea una nueva instancia de la
   clase `JugadoresController`. Esto le permite acceder a los métodos y propiedades definidos en esa
   clase. */
    $ObjController = new JugadoresController();

    $idJugador = $_POST['idJugador'];

    /* Estas líneas de código recuperan los valores de las entradas del formulario y del campo de carga
    de archivos en el formulario HTML. */
    $vNombreJugador = $_POST['vNombreJugador'];
    $vApellidoJugador = $_POST['vApellidoJugador'];
    $vFechaNacimiento = $_POST['vFechaNacimiento'];
    $vCorreoJugador = $_POST['vCorreoJugador'];
    $vCelularJugador = $_POST['vCelularJugador'];
    $vTipoSangre = $_POST['vTipoSangre'];
    $vContactoEmergencia = $_POST['vContactoEmergencia'];
    $vImgJugador = $_FILES['vImgJugador'];
    $idGrupo = isset($_POST['idGrupo']) ? $_POST['idGrupo'] : null;
    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;
    $idEquipo = isset($_POST['idEquipo']) ? $_POST['idEquipo'] : null;
    
    $imagen_actual = $_POST['imagen_actual']; 

    $targetDir = "../../assets/imgJugador/";

    /* Este bloque de código verifica si el campo `nombre` de la entrada del archivo `vImgJugador` no
    está vacío. Si no está vacío, asigna el nombre base del archivo subido a la variable
    `` y lo concatena con el directorio `` para crear la ruta al archivo de
    destino. */
    if (!empty($vImgJugador['name'])) {

        $nombreArchivo = basename($vImgJugador['name']);
        $targetFile = $targetDir . $nombreArchivo;

        
        /* Este bloque de código verifica si el archivo cargado en el campo `vImgJugador` del
        formulario se movió exitosamente al directorio de destino usando la función
        `move_uploaded_file()`. Si el archivo se movió exitosamente, llama al método
        `updateJugador()` del objeto `` con los parámetros proporcionados. Este método
        se encarga de actualizar la información del jugador en la base de datos. */
        if (move_uploaded_file($vImgJugador['tmp_name'], $targetFile)) {
            $ObjController->updateJugador(
                                            $idJugador,
                                            $vNombreJugador, 
                                            $vApellidoJugador,
                                            $vFechaNacimiento,
                                            $vCorreoJugador,
                                            $vCelularJugador,
                                            $vTipoSangre,
                                            $vContactoEmergencia,
                                            $nombreArchivo,
                                            $idGrupo,
                                            $idTorneo,
                                            $idEquipo
                                        );
        } else {
            
            echo "Hubo un problema al subir el archivo.";
        }

    } else {

   /* La línea `  = ;` está asignando el valor de la variable
   `` a la variable ``. Esto se hace para garantizar que, si el usuario
   no carga una nueva imagen, el nombre del archivo de la imagen existente se conserve y se utilice
   en la operación de actualización. */
    $nombreArchivo = $imagen_actual;
    
    /* El código `->updateJugador(...)` está llamando al método `updateJugador` del
    objeto ``. Este método se encarga de actualizar la información del jugador en la
    base de datos. */
    $ObjController->updateJugador(
                                    $idJugador,
                                    $vNombreJugador, 
                                    $vApellidoJugador,
                                    $vFechaNacimiento,
                                    $vCorreoJugador,
                                    $vCelularJugador,
                                    $vTipoSangre,
                                    $vContactoEmergencia,
                                    $nombreArchivo,
                                    $idGrupo,
                                    $idTorneo,
                                    $idEquipo
                                );
    
    }
?>

