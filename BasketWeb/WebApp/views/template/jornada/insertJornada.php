<?php
require_once("../../../controllers/JornadaController.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['jugadores']) && is_array($_POST['jugadores'])) {

        $ObjController = new jornadaController();

        if (isset($_POST['ganadorDefault'])) {

            $ganadorDefault = $_POST['ganadorDefault'];
            $fechaSeleccionada = $_POST['fechaSeleccionada'];
            $arrayValues = explode(',', $ganadorDefault);

            if (count($arrayValues) >= 3) {
                list($idEquipo, $idCalendario, $idTorneo) = $arrayValues;
                
                $fechaSeleccionada = $_POST['fechaSeleccionada'];
                $vPuntosDefault = isset($_POST['vPuntosDefault']) ? $_POST['vPuntosDefault'] : 1;

                
                // Insertar datos por default
                $resultDefault = $ObjController->insertarJornadaDefault(
                    $fechaSeleccionada,
                    $vPuntosDefault,
                    $idEquipo,
                    $idCalendario,
                    $idTorneo
                );

            } else { echo "Error: Datos incompletos para el ganador por default."; }

        } elseif (isset($_POST['ganadorPorDefault'])) {

            $ganadorPorDefault = $_POST['ganadorPorDefault'];
            $fechaSeleccionada = $_POST['fechaSeleccionada'];

            $arrayValues = explode(',', $ganadorPorDefault);

            if (count($arrayValues) >= 3) {

                list($idEquipo, $idCalendario, $idTorneo) = $arrayValues;
                    
                $vPuntosDefault = isset($_POST['vPuntosDefault']) ? $_POST['vPuntosDefault'] : 0;
        
                // Insertar datos por default
                $resultDefault = $ObjController->insertarJornadaDefault(
                $fechaSeleccionada,
                $vPuntosDefault,
                $idEquipo,
                $idCalendario,
                $idTorneo
                );

                   
            } else { echo "Error: Datos incompletos para el ganador por default."; }

        } else {

            foreach ($_POST['jugadores'] as $equipo => $jugadoresEquipo) {

                foreach ($jugadoresEquipo as $index => $jugador) {
                    $vPuntosTotal = (int)$jugador['vPuntosTotal'];
                    $vTirosde3 = (int)$jugador['vTirosde3'];
                    $vFaltas = (int)$jugador['vFaltas'];
                    $idEquipo = (int)$jugador['idEquipo'];
                    $idJugador = (int)$jugador['idJugador'];
                    $idCalendario = (int)$jugador['idCalendario'];
                    $idTorneo = (int)$jugador['idTorneo'];
                    $fechaSeleccionada = $_POST['fechaSeleccionada'];

                    // Insertar en la base de datos
                    $result = $ObjController->insertarJornada(
                        $fechaSeleccionada,
                        $vPuntosTotal,
                        $vTirosde3,
                        $vFaltas,
                        $idEquipo,
                        $idJugador,
                        $idCalendario,
                        $idTorneo
                    );

                    if ($result) {
                        echo "Datos insertados correctamente para el equipo $equipo.";
                    } else {
                        echo "Error al insertar datos para el equipo $equipo.";
                    }
                }
            }
        }
    } else {
        echo "No se han recibido datos de jugadores.";
    }
} else {
    echo "Acceso inválido al archivo.";
}



// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     if (isset($_POST['ganadorDefault'])) {
//         $ganadorDefault = $_POST['ganadorDefault'];

//         $arrayValues = explode(',', $ganadorDefault);

//         if (count($arrayValues) >= 3) {
//             list($idEquipo, $idCalendario, $idTorneo) = $arrayValues;
            
//             $vPuntosDefualt = isset($_POST['vPuntosDefualt']) ? $_POST['vPuntosDefualt'] : 0;

//             echo "Ganador por Default: PuntosDefualt: $vPuntosDefualt, ID Equipo: $idEquipo, ID Calendario: $idCalendario, ID Torneo: $idTorneo<br>";
//         } else {
//             echo "Error: Datos incompletos para el ganador por default.";
//         }
//     } elseif (isset($_POST['ganadorPorDefault'])) {
//         $ganadorPorDefault = $_POST['ganadorPorDefault'];

//         $arrayValues = explode(',', $ganadorPorDefault);

//         if (count($arrayValues) >= 3) {
//             list($idEquipo, $idCalendario, $idTorneo) = $arrayValues;
            
//             $vPuntosDefualt = isset($_POST['vPuntosDefualt']) ? $_POST['vPuntosDefualt'] : 0;

//             echo "Ganador por Default: PuntosDefualt: $vPuntosDefualt, ID Equipo: $idEquipo, ID Calendario: $idCalendario, ID Torneo: $idTorneo<br>";
//         } else {
//                 echo "Error: Datos incompletos para el ganador por default.";
//         }
//     }
    

//     // Verificar si se ha seleccionado un ganador por default para no mostrar los datos de los jugadores
//     if (!isset($_POST['ganadorDefault']) && !isset($_POST['ganadorPorDefault'])) {
//         if (isset($_POST['jugadores']) && is_array($_POST['jugadores'])) {
//             $jugadores = $_POST['jugadores'];

//             if (isset($jugadores['local']) && is_array($jugadores['local'])) {
//                 foreach ($jugadores['local'] as $index => $jugador_local) {
//                     echo "Jugador #" . ($index + 1) . ":<br>";
//                     echo "PuntosTotal: " . $jugador_local['vPuntosTotal'] . "<br>";
//                     echo "Tiros de 3: " . $jugador_local['vTirosde3'] . "<br>";
//                     echo "Faltas: " . $jugador_local['vFaltas'] . "<br>";
//                     echo "ID Equipo: " . $jugador_local['idEquipo'] . "<br>";
//                     echo "ID Jugador: " . $jugador_local['idJugador'] . "<br>";
//                     echo "ID Torneo: " . $jugador_local['idTorneo'] . "<br><br>";

//                 }
//             }

//             if (isset($jugadores['visitante']) && is_array($jugadores['visitante'])) {
//                 foreach ($jugadores['visitante'] as $index => $jugador_visitante) {
//                     echo "Jugador #" . ($index + 1) . ":<br>";
//                     echo "PuntosTotal: " . $jugador_visitante['vPuntosTotal'] . "<br>";
//                     echo "Tiros de 3: " . $jugador_visitante['vTirosde3'] . "<br>";
//                     echo "Faltas: " . $jugador_visitante['vFaltas'] . "<br>";
//                     echo "ID Equipo: " . $jugador_visitante['idEquipo'] . "<br>";
//                     echo "ID Jugador: " . $jugador_visitante['idJugador'] . "<br>";
//                     echo "ID idTorneo: " . $jugador_visitante['idTorneo'] . "<br><br>";

//                 }
//             }
//         } else {
//             echo "No se han recibido datos de los jugadores.";
//         }
//     }
// }

?>
