<?php
    include_once (__DIR__ . '/../config/dataBase.php');

    /**
     * Modelo para la gestión de operaciones relacionadas con la tabla 'tblequipos'.
     */
    class equiposModel {
        /** @var PDO $PDO Conexión a la base de datos. */
        public $PDO;

        /**
         * Constructor de la clase que inicializa la conexión a la base de datos.
         */
        public function __construct () {
            $vConexion = new DataBase ();
            $this->PDO = $vConexion->getConexion ();
        }

        /**
         * Inserta un nuevo equipo en la base de datos.
         *
         * @param string $vNombreEquipo Nombre del equipo.
         * @param string $vImgEquipo Ruta de la imagen del equipo.
         * @param string $vNombreCapitan Nombre del capitán del equipo.
         * @param string $vCorreoCapitan Correo electrónico del capitán del equipo.
         * @param string $vCelularCapitan Número de celular del capitán del equipo.
         * @param int $idGrupo Identificador del grupo al que pertenece el equipo.
         * @param int $idTorneo Identificador del torneo al que pertenece el equipo.
         *
         * @return int|false Retorna el ID del equipo insertado o false en caso de fallo.
         */
        public function insert ($vNombreEquipo, $vImgEquipo, $vNombreCapitan, $vCorreoCapitan, $vCelularCapitan, $idGrupo, $idTorneo) {
            $statement = $this->PDO->prepare("
                                                INSERT INTO tblequipos
                                                (vNombreEquipo, 
                                                vImgEquipo, 
                                                vNombreCapitan,
                                                vCorreoCapitan,
                                                vCelularCapitan,
                                                idGrupo,
                                                idTorneo)

                                                VALUES 
                                                (:vNombreEquipo, 
                                                :vImgEquipo, 
                                                :vNombreCapitan,
                                                :vCorreoCapitan,
                                                :vCelularCapitan,
                                                :idGrupo,
                                                :idTorneo)
                                            ");

            $statement->bindParam (":vNombreEquipo", $vNombreEquipo);
            $statement->bindParam (":vImgEquipo", $vImgEquipo);
            $statement->bindParam (":vNombreCapitan", $vNombreCapitan);
            $statement->bindParam (":vCorreoCapitan", $vCorreoCapitan);
            $statement->bindParam (":vCelularCapitan", $vCelularCapitan);
            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $this->PDO->lastInsertId () : false;
        }

        /**
         * Obtiene la información de un equipo específico en función del grupo y torneo.
         *
         * @param int $idGrupo Identificador del grupo al que pertenece el equipo.
         * @param int $idTorneo Identificador del torneo al que pertenece el equipo.
         *
         * @return array|false Retorna un arreglo asociativo con la información del equipo o false en caso de fallo.
         */
        public function readOneEquipo ($idGrupo, $idTorneo) {
            $statement = $this->PDO->prepare ("SELECT * FROM tblequipos WHERE idGrupo = :idGrupo AND idTorneo = :idTorneo ORDER BY vNombreEquipo ASC");
            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);
            return ($statement->execute ()) ? $statement->fetchAll () : false;
        }

        /**
         * Obtiene la información completa de un equipo específico.
         *
         * @param int $idEquipo Identificador del equipo.
         * @param int $idGrupo Identificador del grupo al que pertenece el equipo.
         * @param int $idTorneo Identificador del torneo al que pertenece el equipo.
         *
         * @return array|false Retorna un arreglo asociativo con la información completa del equipo o false en caso de fallo.
         */
        public function readOneEquipoComplete ($idEquipo, $idGrupo, $idTorneo) {
            $statement = $this->PDO->prepare ("SELECT * FROM tblequipos WHERE idEquipo = :idEquipo AND idGrupo = :idGrupo AND idTorneo = :idTorneo");
            $statement->bindParam (":idEquipo", $idEquipo);
            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);
            return ($statement->execute ()) ? $statement->fetch (PDO::FETCH_ASSOC) : false;
        }

        /**
         * Actualiza la información de un equipo existente en la base de datos.
         *
         * @param int $idEquipo Identificador del equipo a actualizar.
         * @param string $vNombreEquipo Nuevo nombre del equipo.
         * @param string $vImgEquipo Nueva ruta de la imagen del equipo.
         * @param string $vNombreCapitan Nuevo nombre del capitán del equipo.
         * @param string $vCorreoCapitan Nuevo correo electrónico del capitán del equipo.
         * @param string $vCelularCapitan Nuevo número de celular del capitán del equipo.
         * @param int $idGrupo Nuevo identificador del grupo al que pertenece el equipo.
         * @param int $idTorneo Nuevo identificador del torneo al que pertenece el equipo.
         *
         * @return int|false Retorna el ID del equipo actualizado o false en caso de fallo.
         */
        public function update ($idEquipo, $vNombreEquipo, $vImgEquipo, $vNombreCapitan, $vCorreoCapitan, $vCelularCapitan, $idGrupo, $idTorneo) {
            $statement = $this->PDO->prepare ("
                                                UPDATE tblequipos SET 
                                                vNombreEquipo = :vNombreEquipo, 
                                                vImgEquipo = :vImgEquipo,
                                                vNombreCapitan = :vNombreCapitan,
                                                vCorreoCapitan = :vCorreoCapitan,
                                                vCelularCapitan = :vCelularCapitan,
                                                idGrupo = :idGrupo, 
                                                idTorneo = :idTorneo 
                                                WHERE idEquipo = :idEquipo
                                            ");

            $statement->bindParam (":idEquipo",$idEquipo);
            $statement->bindParam (":vNombreEquipo", $vNombreEquipo);
            $statement->bindParam (":vImgEquipo", $vImgEquipo);
            $statement->bindParam (":vNombreCapitan", $vNombreCapitan);
            $statement->bindParam (":vCorreoCapitan", $vCorreoCapitan);
            $statement->bindParam (":vCelularCapitan", $vCelularCapitan);
            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $idEquipo : false;
        }

        /**
         * Elimina un equipo de la base de datos.
         *
         * @param int $idEquipo Identificador del equipo que se eliminará.
         *
         * @return bool Retorna true si la eliminación fue exitosa, o false en caso de fallo.
         */
        public function delete ($idEquipo){
            $statement = $this->PDO->prepare ("DELETE FROM tblequipos WHERE idEquipo = :idEquipo");
            $statement->bindParam (":idEquipo",$idEquipo);
            return ($statement->execute ()) ? true : false;
        }

        /**
         * Obtiene todos los equipos directamente asociados a un torneo específico Header.
         *
         * Este método ejecuta una consulta SQL para recuperar la información de los equipos
         * que están directamente asociados a un torneo específico.
         *
         * @param int $idTorneo El ID del torneo del cual se quieren recuperar los equipos.
         * @return array Un array con la información de los equipos asociados al torneo o un array vacío si no hay equipos.
         */
        public function allEquiposDirect($idTorneo) {
            $statement = $this->PDO->prepare("SELECT idEquipo, vNombreEquipo FROM tblequipos WHERE idTorneo = :idTorneo");
            $statement->bindParam(':idTorneo', $idTorneo);
            $statement->execute();
            $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultados;
        }
    }
?>