<?php 
    /*Ruta que incluye el archivo `EquiposController.php` para acceder a la clase `EquiposController`.*/
    require_once("../../../controllers/EquiposController.php");
    
    /*Recupera valores del array $_GET para realizar la eliminación de un equipo en un 
    grupo y torneo específicos.*/
    $idGrupo = $_GET['idGrupo']; 
    $idTorneo = $_GET['idTorneo']; 
    $idEquipo = $_GET['idEquipo']; 

    /*Crea una instancia de `EquiposController` y utiliza el método `delete` para 
    eliminar el equipo en el grupo y torneo indicados.*/
    $objGrupoController = new EquiposController();
    $objGrupoController->delete($idEquipo, $idGrupo, $idTorneo);
?>
