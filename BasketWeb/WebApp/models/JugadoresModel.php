<?php
    include_once (__DIR__ . '/../config/dataBase.php');

    /**
     * Modelo para la gestión de operaciones relacionadas con los jugadores.
     */
    class jugadoresModel {
        public $PDO;

        /**
         * Constructor de la clase que inicializa la conexión a la base de datos.
         */
        public function __construct () {
            
            $vConexion = new DataBase ();
            $this->PDO = $vConexion->getConexion ();
        }

        /**
         * Inserta un nuevo jugador en la base de datos.
         *
         * @param string $vNombreJugador Nombre del jugador.
         * @param string $vApellidoJugador Apellido del jugador.
         * @param string $vFechaNacimiento Fecha de nacimiento del jugador (formato: YYYY-MM-DD).
         * @param string $vCorreoJugador Correo electrónico del jugador.
         * @param string $vCelularJugador Número de celular del jugador.
         * @param string $vTipoSangre Tipo de sangre del jugador.
         * @param string $vContactoEmergencia Contacto de emergencia del jugador.
         * @param string $vImgJugador Ruta de la imagen del jugador.
         * @param int $idGrupo Identificador del grupo al que pertenece el jugador.
         * @param int $idTorneo Identificador del torneo.
         * @param int $idEquipo Identificador del equipo al que pertenece el jugador.
         *
         * @return int|false Retorna el ID del nuevo jugador si tiene éxito, de lo contrario, devuelve false.
         */
        public function insert ($vNombreJugador, 
                                $vApellidoJugador, 
                                $vFechaNacimiento, 
                                $vCorreoJugador, 
                                $vCelularJugador, 
                                $vTipoSangre, 
                                $vContactoEmergencia, 
                                $vImgJugador, 
                                $idGrupo, 
                                $idTorneo,
                                $idEquipo) {

            $statement = $this->PDO->prepare("
                                                INSERT INTO tbljugadores
                                                (vNombreJugador, 
                                                vApellidoJugador, 
                                                vFechaNacimiento, 
                                                vCorreoJugador,
                                                vCelularJugador, 
                                                vTipoSangre, 
                                                vContactoEmergencia, 
                                                vImgJugador,
                                                idGrupo,
                                                idTorneo,
                                                idEquipo)

                                                VALUES 
                                                (:vNombreJugador, 
                                                :vApellidoJugador, 
                                                :vFechaNacimiento, 
                                                :vCorreoJugador, 
                                                :vCelularJugador, 
                                                :vTipoSangre, 
                                                :vContactoEmergencia, 
                                                :vImgJugador,
                                                :idGrupo,
                                                :idTorneo,
                                                :idEquipo)
                                            ");

            $statement->bindParam (":vNombreJugador", $vNombreJugador);
            $statement->bindParam (":vApellidoJugador", $vApellidoJugador);
            $statement->bindParam (":vFechaNacimiento", $vFechaNacimiento);
            $statement->bindParam (":vCorreoJugador", $vCorreoJugador);
            $statement->bindParam (":vCelularJugador", $vCelularJugador);
            $statement->bindParam (":vTipoSangre", $vTipoSangre);
            $statement->bindParam (":vContactoEmergencia", $vContactoEmergencia);
            $statement->bindParam (":vImgJugador", $vImgJugador);
            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);
            $statement->bindParam (":idEquipo", $idEquipo);

            return ($statement->execute ()) ? $this->PDO->lastInsertId () : false;
        }

        /**
         * Lee la información de todos los jugadores de un grupo, torneo y equipo específicos.
         *
         * @param int $idGrupo Identificador del grupo.
         * @param int $idTorneo Identificador del torneo.
         * @param int $idEquipo Identificador del equipo.
         *
         * @return array|false Retorna un array con la información de los jugadores si tiene éxito, de lo contrario, devuelve false.
         */
        public function readOneJugador ($idGrupo, $idTorneo, $idEquipo) {
            $statement = $this->PDO->prepare ("
                                                SELECT * FROM tbljugadores 
                                                WHERE  idGrupo = :idGrupo 
                                                AND idTorneo = :idTorneo 
                                                AND idEquipo = :idEquipo 
                                                ORDER BY vNombreJugador ASC
                                            ");

            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);
            $statement->bindParam (":idEquipo", $idEquipo);

            return ($statement->execute ()) ? $statement->fetchAll () : false;
        }

        /**
         * Lee la información completa de un jugador específico en un grupo, torneo y equipo dados.
         *
         * @param int $idJugador Identificador del jugador.
         * @param int $idGrupo Identificador del grupo.
         * @param int $idTorneo Identificador del torneo.
         * @param int $idEquipo Identificador del equipo.
         *
         * @return array|false Retorna un array asociativo con la información completa del jugador si tiene éxito, de lo contrario, devuelve false.
         */
        public function readOneJugadorComplete ($idJugador, $idGrupo, $idTorneo, $idEquipo) {
            $statement = $this->PDO->prepare ("
                                                SELECT * FROM tbljugadores 
                                                WHERE idJugador = :idJugador 
                                                AND idGrupo = :idGrupo 
                                                AND idTorneo = :idTorneo 
                                                AND idEquipo = :idEquipo
                                            ");

            $statement->bindParam(":idJugador", $idJugador);      
            $statement->bindParam(":idGrupo", $idGrupo);
            $statement->bindParam(":idTorneo", $idTorneo);
            $statement->bindParam(":idEquipo", $idEquipo);   

            return ($statement->execute ()) ? $statement->fetch (PDO::FETCH_ASSOC) : false;
        }

        /**
         * Actualiza la información de un jugador en la base de datos.
         *
         * @param int $idJugador Identificador del jugador a actualizar.
         * @param string $vNombreJugador Nuevo nombre del jugador.
         * @param string $vApellidoJugador Nuevo apellido del jugador.
         * @param string $vFechaNacimiento Nueva fecha de nacimiento del jugador (formato: YYYY-MM-DD).
         * @param string $vCorreoJugador Nuevo correo electrónico del jugador.
         * @param string $vCelularJugador Nuevo número de celular del jugador.
         * @param string $vTipoSangre Nuevo tipo de sangre del jugador.
         * @param string $vContactoEmergencia Nuevo contacto de emergencia del jugador.
         * @param string $vImgJugador Nueva ruta de la imagen del jugador.
         * @param int $idGrupo Nuevo identificador del grupo al que pertenece el jugador.
         * @param int $idTorneo Nuevo identificador del torneo.
         * @param int $idEquipo Nuevo identificador del equipo al que pertenece el jugador.
         *
         * @return int|false Retorna el ID del jugador actualizado si tiene éxito, de lo contrario, devuelve false.
         */
        public function update ($idJugador,
                                $vNombreJugador, 
                                $vApellidoJugador, 
                                $vFechaNacimiento, 
                                $vCorreoJugador, 
                                $vCelularJugador, 
                                $vTipoSangre, 
                                $vContactoEmergencia, 
                                $vImgJugador, 
                                $idGrupo, 
                                $idTorneo,
                                $idEquipo){

            $statement = $this->PDO->prepare ("
                                                UPDATE tbljugadores SET 
                                                vNombreJugador = :vNombreJugador, 
                                                vApellidoJugador = :vApellidoJugador,
                                                vFechaNacimiento = :vFechaNacimiento,
                                                vCorreoJugador = :vCorreoJugador,
                                                vCelularJugador = :vCelularJugador,
                                                vTipoSangre = :vTipoSangre,
                                                vContactoEmergencia = :vContactoEmergencia,
                                                vImgJugador = :vImgJugador,
                                                idGrupo = :idGrupo, 
                                                idTorneo = :idTorneo,
                                                idEquipo = :idEquipo
                                                WHERE idJugador = :idJugador
                                            ");

            $statement->bindParam (":idJugador",$idJugador);
            $statement->bindParam (":vNombreJugador", $vNombreJugador);
            $statement->bindParam (":vApellidoJugador", $vApellidoJugador);
            $statement->bindParam (":vFechaNacimiento", $vFechaNacimiento);
            $statement->bindParam (":vCorreoJugador", $vCorreoJugador);
            $statement->bindParam (":vCelularJugador", $vCelularJugador);
            $statement->bindParam (":vTipoSangre", $vTipoSangre);
            $statement->bindParam (":vContactoEmergencia", $vContactoEmergencia);
            $statement->bindParam (":vImgJugador", $vImgJugador);
            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);
            $statement->bindParam (":idEquipo", $idEquipo);

            return ($statement->execute ()) ? $idJugador : false;
        }

        /**
         * Elimina un jugador de la base de datos.
         *
         * @param int $idJugador Identificador del jugador a eliminar.
         *
         * @return bool Retorna true si la eliminación fue exitosa, de lo contrario, devuelve false.
         */
        public function delete ($idJugador) {
            $statement = $this->PDO->prepare ("DELETE FROM tbljugadores WHERE idJugador = :idJugador");
            $statement->bindParam (":idJugador",$idJugador);
            return ($statement->execute ()) ? true : false;
        }
    }
?>