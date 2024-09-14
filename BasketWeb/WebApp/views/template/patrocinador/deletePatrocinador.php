<?php 
	 /* La declaración `require_once` se utiliza para incluir y evaluar el archivo especificado durante
	la ejecución del script. En este caso se incluye el archivo `PatrocinadorController.php` del
	directorio `controllers`, que contiene la definición de la clase `PatrocinadorController`. */
    require_once("../../../controllers/PatrocinadorController.php");

    /* El código crea una instancia de la clase `PatrocinadorController` y llama a su método `delete`. Al
	método `delete` se le pasa el valor del parámetro `idPatrocinador` de la matriz superglobal
	``. Es probable que este código se utilice para eliminar un registro específico de la base de
	datos según el valor "idPatrocinador" proporcionado. */
	
	$objPatrocinadorController = new patrocinadorController();
	$objPatrocinadorController->delete($_GET['idPatrocinador']);

?>