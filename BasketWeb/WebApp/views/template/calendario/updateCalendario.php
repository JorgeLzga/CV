<?php
/*Ruta que incluye el archivo `CalendarioController.php` para acceder a la clase `CalendarioController`.*/
include_once("../../../controllers/CalendarioController.php");

/*Recupera valores del array $_POST para la actualización de un evento en el calendario.*/
$idCalendario = isset($_POST['idCalendario']) ? $_POST['idCalendario'] : null;
$vEqLocal = isset($_POST['vEqLocal']) ? $_POST['vEqLocal'] : null;
$vEqVisitante = isset($_POST['vEqVisitante']) ? $_POST['vEqVisitante'] : null;
$vHora = $_POST['vHora'];
$vFecha = $_POST['vFecha'];
$vSede = $_POST['vSede'];
$idCategoria = isset($_POST['idCategoria']) ? $_POST['idCategoria'] : null;
$vTipoJuego = isset($_POST['vTipoJuego']) ? $_POST['vTipoJuego'] : null;
$idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;

/*Crea una instancia de `CalendarioController` y utiliza el método `updateCalendario` 
para actualizar el evento en el calendario.*/
$ObjController = new CalendarioController();    

$ObjController->updateCalendario(
                                    $idCalendario,
                                    $vEqLocal, // ID del equipo seleccionado, no el nombre.
                                    $vEqVisitante, // ID del equipo visitante.
                                    $vHora,
                                    $vFecha,
                                    $vSede,
                                    $idCategoria,
                                    $vTipoJuego,
                                    $idTorneo
                                );
?>
