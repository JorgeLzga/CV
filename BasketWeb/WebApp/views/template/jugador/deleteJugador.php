<?php 
/* La declaración `require_once` se utiliza para incluir y evaluar el archivo especificado durante la
ejecución del script. En este caso se incluye el archivo `JugadoresController.php` del directorio
`controllers`, que contiene la definición de la clase `JugadoresController`. Esto permite que el
script utilice los métodos y propiedades definidos en esa clase. */
    require_once("../../../controllers/JugadoresController.php");
    
   /* Estas líneas de código recuperan los valores de las variables `idJugador`, `idGrupo`, `idTorneo`
   e `idEquipo` de la cadena de consulta URL usando la matriz superglobal ``. */
    $idJugador = $_GET['idJugador'];
    $idGrupo = $_GET['idGrupo']; 
    $idTorneo = $_GET['idTorneo']; 
    $idEquipo = $_GET['idEquipo']; 

    /* El código crea una instancia de la clase `JugadoresController` y llama a su método `delete` con
    los parámetros ``, ``, `` y ``. Es probable que esto se
    utilice para eliminar a un jugador de un equipo, grupo y torneo específico. */
    $objJugadorController = new JugadoresController();
    $objJugadorController->delete($idJugador,$idEquipo, $idGrupo, $idTorneo);
?>
