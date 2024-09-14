<?php
/* La línea `require_once("../../../controllers/GruposController.php");` incluye el archivo
`GruposController.php` del directorio `controllers`. Esto permite que el código acceda a las
funciones y clases definidas en ese archivo. */
    require_once("../../../controllers/GruposController.php");

/* El código está verificando si los valores de `['idGrupo']`, `['vNombreGrupo']`,
`['idCategoria']` y `['idTorneo']` están configurados . Si están configurados asigna sus
valores a las variables correspondientes (``, ``, ``, ``).
Si no están configurados, asigna "nulo" a las variables correspondientes. */
$idGrupo = isset($_POST['idGrupo']) ? $_POST['idGrupo'] : null;
$vNombreGrupo = $_POST['vNombreGrupo'];
$idCategoria = isset($_POST['idCategoria']) ? $_POST['idCategoria'] : null;
$idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;

    /* El código es crear una nueva instancia de la clase `gruposController` y asignarla a la variable
    ``. Luego, llama al método `updateGrupo` del objeto ``, pasando los
    valores de ``, ``, `` y `` como argumentos. Es
    probable que este método sea responsable de actualizar un grupo en el sistema, utilizando los
    valores proporcionados. */
    $ObjController = new gruposController();    
    $ObjController->updateGrupo(
                                $idGrupo,
                                $vNombreGrupo, 
                                $idCategoria,
                                $idTorneo
                                );
?>
