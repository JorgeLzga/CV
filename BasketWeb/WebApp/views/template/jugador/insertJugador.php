<?php
    /* La declaración `require_once` se utiliza para incluir y evaluar el archivo especificado durante
	la ejecución del script. En este caso, incluye el archivo `JugadoresController.php` del
	directorio `controllers`, que contiene el código necesario para manejar las operaciones
	relacionadas con el reproductor. */
	require_once("../../../controllers/JugadoresController.php");

   /* Estas líneas de código recuperan los valores enviados a través de un formulario utilizando el
   método POST. Cada valor se asigna a una variable correspondiente. */
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

	$targetDir = "../../assets/imgJugador/";
	$targetFile = $targetDir . basename($vImgJugador['name']);

	
	/* Este bloque de código verifica si el archivo cargado por el usuario se movió correctamente al
	directorio de destino. */
	if (move_uploaded_file($vImgJugador['tmp_name'], $targetFile)) {
	    $nombreArchivo = basename($vImgJugador['name']);
	
	   /* El código crea una instancia de la clase `JugadoresController` y llama a su método
	   `insertarJugadores`. */
	    $ObjController = new JugadoresController();
	    $ObjController->insertarJugadores(
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
	       $idEquipo);

	} else {
	    echo "Hubo un problema al subir el archivo.";
	}

?>	