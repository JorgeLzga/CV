<?php 
    /*Ruta que incluye el archivo `CalendarioController.php` para acceder a la clase ç
    `CalendarioController`.*/
    include_once("../../../controllers/CalendarioController.php");

    /*Recupera valores del array $_GET para realizar la eliminación de un evento en un 
    calendario y torneo específicos.*/
    $idCalendario = $_GET['idCalendario'];
    $idTorneo = $_GET['idTorneo'];

    /*Crea una instancia de `CalendarioController` y utiliza el método `delete` 
    para eliminar el evento en el calendario y torneo indicados.*/
    $objCalendarioController = new CalendarioController();
    $objCalendarioController->delete($idCalendario, $idTorneo);
?>