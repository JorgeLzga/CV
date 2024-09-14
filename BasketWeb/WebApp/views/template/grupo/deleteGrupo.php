<?php 
    /* La declaración `require_once` se utiliza para incluir y evaluar el archivo especificado durante la
    ejecución del script. En este caso se incluye el archivo `GruposController.php` del directorio
    `controllers`, que contiene la definición de la clase `GruposController`. Esto permite que el script
    acceda y utilice los métodos y propiedades definidos en esa clase. */
    require_once("../../../controllers/GruposController.php");
    
    /* El código recupera los valores de las variables `idGrupo` e `idTorneo` del array superglobal
    ``. */
    $idGrupo = $_GET['idGrupo']; 
    $idTorneo = $_GET['idTorneo']; 

    /*Se instancia un objeto de la clase `GruposController`. Esta clase encapsula la lógica relacionada con la
    manipulación de grupos en el sistema. La instancia creada, `$objGrupoController`, se utiliza para invocar el
    método `delete` que se encarga de eliminar el grupo específico en el contexto del torneo dado.
    */
    $objGrupoController = new GruposController();
    $objGrupoController->delete($idGrupo, $idTorneo);
?>
