<?php
/* La línea `require_once("../../../controllers/GruposController.php");` incluye el archivo
`GruposController.php` en el script PHP actual. Esto permite que el script acceda a las clases y
funciones definidas en el archivo `GruposController.php`. */
    require_once("../../../controllers/GruposController.php");

    /* El código recupera valores de la matriz superglobal ``. */
    $vNombreGrupo = $_POST['vNombreGrupo'];
    $idCategoria = isset($_POST['idCategoria']) ? $_POST['idCategoria'] : null;
    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;

        /* El código es crear una nueva instancia de la clase `gruposController` y asignarla a la
        variable ``. Luego, llama al método `insertarGrupos` sobre el objeto
        ``, pasando las variables ``, `` y `` como
        argumentos. Este método se encarga de insertar un nuevo grupo en la base de datos,
        utilizando los valores proporcionados. */
        $ObjController = new gruposController();
        $ObjController->insertarGrupos(
            $vNombreGrupo, 
            $idCategoria,
            $idTorneo);

?>

