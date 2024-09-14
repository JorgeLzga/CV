
<?php 
    /* La línea `require_once("../../../controllers/PerfilController.php");` incluye el archivo
    `PerfilController.php` en el script PHP actual. Esto permite que el script acceda a las clases y
    funciones definidas en el archivo `PerfilController.php`. */
    require_once("../../../controllers/PerfilController.php");

    /* El código crea una instancia de la clase `PerfilController` y la asigna a la variable
    ``. */

    $ObjController = new PerfilController();

    $idTorneo = isset($_POST['idTorneo']) ? $_POST['idTorneo'] : null;
    $vUsuarioOrganizador = $_POST['vUsuarioOrganizador'];
    $vContrasenaOrganizador = $_POST['vContrasenaOrganizador'];

    /* El código está llamando al método `actualizarPerfil()` del objeto ``. Este método
     probablemente esté definido en la clase `PerfilController` y es responsable de actualizar la
     información del perfil con los parámetros proporcionados: ``, `` y
     ``. */
     $ObjController->actualizarPerfil(
                                 $idTorneo,
                                 $vUsuarioOrganizador,
                                 $vContrasenaOrganizador);
?>

