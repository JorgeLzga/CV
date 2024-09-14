<?php
    include_once(__DIR__ . '/../config/dataBase.php');

	class UsuarioModel{

		public $PDO;

		public function __construct(){

			$vConexion = new DataBase();

			$this->PDO = $vConexion->getConexion();
		}

		/**
		 * La función "readOneEquipoUsuarioComplete" recupera un registro completo de un equipo y sus
		 * jugadores según el ID del torneo y el ID del equipo.
		 * 
		 * @param idTorneo El parámetro idTorneo es el ID del torneo al que pertenece el equipo. Se utiliza
		 * para filtrar la consulta y recuperar solo la información de los jugadores y del equipo que
		 * pertenecen a ese torneo específico.
		 * @param idEquipo El parámetro idEquipo es el identificador único del equipo del que desea recuperar
		 * información.
		 * 
		 * @return el resultado de la consulta ejecutada, que es la fila recuperada de la base de datos o
		 * falso si la consulta no fue exitosa.
		 */
		public function readOneEquipoUsuarioComplete($idTorneo,$idEquipo) {

		    $statement = $this->PDO->prepare("
										   		 SELECT j.*, e.* FROM tbljugadores j INNER JOIN tblequipos e ON j.idEquipo = e.idEquipo WHERE j.idTorneo = :idTorneo AND j.idEquipo = :idEquipo;
		    								");

		    $statement->bindParam(":idTorneo", $idTorneo);
   		    $statement->bindParam(":idEquipo", $idEquipo);


		    return ($statement->execute()) ? $statement->fetch() : false;
		}


		/**
		 * La función recupera estadísticas de un equipo específico en un torneo, incluido el número de veces
		 * jugadas, el número de victorias, el número de derrotas, los puntos anotados, los puntos en contra
		 * y la diferencia de puntos.
		 * 
		 * @param idTorneo El parámetro idTorneo es el ID del torneo del que deseas recuperar las
		 * estadísticas del equipo.
		 * @param idEquipo El parámetro idEquipo es el ID del equipo del que desea recuperar las
		 * estadísticas.
		 * 
		 * @return una matriz de matrices asociativas, donde cada matriz asociativa representa las
		 * estadísticas de un equipo en un torneo.
		 */
		public function allEstEquipoUsuario($idTorneo,$idEquipo) {
                                                    
                    $statement = $this->PDO->prepare("
													SELECT 
													    stats.idEquipo,
													    stats.vNombreEquipo,
													    stats.VecesJugo,
													    stats.VecesGanadas + COALESCE(default_ganadas.VecesGanadasDefault, 0) AS VecesGanadas,
													    stats.VecesPerdidas,
													    stats.PuntosAFavor + COALESCE(default_points.vPuntosDefault, 0) AS PuntosAFavor,
													    COALESCE(puntos_en_contra.total_puntos_en_contra, 0) AS PuntosEnContra,
													    (stats.PuntosAFavor + COALESCE(default_points.vPuntosDefault, 0) - COALESCE(puntos_en_contra.total_puntos_en_contra, 0)) AS DiferenciaDePuntos,
													    ((stats.VecesGanadas + COALESCE(default_ganadas.VecesGanadasDefault, 0)) * 2 + stats.VecesPerdidas) AS Puntos
													FROM (
													    SELECT 
													        e.idEquipo,
													        e.vNombreEquipo,
													        COUNT(DISTINCT h.idCalendario) AS VecesJugo,
													        COUNT(DISTINCT CASE WHEN total_puntos_equipo >= otros_equipos_max THEN h.idCalendario END) AS VecesGanadas,
													        (COUNT(DISTINCT h.idCalendario) - COUNT(DISTINCT CASE WHEN total_puntos_equipo >= otros_equipos_max THEN h.idCalendario END)) AS VecesPerdidas,
													        COALESCE(SUM(vPuntosTotal), 0) AS PuntosAFavor
													    FROM tblequipos e
													    LEFT JOIN tblhistoricojugador h ON e.idEquipo = h.idEquipo AND h.idTorneo = :idTorneo
													    LEFT JOIN (
													        SELECT idCalendario, idEquipo, SUM(vPuntosTotal) AS total_puntos_equipo
													        FROM tblhistoricojugador
													        GROUP BY idCalendario, idEquipo
													    ) puntos_equipo ON h.idCalendario = puntos_equipo.idCalendario AND e.idEquipo = puntos_equipo.idEquipo
													    LEFT JOIN (
													        SELECT idCalendario, MAX(total_puntos_equipo) AS otros_equipos_max
													        FROM (
													            SELECT idCalendario, idEquipo, SUM(vPuntosTotal) AS total_puntos_equipo
													            FROM tblhistoricojugador
													            GROUP BY idCalendario, idEquipo
													        ) temp
													        GROUP BY idCalendario
													    ) AS max_puntos_otros_equipos ON h.idCalendario = max_puntos_otros_equipos.idCalendario
													    WHERE h.idEquipo IS NOT NULL  
													    GROUP BY e.idEquipo, e.vNombreEquipo
													) AS stats
													LEFT JOIN (
													    SELECT idEquipo, SUM(vPuntosDefault) AS vPuntosDefault
													    FROM tbldefault
													    GROUP BY idEquipo
													) AS default_points ON stats.idEquipo = default_points.idEquipo
													LEFT JOIN (
													    SELECT
													        idEquipo,
													        COUNT(DISTINCT idCalendario) AS VecesGanadasDefault
													    FROM tbldefault
													    GROUP BY idEquipo
													) AS default_ganadas ON stats.idEquipo = default_ganadas.idEquipo
													LEFT JOIN (
													    SELECT
													        equipo,
													        SUM(puntos_en_contra) AS total_puntos_en_contra
													    FROM (
													        SELECT
													            c.vEqLocal AS equipo,
													            SUM(COALESCE(hj.vPuntosTotal, d.vPuntosDefault, 0)) AS puntos_en_contra
													        FROM tblcalendario c 
													        LEFT JOIN tblhistoricojugador hj ON hj.idEquipo = c.vEqVisitante AND c.idCalendario = hj.idCalendario AND hj.idTorneo = :idTorneo
													        LEFT JOIN tbldefault d ON c.vEqVisitante = d.idEquipo
													        WHERE c.idTorneo = :idTorneo
													        GROUP BY c.vEqLocal

													        UNION ALL

													        SELECT
													            c.vEqVisitante AS equipo,
													            SUM(COALESCE(hj.vPuntosTotal, d.vPuntosDefault, 0)) AS puntos_en_contra
													        FROM tblcalendario c 
													        LEFT JOIN tblhistoricojugador hj ON hj.idEquipo = c.vEqLocal AND c.idCalendario = hj.idCalendario AND hj.idTorneo = :idTorneo
													        LEFT JOIN tbldefault d ON c.vEqLocal = d.idEquipo
													        WHERE c.idTorneo = :idTorneo
													        GROUP BY c.vEqVisitante
													    ) AS combined_results
													    GROUP BY equipo
													) AS puntos_en_contra ON stats.idEquipo = puntos_en_contra.equipo
													WHERE stats.idEquipo = :idEquipo
													ORDER BY stats.VecesJugo DESC;

                                                    ");

                    $statement->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT); 
                    $statement->bindParam(':idEquipo', $idEquipo, PDO::PARAM_INT); 

                    $statement->execute();
                    return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
		 * La función "allEstJugadorUsuario" recupera todas las estadísticas de los jugadores de un
		 * torneo y equipo específico.
		 * 
		 * @param idTorneo El parámetro idTorneo es el ID del torneo del que deseas recuperar las
		 * estadísticas de los jugadores.
		 * @param idEquipo El parámetro "idEquipo" es el ID del equipo del cual deseas recuperar la
		 * información del jugador.
		 * 
		 * @return una matriz de matrices asociativas. Cada matriz asociativa representa una fila de
		 * datos del resultado de la consulta. Las claves de la matriz asociativa corresponden a los
		 * nombres de las columnas en el resultado de la consulta y los valores son los valores de esas
		 * columnas para esa fila.
		 */
		public function allEstJugadorUsuario($idTorneo,$idEquipo) {
                                                
                                                $statement = $this->PDO->prepare("
																					SELECT 
																					    j.idJugador, 
																					    j.vNombreJugador, 
																					    j.vApellidoJugador, 
																					    j.vImgJugador, 
																					    e.vNombreEquipo,
																					    SUM(h.vFaltas) AS TotalFaltas,
																					    SUM(h.vTirosde3) AS TotalTirosde3,
																					    SUM(h.vPuntosTotal) AS TotalPuntos
																					FROM tblhistoricojugador h
																					INNER JOIN tbljugadores j ON h.idJugador = j.idJugador
																					INNER JOIN tblequipos e ON j.idEquipo = e.idEquipo
																					WHERE h.idTorneo = :idTorneo
																					AND e.idEquipo = :idEquipo
																					GROUP BY j.idJugador, j.vNombreJugador, j.vApellidoJugador, j.vImgJugador, e.vNombreEquipo             
																					ORDER BY vNombreJugador ASC;

                                                								");

                $statement->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT); 
                $statement->bindParam(':idEquipo', $idEquipo, PDO::PARAM_INT); 
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

       /**
		 * Genera un conjunto de datos para la creación de un documento PDF que muestra los  detalles
		 *
		 * La función realiza una consulta a la base de datos para obtener información detallada de cada
		 * partido en el torneo incluyendo el tipo de juego, fecha, hora, equipos locales y visitantes, sede
		 * estado del partido (jugado, ganador por default o no jugado),
		 * resultados de los equipos locales y visitantes, y el equipo ganador en caso de que haya uno.
		 * 
		 * Además, se incluye una distinción de empate cuando los puntos totales de un equipo son iguales
		 * tanto para el equipo local como para el visitante.
		 * 
		 * La consulta abarca varias tablas, incluyendo tblcalendario, tblhistoricojugador, tbldefault y
		 * tblEquipos, y utiliza subconsultas para determinar el resultado y el estado de cada partido,
		 * teniendo en cuenta tanto los registros de historial de jugadores como los casos de victoria por
		 * default.Los resultados se ordenan por fecha y hora de manera ascendente.
		 *
		 * @param int $idTorneo El ID del torneo del cual se desean obtener los datos de los partidos.
		 * @return array Un array asociativo que contiene información detallada de cada partido en el torneo.
		 * Cada elemento del array corresponde a un partido y contiene datos como ID de
		 * calendario, tipo de juego, fecha, hora, nombres de los equipos,
		 * sede, estado del partido, resultados de los equipos locales y visitantes, y el nombre
		 * del equipo ganador (si hay uno).
		 * El array está ordenado por fecha y hora de manera ascendente.
		 */
	    public function pdf($idTorneo) {
                                                
            $statement = $this->PDO->prepare("
											SELECT 
											    DISTINCT c.idCalendario,
											    c.vTipoJuego,
											    c.vFecha,
											    c.vHora,
											    local.vNombreEquipo AS NombreLocal,
											    visitante.vNombreEquipo AS NombreVisitante,
											    c.vSede,
											    CASE 
											        WHEN hj.idCalendario IS NOT NULL THEN 'Jugado'
											        WHEN td.idCalendario IS NOT NULL THEN 'Ganador por Default Equipo ' 
											        ELSE 'No Jugado' 
											    END AS Estado,
											    COALESCE(CASE WHEN resultado_local.Resultado = 'Ganador' AND resultado_local.EsEmpate = 1 THEN 'Empate' ELSE resultado_local.Resultado END, 'Sin Historial') AS ResultadoLocal,
											    COALESCE(CASE WHEN resultado_visitante.Resultado = 'Ganador' AND resultado_visitante.EsEmpate = 1 THEN 'Empate' ELSE resultado_visitante.Resultado END, 'Sin Historial') AS ResultadoVisitante,
											    CASE 
											        WHEN td.idEquipo IS NOT NULL THEN (SELECT vNombreEquipo FROM tblEquipos WHERE idEquipo = td.idEquipo)
											        ELSE NULL
											    END AS EquipoGanador
											FROM
											    tblcalendario c
											LEFT JOIN
											    tblhistoricojugador hj ON c.idCalendario = hj.idCalendario
											LEFT JOIN
											    tbldefault td ON c.idCalendario = td.idCalendario
											LEFT JOIN
											    tblEquipos AS local ON c.vEqLocal = local.idEquipo
											LEFT JOIN
											    tblEquipos AS visitante ON c.vEqVisitante = visitante.idEquipo
											LEFT JOIN (
											    SELECT 
											        DISTINCT h.idCalendario,
											        h.idEquipo,
											        CASE
											            WHEN SUM(h.vPuntosTotal) = max_puntos.max_puntos_calendario THEN 'Ganador'
											            WHEN MAX(h.vPuntosTotal) = MIN(h.vPuntosTotal) THEN 'Empate' -- Nueva condición para empate
											            ELSE 'Perdedor'
											        END AS Resultado,
											        CASE WHEN MAX(h.vPuntosTotal) = MIN(h.vPuntosTotal) THEN 1 ELSE 0 END AS EsEmpate
											    FROM 
											        tblhistoricojugador h
											    INNER JOIN (
											        SELECT 
											            idCalendario,
											            MAX(TotalPuntosEquipo) AS max_puntos_calendario
											        FROM (
											            SELECT 
											                idCalendario,
											                idEquipo,
											                SUM(vPuntosTotal) AS TotalPuntosEquipo
											            FROM 
											                tblhistoricojugador
											            WHERE 
											                idCalendario IN (SELECT idCalendario FROM tblcalendario WHERE idTorneo = :idTorneo)
											            GROUP BY 
											                idCalendario, idEquipo
											        ) AS PuntosPorCalendario
											        GROUP BY 
											            idCalendario
											    ) AS max_puntos ON h.idCalendario = max_puntos.idCalendario
											    WHERE 
											        h.idCalendario IN (SELECT idCalendario FROM tblcalendario WHERE idTorneo = :idTorneo)
											    GROUP BY 
											        h.idCalendario, h.idEquipo  
											) AS resultado_local ON c.idCalendario = resultado_local.idCalendario AND c.vEqLocal = resultado_local.idEquipo
											LEFT JOIN (
											    SELECT 
											        DISTINCT h.idCalendario,
											        h.idEquipo,
											        CASE
											            WHEN SUM(h.vPuntosTotal) = max_puntos.max_puntos_calendario THEN 'Ganador'
											            WHEN MAX(h.vPuntosTotal) = MIN(h.vPuntosTotal) THEN 'Empate' -- Nueva condición para empate
											            ELSE 'Perdedor'
											        END AS Resultado,
											        CASE WHEN MAX(h.vPuntosTotal) = MIN(h.vPuntosTotal) THEN 1 ELSE 0 END AS EsEmpate
											    FROM 
											        tblhistoricojugador h
											    INNER JOIN (
											        SELECT 
											            idCalendario,
											            MAX(TotalPuntosEquipo) AS max_puntos_calendario
											        FROM (
											            SELECT 
											                idCalendario,
											                idEquipo,
											                SUM(vPuntosTotal) AS TotalPuntosEquipo
											            FROM 
											                tblhistoricojugador
											            WHERE 
											                idCalendario IN (SELECT idCalendario FROM tblcalendario WHERE idTorneo = :idTorneo)
											            GROUP BY 
											                idCalendario, idEquipo
											        ) AS PuntosPorCalendario
											        GROUP BY 
											            idCalendario
											    ) AS max_puntos ON h.idCalendario = max_puntos.idCalendario
											    WHERE 
											        h.idCalendario IN (SELECT idCalendario FROM tblcalendario WHERE idTorneo = :idTorneo)
											    GROUP BY 
											        h.idCalendario, h.idEquipo  
											) AS resultado_visitante ON c.idCalendario = resultado_visitante.idCalendario AND c.vEqVisitante = resultado_visitante.idEquipo
											WHERE
											    c.idTorneo = :idTorneo
											ORDER BY c.vFecha ASC, c.vHora ASC;

                                            ");

                $statement->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT); 
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        
		/**
		 * La función recupera estadísticas de todos los equipos de un grupo de torneo, incluido el número de
		 * veces jugadas, el número de victorias, el número de derrotas, los puntos anotados, los puntos en
		 * contra, la diferencia de puntos y el total de puntos.
		 * 
		 * @param idTorneo El parámetro "idTorneo" representa el ID de un torneo. Se utiliza para filtrar los
		 * resultados según el torneo especificado.
		 * @param idGrupo El parámetro "idGrupo" es el ID del grupo del que desea recuperar las estadísticas.
		 * 
		 * @return una matriz de matrices asociativas, donde cada matriz asociativa representa las
		 * estadísticas de un equipo en un grupo de torneo. Las claves del arreglo asociativo representan las
		 * diferentes estadísticas, como ID del equipo, nombre, número de veces jugadas, número de veces
		 * ganadas, número de veces perdidas, puntos anotados, puntos en contra, diferencia de puntos y
		 * puntos totales.
		 */
		public function allEstGrupoUsuario($idTorneo, $idGrupo) {
			
			$statement = $this->PDO->prepare("
												SELECT 
										    stats.idEquipo,
										    stats.vNombreEquipo,
										    stats.VecesJugo,
										    stats.VecesGanadas + COALESCE(default_ganadas.VecesGanadasDefault, 0) AS VecesGanadas,
										    stats.VecesPerdidas,
										    stats.PuntosAFavor + COALESCE(default_points.vPuntosDefault, 0) AS PuntosAFavor,
										    COALESCE(puntos_en_contra.total_puntos_en_contra, 0) AS PuntosEnContra,
										    (stats.PuntosAFavor + COALESCE(default_points.vPuntosDefault, 0) - COALESCE(puntos_en_contra.total_puntos_en_contra, 0)) AS DiferenciaDePuntos,
										    ((stats.VecesGanadas + COALESCE(default_ganadas.VecesGanadasDefault, 0)) * 2 + stats.VecesPerdidas) AS Puntos
										FROM (
										    SELECT 
										        e.idEquipo,
										        e.vNombreEquipo,
										        COUNT(DISTINCT h.idCalendario) AS VecesJugo,
										        COUNT(DISTINCT CASE WHEN total_puntos_equipo >= otros_equipos_max THEN h.idCalendario END) AS VecesGanadas,
										        (COUNT(DISTINCT h.idCalendario) - COUNT(DISTINCT CASE WHEN total_puntos_equipo >= otros_equipos_max THEN h.idCalendario END)) AS VecesPerdidas,
										        COALESCE(SUM(vPuntosTotal), 0) AS PuntosAFavor
										    FROM tblequipos e
										    LEFT JOIN tblhistoricojugador h ON e.idEquipo = h.idEquipo AND h.idTorneo = :idTorneo
										    LEFT JOIN (
										        SELECT idCalendario, idEquipo, SUM(vPuntosTotal) AS total_puntos_equipo
										        FROM tblhistoricojugador
										        GROUP BY idCalendario, idEquipo
										    ) puntos_equipo ON h.idCalendario = puntos_equipo.idCalendario AND e.idEquipo = puntos_equipo.idEquipo
										    LEFT JOIN (
										        SELECT idCalendario, MAX(total_puntos_equipo) AS otros_equipos_max
										        FROM (
										            SELECT idCalendario, idEquipo, SUM(vPuntosTotal) AS total_puntos_equipo
										            FROM tblhistoricojugador
										            GROUP BY idCalendario, idEquipo
										        ) temp
										        GROUP BY idCalendario
										    ) AS max_puntos_otros_equipos ON h.idCalendario = max_puntos_otros_equipos.idCalendario
										    WHERE e.idGrupo = :idGrupo    
										    GROUP BY e.idEquipo, e.vNombreEquipo
										) AS stats
										LEFT JOIN (
										    SELECT idEquipo, SUM(vPuntosDefault) AS vPuntosDefault
										    FROM tbldefault
										    GROUP BY idEquipo
										) AS default_points ON stats.idEquipo = default_points.idEquipo
										LEFT JOIN (
										    SELECT
										        idEquipo,
										        COUNT(DISTINCT idCalendario) AS VecesGanadasDefault
										    FROM tbldefault
										    GROUP BY idEquipo
										) AS default_ganadas ON stats.idEquipo = default_ganadas.idEquipo
										LEFT JOIN (
										    SELECT
										        equipo,
										        SUM(puntos_en_contra) AS total_puntos_en_contra
										    FROM (
										        SELECT
										            c.vEqLocal AS equipo,
										            SUM(COALESCE(hj.vPuntosTotal, d.vPuntosDefault, 0)) AS puntos_en_contra
										        FROM tblcalendario c 
										        LEFT JOIN tblhistoricojugador hj ON hj.idEquipo = c.vEqVisitante AND c.idCalendario = hj.idCalendario AND hj.idTorneo = :idTorneo
										        LEFT JOIN tbldefault d ON c.vEqVisitante = d.idEquipo
										        WHERE c.idTorneo = :idTorneo
										        GROUP BY c.vEqLocal

										        UNION ALL

										        SELECT
										            c.vEqVisitante AS equipo,
										            SUM(COALESCE(hj.vPuntosTotal, d.vPuntosDefault, 0)) AS puntos_en_contra
										        FROM tblcalendario c 
										        LEFT JOIN tblhistoricojugador hj ON hj.idEquipo = c.vEqLocal AND c.idCalendario = hj.idCalendario AND hj.idTorneo = :idTorneo
										        LEFT JOIN tbldefault d ON c.vEqLocal = d.idEquipo
										        WHERE c.idTorneo = :idTorneo
										        GROUP BY c.vEqVisitante
										    ) AS combined_results
										    GROUP BY equipo
										) AS puntos_en_contra ON stats.idEquipo = puntos_en_contra.equipo
												INNER JOIN tblequipos e ON stats.idEquipo = e.idEquipo
											    WHERE e.idGrupo = :idGrupo
											ORDER BY stats.VecesJugo DESC;
											SELECT 
											        stats.idEquipo,
											        stats.vNombreEquipo,
											        stats.VecesJugo,
											        stats.VecesGanadas + COALESCE(CASE WHEN default_points.vPuntosDefault = 20 THEN 1 ELSE 0 END, 0) AS VecesGanadas,
											        stats.VecesPerdidas,
											        stats.PuntosAFavor + COALESCE(default_points.vPuntosDefault, 0) AS PuntosAFavor,
											        COALESCE(puntos_en_contra.total_puntos_en_contra, 0) AS PuntosEnContra,
											        (stats.PuntosAFavor + COALESCE(default_points.vPuntosDefault, 0) - COALESCE(puntos_en_contra.total_puntos_en_contra, 0)) AS DiferenciaDePuntos,
											        ((stats.VecesGanadas + COALESCE(default_points.vPuntosDefault, 0)) * 2 + stats.VecesPerdidas) AS Puntos
											    FROM (
											        SELECT 
											            e.idEquipo,
											            e.vNombreEquipo,
											            COUNT(DISTINCT h.idCalendario) AS VecesJugo,
											            COUNT(DISTINCT CASE WHEN total_puntos_equipo >= otros_equipos_max THEN h.idCalendario END) AS VecesGanadas,
											            (COUNT(DISTINCT h.idCalendario) - COUNT(DISTINCT CASE WHEN total_puntos_equipo >= otros_equipos_max THEN h.idCalendario END)) AS VecesPerdidas,
											            COALESCE(SUM(vPuntosTotal), 0) AS PuntosAFavor
											        FROM tblequipos e
											        LEFT JOIN tblhistoricojugador h ON e.idEquipo = h.idEquipo AND h.idTorneo = :idTorneo
											        LEFT JOIN (
											            SELECT idCalendario, idEquipo, SUM(vPuntosTotal) AS total_puntos_equipo
											            FROM tblhistoricojugador
											            GROUP BY idCalendario, idEquipo
											        ) puntos_equipo ON h.idCalendario = puntos_equipo.idCalendario AND e.idEquipo = puntos_equipo.idEquipo
											        LEFT JOIN (
											            SELECT idCalendario, MAX(total_puntos_equipo) AS otros_equipos_max
											            FROM (
											                SELECT idCalendario, idEquipo, SUM(vPuntosTotal) AS total_puntos_equipo
											                FROM tblhistoricojugador
											                GROUP BY idCalendario, idEquipo
											            ) temp
											            GROUP BY idCalendario
											        ) AS max_puntos_otros_equipos ON h.idCalendario = max_puntos_otros_equipos.idCalendario
											        WHERE e.idGrupo = :idGrupo  
											        GROUP BY e.idEquipo, e.vNombreEquipo
											    ) AS stats
											    LEFT JOIN (
											        SELECT idEquipo, SUM(vPuntosDefault) AS vPuntosDefault
											        FROM tbldefault
											        GROUP BY idEquipo
											    ) AS default_points ON stats.idEquipo = default_points.idEquipo
											    LEFT JOIN (
											        SELECT
											            equipo,
											            SUM(puntos_en_contra) AS total_puntos_en_contra
											        FROM (
											            SELECT
											                c.vEqLocal AS equipo,
											                SUM(COALESCE(hj.vPuntosTotal, d.vPuntosDefault, 0)) AS puntos_en_contra
											            FROM tblcalendario c 
											            LEFT JOIN tblhistoricojugador hj ON hj.idEquipo = c.vEqVisitante AND c.idCalendario = hj.idCalendario AND hj.idTorneo = :idTorneo
											            LEFT JOIN tbldefault d ON c.vEqVisitante = d.idEquipo
											            WHERE c.idTorneo = :idTorneo
											            GROUP BY c.vEqLocal

											            UNION ALL

											            SELECT
											                c.vEqVisitante AS equipo,
											                SUM(COALESCE(hj.vPuntosTotal, d.vPuntosDefault, 0)) AS puntos_en_contra
											            FROM tblcalendario c 
											            LEFT JOIN tblhistoricojugador hj ON hj.idEquipo = c.vEqLocal AND c.idCalendario = hj.idCalendario AND hj.idTorneo = :idTorneo
											            LEFT JOIN tbldefault d ON c.vEqLocal = d.idEquipo
											            WHERE c.idTorneo = :idTorneo
											            GROUP BY c.vEqVisitante
											        ) AS combined_results
											        GROUP BY equipo
											    ) AS puntos_en_contra ON stats.idEquipo = puntos_en_contra.equipo
											    INNER JOIN tblequipos e ON stats.idEquipo = e.idEquipo
											    WHERE e.idGrupo = :idGrupo
											    ORDER BY stats.VecesJugo DESC;
										");

										$statement->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT); 
										$statement->bindParam(':idGrupo', $idGrupo, PDO::PARAM_INT); 

										$statement->execute();
										return $statement->fetchAll(PDO::FETCH_ASSOC);
									}


		
		/**
		 * La función recupera información sobre el máximo goleador de cada partido de un calendario.
		 * 
		 * @return una matriz de matrices asociativas. Cada matriz asociativa representa una fila de datos
		 * del resultado de la consulta.
		 * 
		 * Para esta función, se ha efectuado una consulta a la base de datos mediante una tabla temporal para * obtener los detalles de cada partido, incluyendo el máximo anotador y los detalles correspondientes * del jugador, tanto para el equipo local como para el visitante. Con el propósito de facilitar la   * identificación visual de manera más rápida, se ha incluido la fecha del torneo en los resultados.  * Además, la fecha ha sido ordenada de manera ascendente para facilitar la obtención de datos del     * jugador que haya registrado la mayor puntuación en cada partido. Para recuperar esta información   * específica del jugador, se ha consultado la tabla tblhistoricojugador.
		 */
		public function allMaxAnotacion() {
		    $statement = $this->PDO->prepare("
											SELECT
												    c.idCalendario,
												    c.vEqLocal,
												    (SELECT vNombreEquipo FROM tblequipos WHERE idEquipo = c.vEqLocal) AS NombreEqLocal,
												    c.vEqVisitante,
												    (SELECT vNombreEquipo FROM tblequipos WHERE idEquipo = c.vEqVisitante) AS NombreEqVisitante,
												    MAX(CASE WHEN hj.idEquipo = c.vEqLocal THEN hj.vPuntosTotal END) AS MaxAnotadorLocal,
												    (SELECT hj2.idJugador
												     FROM tblhistoricojugador hj2
												     WHERE hj2.idEquipo = c.vEqLocal
												     AND hj2.idCalendario = c.idCalendario
												     ORDER BY hj2.vPuntosTotal DESC
												     LIMIT 1) AS idJugadorMaxAnotadorLocal,
												    (SELECT CONCAT(vNombreJugador, ' ', vApellidoJugador) FROM tbljugadores WHERE idJugador = idJugadorMaxAnotadorLocal) AS NombreJugadorMaxAnotadorLocal,
												    MAX(CASE WHEN hj.idEquipo = c.vEqVisitante THEN hj.vPuntosTotal END) AS MaxAnotadorVisitante,
												    (SELECT hj2.idJugador
												     FROM tblhistoricojugador hj2
												     WHERE hj2.idEquipo = c.vEqVisitante
												     AND hj2.idCalendario = c.idCalendario
												     ORDER BY hj2.vPuntosTotal DESC
												     LIMIT 1) AS idJugadorMaxAnotadorVisitante,
												    (SELECT CONCAT(vNombreJugador, ' ', vApellidoJugador) FROM tbljugadores WHERE idJugador = idJugadorMaxAnotadorVisitante) AS NombreJugadorMaxAnotadorVisitante,
												    c.vFecha
												FROM
												    tblcalendario c
												JOIN
												    tblhistoricojugador hj ON (c.vEqLocal = hj.idEquipo OR c.vEqVisitante = hj.idEquipo) AND c.idCalendario = hj.idCalendario
												GROUP BY
												    c.idCalendario, c.vEqLocal, c.vEqVisitante
												ORDER BY
												    c.vFecha;
		    									");

		    $statement->execute();
		    return $statement->fetchAll(PDO::FETCH_ASSOC);
		}

	}

?>