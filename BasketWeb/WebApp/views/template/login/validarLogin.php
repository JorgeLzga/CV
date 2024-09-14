<?php
    /* La declaración `require_once` se utiliza para incluir y evaluar el archivo especificado durante
    la ejecución del script. En este caso, incluye el archivo `LoginController.php` del directorio
    `controllers`, que se encuentra dos niveles por encima del directorio actual. Esto permite que
    el script acceda a la clase y funciones definidas en `LoginController.php`. */
    require_once("../../../controllers/LoginController.php");

   /* El código recupera los valores de `vUsuario` y `vContrasena` de la matriz superglobal ``,
   que contiene datos enviados a través de una solicitud HTTP POST. */

    $vUsuario = htmlspecialchars($_POST['vUsuario'] ?? '');
    $vContrasena = htmlspecialchars($_POST['vContrasena'] ?? '');

    $objLoginController = new LoginController();
    $objLoginController->ingresarUsuario($vUsuario, $vContrasena);

?>
