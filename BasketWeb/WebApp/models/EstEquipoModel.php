<?php
    include_once (__DIR__ . '/../config/dataBase.php');

    class estEquipoModel {
        public $PDO;

        /**
         * Constructor de la clase que inicializa la conexión a la base de datos.
         */
        public function __construct () {
            $vConexion = new DataBase ();
            $this->PDO = $vConexion->getConexion ();
        }

        /**
         * Obtiene estadísticas de equipos para un torneo específico.
         *
         * @param int $idTorneo Identificador del torneo.
         *
         * @return array Retorna un array asociativo con las estadísticas de los equipos en el torneo.
         * Cada elemento del array contiene información como el nombre del equipo, veces jugadas, veces ganadas,
         * veces perdidas, puntos a favor, puntos en contra, diferencia de puntos y puntos totales.
         * El array está ordenado por la cantidad de veces jugadas en orden descendente.
         */
        
        /*Se crea una tabla temporal con los campos vNombreEquipo, VecesJugo, VecesGanadas,VecesPerdidas,PuntosAFavor
         * de la tblHistoricojugador para obtener las VecesJugada Suma las veces que el idEquipo aparece en la tabla con relacion al calendario * y al torneo
         * VecesGanada, suma los puntajes de cada jugador(vPuntosTotal) por idEquipo dependiendo el idCalendario, despues de ello se evalua el 
         * numero mayor obetenido de cada idEquipo para posteriormente definir que el numero mayor es ganador y el menor es perdedor, en caso 
         * que haya ganado un equipo por default, este se sumara, para ello se accede a la tabla tbldefault y evalua los IdEquipo, si coincide
         * idEquipo de esa tabla con la de tblhistoricojugaodr, le sumara un partido ganado el idEquipo que se encuentra almacenado.
         * VecesPerdida, En este se guarda el equipo perdedor.
         * PuntosAFavor, suma los vPuntosTotales de cada idJugador por IdEquipo de cada idCalendario tambien de la tbldefault se evalua si
         * hay un idEquipo que coincida con otro de la tblhistoricojugador le suamar 20 puntos(vPuntosDefault)a solo los idEquipo que aparezcan
         * en esa tabla
         * PuntosEnContra, segundo los idCalendario(Juegos) suma los vPuntosTotal que le ha anotado el Equipo contrario
         * Difrencia, resta los PuntosAFavor - PuntosEnContra
         * Puntaje Multiplica las VecesGanadas x 2 y si tiene Veces perdida suma + 1, sino, no suma nada.
         * Veces Jugó (VecesJugo):
         * 
         * Utiliza COUNT(DISTINCT h.idCalendario) para contar el número único de partidos jugados por cada equipo en el torneo.
         * 
         * Veces Ganadas (VecesGanadas):
         * Utiliza COUNT(DISTINCT CASE WHEN total_puntos_equipo >= otros_equipos_max THEN h.idCalendario END) para contar el número de partidos 
         * en los que el equipo ha ganado.
         * 
         * Veces Perdidas (VecesPerdidas):
         * Utiliza (COUNT(DISTINCT h.idCalendario) - COUNT(DISTINCT CASE WHEN total_puntos_equipo >= 
         * otros_equipos_max THEN h.idCalendario END)) para calcular el número de partidos perdidos.
         * 
         * Puntos a Favor (PuntosAFavor):
         * Utiliza COALESCE(SUM(vPuntosTotal), 0) para sumar los puntos totales obtenidos por el equipo en todos los partidos jugados.
         * 
         * Puntos en Contra (PuntosEnContra):
         * Utiliza una subconsulta para obtener los puntos totales obtenidos por los equipos oponentes en los partidos jugados contra el equipo
         * actual y luego suma estos puntos.
         * 
         * Diferencia de Puntos (DiferenciaDePuntos):
         * Calcula la diferencia entre los puntos a favor y los puntos en contra.
         * 
         * Puntos (Puntos):
         * Utiliza la fórmula ((VecesGanadas * 2) + VecesPerdidas) para calcular la puntuación total del equipo.
         *
         * 
         */
        public function allEstEquipo ($idTorneo) {
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
                                                ORDER BY stats.VecesJugo DESC;
                                            ");

            $statement->bindParam (':idTorneo', $idTorneo, PDO::PARAM_INT); 
            $statement->execute ();
            return $statement->fetchAll (PDO::FETCH_ASSOC);
        }
    }
?>