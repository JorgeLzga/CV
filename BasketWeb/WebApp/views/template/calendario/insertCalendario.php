<?php
    /*Ruta que incluye el archivo `CalendarioController.php` para acceder a la clase 
    `CalendarioController`.*/
    require_once("../../../controllers/CalendarioController.php");

    /*Recupera valores del array $_POST para la inserción de un nuevo evento en el calendario.*/
    $vEqLocal = $_POST['vEqLocal'];
    $vEqVisitante = $_POST['vEqVisitante'];
    $vFecha = $_POST['vFecha'];
    $vHora = $_POST['vHora'];
    $vSede = $_POST['vSede'];
    $idCategoria = isset($_POST['idCategoria']) ? $_POST['idCategoria'] : null;
    $vTipoJuego = $_POST['vTipoJuego'];
    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;

        /*Crea una instancia de `CalendarioController` y utiliza el método `insertarCalendario` 
        para agregar el nuevo evento al calendario.*/
        $ObjController = new CalendarioController();
        $ObjController->insertarCalendario(
                                            $vEqLocal,
                                            $vEqVisitante,
                                            $vFecha,
                                            $vHora,
                                            $vSede, 
                                            $idCategoria,
                                            $vTipoJuego,
                                            $idTorneo
                                        );

?>

