<?php
    include_once (__DIR__ . '/../config/dataBase.php');

    class estJugadorModel {
        public $PDO;

        /**
         * Constructor de la clase que inicializa la conexión a la base de datos.
         */
        public function __construct () {

            $vConexion = new DataBase ();
            $this->PDO = $vConexion->getConexion ();
        }

        /**
         * Obtiene estadísticas de jugadores para un torneo específico.
         *
         * @param int $idTorneo Identificador del torneo.
         *
         * @return array Retorna un array asociativo con las estadísticas de los jugadores en el torneo.
         * Cada elemento del array contiene información como el nombre del jugador, apellido, imagen, nombre del equipo,
         * total de faltas, total de tiros de 3 puntos y total de puntos anotados.
         */
        
        public function allEstJugador ($idTorneo) {
            
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
                                                GROUP BY j.idJugador, j.vNombreJugador, j.vApellidoJugador, j.vImgJugador, e.vNombreEquipo;
                                            ");

            $statement->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT); 
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>