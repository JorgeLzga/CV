<?php
    require_once("../../../controllers/JornadaController.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['jugadores']) && is_array($_POST['jugadores'])) {
        $ObjController = new jornadaController(); 

        foreach ($_POST['jugadores'] as $index => $jugador) {
            $idHistoriCoJugador = $jugador['idHistoriCoJugador'];
            $vPuntosTotal = $jugador['vPuntosTotal'];
            $vTirosde3 = $jugador['vTirosde3'];
            $vFaltas = $jugador['vFaltas'];
            $idEquipo = $jugador['idEquipo'];
            $idJugador = $jugador['idJugador'];
            $idCalendario = $jugador['idCalendario'];
            $idTorneo = $jugador['idTorneo'];
            $fechaSeleccionada = $_POST['fechaSeleccionada'];

            $ObjController->updateJornada(
                $fechaSeleccionada,
                $idHistoriCoJugador,
                $vPuntosTotal,
                $vTirosde3,
                $vFaltas,
                $idEquipo,
                $idJugador,
                $idCalendario,
                $idTorneo
            );
        }
    } else {
        echo "No se han recibido datos de jugadores.";
    }
} else {
    echo "Acceso inválido al archivo.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['jugadores']) && is_array($_POST['jugadores'])) {
    foreach ($_POST['jugadores'] as $index => $jugador) {
        // Imprimir todas las variables del jugador
        echo "Jugador #" . ($index + 1) . ":<br>";
        echo "Puntos Totales: " . $jugador['vPuntosTotal'] . "<br>";
        echo "Tiros de 3: " . $jugador['vTirosde3'] . "<br>";
        echo "Faltas: " . $jugador['vFaltas'] . "<br>";
        echo "ID Torneo: " . $jugador['idTorneo'] . "<br>";
        echo "ID Calendario: " . $jugador['idCalendario'] . "<br>";
        echo "ID Equipo: " . $jugador['idEquipo'] . "<br>";
        echo "ID Jugador: " . $jugador['idJugador'] . "<br>";
        echo "<br>";
    }
} else {
    echo "No se han recibido datos de jugadores.";
}
?>
