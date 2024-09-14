<?php
    /* El código maneja el envío del formulario y carga un archivo de imagen en un directorio
	específico. */
	require_once("../../../controllers/TorneosController.php");
		 /* Estas líneas de código recuperan los valores enviados a través de un formulario utilizando el
	  método POST. */
    $vNombreTorneo = $_POST['vNombreTorneo'];
    $vImagenTorneo = $_FILES['vImagenTorneo'];
    $vSedeTorneo = $_POST['vSedeTorneo'];
    $vPremio01 = $_POST['vPremio01'];
    $vPremio02 = $_POST['vPremio02'];
    $vPremio03 = $_POST['vPremio03'];
    $vOtroPremio = $_POST['vOtroPremio'];
    $vNombreOrganizador = $_POST['vNombreOrganizador'];
    $vUsuarioOrganizador = $_POST['vUsuarioOrganizador'];
    $vContrasenaOrganizador = $_POST['vContrasenaOrganizador'];

	$targetDir = "../../assets/image/";
	$targetFile = $targetDir . basename($vImagenTorneo['name']);
	/* Este bloque de código verifica si el archivo se cargó exitosamente en el servidor usando la función
	`move_uploaded_file()`. Si el archivo se cargó exitosamente, recupera el nombre del archivo cargado
	usando `basename(['name'])` y lo asigna a la variable ``. */
	if (move_uploaded_file($vImagenTorneo['tmp_name'], $targetFile)) {
	    $nombreArchivo = basename($vImagenTorneo['name']);

	    $ObjController = new torneosController();
	    $ObjController->insertarTorneo(
	        $vNombreTorneo, 
	        $nombreArchivo, 
	        $vSedeTorneo, 
	        $vPremio01, 
	        $vPremio02, 
	        $vPremio03, 
	        $vOtroPremio,
	        $vNombreOrganizador, 
	        $vUsuarioOrganizador, 
	        $vContrasenaOrganizador);

	} else {
	    echo "Hubo un problema al subir el archivo.";
	}

?>
