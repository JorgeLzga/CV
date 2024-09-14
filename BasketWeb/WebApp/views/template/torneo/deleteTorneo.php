<?php 
	/* La línea `require_once("../../../controllers/TorneosController.php");` incluye el archivo
   `TorneosController.php` en el script PHP actual. Esto permite que el script acceda a las clases y
   funciones definidas en el archivo `TorneosController.php`. */
    require_once("../../../controllers/TorneosController.php");
	/* El código crea una instancia de la clase `torneosController` y llama a su método `delete`, pasando
	el valor del parámetro `idTorneo` del superglobal `` como argumento. Es probable que esto se
	utilice para eliminar un registro de torneo específico de una base de datos o realizar alguna otra
	acción relacionada con la eliminación de un torneo. */
	$objTorneosController = new torneosController();
	$objTorneosController->delete($_GET['idTorneo']);

?>