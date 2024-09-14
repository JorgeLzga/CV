<?php
    include_once (__DIR__ . '/../config/dataBase.php');

    /**
     * Modelo para la gestión de operaciones relacionadas con la jornada.
     */
    class JornadaModel {
        public $PDO;

        /**
         * Constructor de la clase que inicializa la conexión a la base de datos.
         */
        public function __construct () {
            $vConexion = new DataBase ();
            $this->PDO = $vConexion->getConexion ();
        }

        /**
         * Registra un nuevo registro en la tabla de historial de jugadores para una jornada específica.
         *
         * @param float $vPuntosTotal Puntos totales del jugador.
         * @param int $vTirosde3 Cantidad de tiros de 3 puntos del jugador.
         * @param int $vFaltas Cantidad de faltas del jugador.
         * @param int $idEquipo Identificador del equipo al que pertenece el jugador.
         * @param int $idJugador Identificador del jugador.
         * @param int $idCalendario Identificador de la jornada en la tabla de calendario.
         * @param int $idTorneo Identificador del torneo.
         *
         * @return int|false Retorna el ID del nuevo registro si tiene éxito, de lo contrario, devuelve false.
         */
        public function insert ($vPuntosTotal, $vTirosde3, $vFaltas, $idEquipo, $idJugador, $idCalendario, $idTorneo) {
            $statement = $this->PDO->prepare ("
                                                INSERT INTO tblhistoricojugador
                                                (vPuntosTotal,
                                                vTirosde3,
                                                vFaltas,
                                                idEquipo,
                                                idJugador,
                                                idCalendario,
                                                idTorneo)

                                                VALUES 
                                                (:vPuntosTotal, 
                                                :vTirosde3, 
                                                :vFaltas, 
                                                :idEquipo, 
                                                :idJugador, 
                                                :idCalendario, 
                                                :idTorneo)
                                            ");

            $statement->bindParam (":vPuntosTotal", $vPuntosTotal);
            $statement->bindParam (":vTirosde3", $vTirosde3);
            $statement->bindParam (":vFaltas", $vFaltas);
            $statement->bindParam (":idEquipo", $idEquipo);
            $statement->bindParam (":idJugador", $idJugador);
            $statement->bindParam (":idCalendario", $idCalendario);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $this->PDO->lastInsertId () : false;
        }

        /**
         * Inserta valores predeterminados en la tabla tbldefault de la base de datos.
         *
         * Este método inserta valores predeterminados en la tabla tbldefault utilizando
         * la información proporcionada, como los puntos predeterminados, el ID del equipo,
         * el ID del calendario y el ID del torneo.
         *
         * @param int $vPuntosDefault Los puntos predeterminados a insertar.
         * @param int $idEquipo El ID del equipo asociado a los puntos predeterminados.
         * @param int $idCalendario El ID del calendario asociado a los puntos predeterminados.
         * @param int $idTorneo El ID del torneo asociado a los puntos predeterminados.
         * @return int|false El ID del último elemento insertado o false si la inserción falla.
         */
        public function insertDefault(
                                        $vPuntosDefault,
                                        $idEquipo,
                                        $idCalendario,
                                        $idTorneo 
                                    ) {

            $statement = $this->PDO->prepare("
                                                INSERT INTO tbldefault
                                                (vPuntosDefault,
                                                idEquipo,
                                                idCalendario,
                                                idTorneo)

                                                VALUES 
                                                (:vPuntosDefault, 
                                                :idEquipo, 
                                                :idCalendario, 
                                                :idTorneo)
                                            ");

            $statement->bindParam(":vPuntosDefault", $vPuntosDefault);
            $statement->bindParam(":idEquipo", $idEquipo);
            $statement->bindParam(":idCalendario", $idCalendario);
            $statement->bindParam(":idTorneo", $idTorneo);

            return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    
        }

        /**
         * Obtiene los registros del historial de jugadores para el equipo local en una jornada específica.
         *
         * @param int $idCalendario Identificador de la jornada en la tabla de calendario.
         * @param int $idTorneo Identificador del torneo.
         *
         * @return array|false Retorna un array asociativo con los registros del historial de jugadores para el equipo local si tiene éxito, de lo contrario, devuelve false.
         */
        public function allJornadaEqLocal ($idCalendario,$idTorneo) {            
            $statement = $this->PDO->prepare ("
                                                SELECT j.idJugador, j.vNombreJugador, j.vApellidoJugador, h.*
                                                FROM tbljugadores j
                                                INNER JOIN tblequipos e ON j.idEquipo = e.idEquipo
                                                INNER JOIN tblcalendario c ON e.idEquipo = c.vEqLocal
                                                LEFT JOIN (
                                                SELECT *
                                                FROM tblhistoricojugador 
                                                WHERE idCalendario = :idCalendario
                                                ) h ON c.idCalendario = h.idCalendario AND j.idJugador = h.idJugador
                                                WHERE c.idCalendario = :idCalendario AND c.idTorneo = :idTorneo
                                                GROUP BY j.idJugador, j.vNombreJugador, j.vApellidoJugador, c.vEqLocal, h.idJugador;
                                            ");

            $statement->bindParam (':idCalendario', $idCalendario);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute()) ? $statement->fetchAll(PDO::FETCH_ASSOC) : false;
        }

        /**
         * Obtiene los registros del historial de jugadores para el equipo visitante en una jornada específica.
         *
         * @param int $idCalendario Identificador de la jornada en la tabla de calendario.
         * @param int $idTorneo Identificador del torneo.
         *
         * @return array|false Retorna un array asociativo con los registros del historial de jugadores para el equipo visitante si tiene éxito, de lo contrario, devuelve false.
         */
        public function allJornadaEqVisitante ($idCalendario,$idTorneo) {
            $statement = $this->PDO->prepare ("
                                                SELECT j.idJugador, j.vNombreJugador, j.vApellidoJugador, h.*,c.*
                                                FROM tbljugadores j
                                                INNER JOIN tblequipos e ON j.idEquipo = e.idEquipo
                                                INNER JOIN tblcalendario c ON e.idEquipo = c.vEqVisitante
                                                LEFT JOIN (
                                                SELECT *
                                                FROM tblhistoricojugador 
                                                WHERE idCalendario = :idCalendario
                                                ) h ON c.idCalendario = h.idCalendario AND j.idJugador = h.idJugador
                                                WHERE c.idCalendario = :idCalendario AND c.idTorneo = :idTorneo
                                                GROUP BY j.idJugador, j.vNombreJugador, j.vApellidoJugador, c.vEqLocal, h.idJugador;
                                            ");

            $statement->bindParam (':idCalendario', $idCalendario);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $statement->fetchAll (PDO::FETCH_ASSOC) : false;
        }

        /**
         * Obtiene los registros de los jugadores para el equipo local en una jornada específica.
         *
         * @param int $idCalendario Identificador de la jornada en la tabla de calendario.
         * @param int $idTorneo Identificador del torneo.
         *
         * @return array|false Retorna un array asociativo con los registros de los jugadores para el equipo local si tiene éxito, de lo contrario, devuelve false.
         */
        public function allJornadaEquipoLocal ($idCalendario, $idTorneo) {
            $statement = $this->PDO->prepare("
                                                SELECT j.*, eqLocal.vNombreEquipo AS nombreEquipoLocal, c.idCalendario
                                                FROM tblJugadores j
                                                JOIN tblCalendario c ON j.idEquipo = c.vEqLocal
                                                JOIN tblEquipos eqLocal ON c.vEqLocal = eqLocal.idEquipo
                                                WHERE c.idCalendario = :idCalendario AND c.idTorneo = :idTorneo;
                                            ");
                
            $statement->bindParam (':idCalendario', $idCalendario);
            $statement->bindParam (':idTorneo', $idTorneo);
                
            if (!$statement) { 
                throw new Exception ("Error en la preparación de la consulta SQL");
            }

            $statement->execute ();
            return $statement->fetchAll (PDO::FETCH_ASSOC);
        }

        /**
         * Obtiene los registros de los jugadores para el equipo visitante en una jornada específica.
         *
         * @param int $idCalendario Identificador de la jornada en la tabla de calendario.
         * @param int $idTorneo Identificador del torneo.
         *
         * @return array|false Retorna un array asociativo con los registros de los jugadores para el equipo visitante si tiene éxito, de lo contrario, devuelve false.
         */
        public function allJornadaEquipoVisitante ($idCalendario, $idTorneo) {
            $statement = $this->PDO->prepare ("
                                                SELECT j.*, eqVisitante.vNombreEquipo AS nombreEquipoVisitante, c.idCalendario
                                                FROM tblJugadores j
                                                JOIN tblCalendario c ON j.idEquipo = c.vEqVisitante
                                                JOIN tblEquipos eqVisitante ON c.vEqVisitante = eqVisitante.idEquipo
                                                WHERE c.idCalendario = :idCalendario AND c.idTorneo = :idTorneo;
                                            ");
                
            $statement->bindParam (':idCalendario', $idCalendario);
            $statement->bindParam (':idTorneo', $idTorneo);
                
            if (!$statement) { 
                throw new Exception ("Error en la preparación de la consulta SQL");
            }

            $statement->execute ();
            return $statement->fetchAll (PDO::FETCH_ASSOC);
        }

        /**
         * Actualiza un registro en la tabla de historial de jugadores.
         *
         * @param int $idHistoriCoJugador Identificador del registro en la tabla de historial de jugadores.
         * @param float $vPuntosTotal Puntos totales del jugador.
         * @param int $vTirosde3 Cantidad de tiros de 3 puntos del jugador.
         * @param int $vFaltas Cantidad de faltas del jugador.
         * @param int $idEquipo Identificador del equipo al que pertenece el jugador.
         * @param int $idJugador Identificador del jugador.
         * @param int $idCalendario Identificador de la jornada en la tabla de calendario.
         * @param int $idTorneo Identificador del torneo.
         *
         * @return int|false Retorna el ID del registro actualizado si tiene éxito, de lo contrario, devuelve false.
         */
        public function update (
                                $idHistoriCoJugador,
                                $vPuntosTotal,
                                $vTirosde3,
                                $vFaltas,
                                $idEquipo,
                                $idJugador,
                                $idCalendario,
                                $idTorneo    
                                ) {

            $statement = $this->PDO->prepare ("
                                                UPDATE tblhistoricojugador SET 
                                                vPuntosTotal = :vPuntosTotal, 
                                                vTirosde3 = :vTirosde3,
                                                vFaltas = :vFaltas,
                                                idEquipo = :idEquipo,
                                                idJugador = :idJugador,
                                                idCalendario = :idCalendario,
                                                idTorneo = :idTorneo
                                                WHERE idHistoriCoJugador = :idHistoriCoJugador
                                            ");

            $statement->bindParam (":idHistoriCoJugador",$idHistoriCoJugador);
            $statement->bindParam (":vPuntosTotal", $vPuntosTotal);
            $statement->bindParam (":vTirosde3", $vTirosde3);
            $statement->bindParam (":vFaltas", $vFaltas);
            $statement->bindParam (":idEquipo", $idEquipo);
            $statement->bindParam (":idJugador", $idJugador);
            $statement->bindParam (":idCalendario", $idCalendario);
            $statement->bindParam (":idTorneo", $idTorneo);

            return($statement->execute ()) ? $idHistoriCoJugador : false;
        }
    }
?>