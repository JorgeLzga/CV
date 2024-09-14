<?php
    include_once (__DIR__ . '/../config/dataBase.php');

	/* La clase gruposModel es una clase PHP que maneja operaciones de bases de datos relacionadas con
    grupos en un torneo. */
    class gruposModel{

		public $PDO;

		/**
         * La función crea una nueva instancia de la clase DataBase y asigna la propiedad PDO al objeto de
         * conexión.
         */
        public function __construct () {
			$vConexion = new DataBase ();
			$this->PDO = $vConexion->getConexion ();
		}

		/**
         * La función inserta un nuevo registro en la tabla "tblgrupos" con los valores proporcionados para
         * "vNombreGrupo", "idCategoria" e "idTorneo".
         * 
         * @param vNombreGrupo El parámetro "vNombreGrupo" es una cadena que representa el nombre del grupo.
         * Se utiliza para insertar el nombre del grupo en la tabla "tblgrupos" de la base de datos.
         * @param idCategoria El parámetro "idCategoria" es el ID de la categoría a la que pertenece el
         * grupo. Se utiliza para especificar la categoría del grupo al insertarlo en la base de datos.
         * @param idTorneo El parámetro "idTorneo" representa el ID del torneo al que pertenece el grupo.
         * 
         * @return el último ID insertado si la ejecución de la instrucción SQL es exitosa. De lo contrario,
         * devuelve falso.
         */
        public function insert ($vNombreGrupo, $idCategoria, $idTorneo) {
            $statement = $this->PDO->prepare ("
                                                INSERT INTO tblgrupos
                                                (vNombreGrupo, 
                                                idCategoria, 
                                                idTorneo)

                                                VALUES 
                                                (:vNombreGrupo, 
                                                :idCategoria, 
                                                :idTorneo)
                                            ");

            $statement->bindParam (":vNombreGrupo", $vNombreGrupo);
            $statement->bindParam (":idCategoria", $idCategoria);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $this->PDO->lastInsertId () : false;
        }

        /**
         * La función "allGrupos" recupera todas las filas de la tabla "tblgrupos" en una aplicación
         * PHP.
         * 
         * @return el resultado de la consulta SQL que son todas las filas de la tabla "tblgrupos".
         */
        public function allGrupos () {
            $statement = $this->PDO->prepare ("SELECT * FROM tblgrupos");

            return ($statement->execute ()) ? $statement->fetchAll () : false;
        }

        /**
         * La función "readOneGrupo" recupera una sola fila de la tabla "tblgrupos" en función de los
         * parámetros "idGrupo" e "idTorneo" proporcionados.
         * 
         * @param idGrupo El parámetro idGrupo es el identificador único del grupo que desea recuperar
         * de la base de datos. Se utiliza en la cláusula WHERE de la consulta SQL para filtrar los
         * resultados en función de este valor.
         * @param idTorneo El parámetro "idTorneo" es el ID del torneo al que pertenece el grupo.
         * 
         * @return el resultado de la ejecución de la consulta. Si la consulta tiene éxito, devolverá
         * la fila recuperada de la tabla de la base de datos. Si la consulta falla, devolverá falso.
         */
        public function readOneGrupo ($idGrupo, $idTorneo) {
            $statement = $this->PDO->prepare ("SELECT * FROM tblgrupos WHERE idGrupo = :idGrupo AND idTorneo = :idTorneo");
            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $statement->fetch() : false;
        }

        /**
         * La función "readOneGrupoComplete" recupera todos los grupos y sus categorías
         * correspondientes para un ID de torneo determinado.
         * 
         * @param idTorneo El parámetro "idTorneo" es el ID del torneo del cual deseas recuperar la
         * información completa de un grupo.
         * 
         * @return el resultado de la ejecución de la consulta. Si la consulta se ejecuta
         * correctamente, devolverá una matriz que contiene todas las filas extraídas de la base de
         * datos. Si la consulta no se ejecuta, devolverá falso.
         */
        public function readOneGrupoComplete ($idTorneo) {
            $statement = $this->PDO->prepare ("
                                                SELECT g.*, c.*
                                                FROM tblgrupos g
                                                INNER JOIN tbltorneos t ON g.idTorneo = t.idTorneo
                                                INNER JOIN tblcategorias c ON g.idCategoria = c.idCategoria
                                                WHERE g.idTorneo = :idTorneo
                                                ORDER BY g.vNombreGrupo ASC
                                            ");

            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $statement->fetchAll () : false;
        }

        /**
         * La función actualiza un registro en la tabla "tblgrupos" con los parámetros dados.
         * 
         * @param idGrupo El parámetro "idGrupo" es el identificador único del grupo que desea
         * actualizar. Se utiliza en la cláusula WHERE de la consulta SQL para especificar qué grupo
         * debe actualizarse.
         * @param vNombreGrupo El parámetro "vNombreGrupo" es el nuevo nombre del grupo que deseas
         * actualizar.
         * @param idCategoria El parámetro "idCategoria" es el ID de la categoría a la que pertenece el
         * grupo. Se utiliza para actualizar el campo "idCategoria" en la tabla "tblgrupos".
         * @param idTorneo El parámetro "idTorneo" es el ID del torneo al que pertenece el grupo.
         * 
         * @return el valor de  si la consulta de actualización se ejecuta correctamente. De lo
         * contrario, devolverá falso.
         */
        public function update ($idGrupo, $vNombreGrupo, $idCategoria, $idTorneo) {
            $statement = $this->PDO->prepare ("
                                                UPDATE tblgrupos SET 
                                                vNombreGrupo = :vNombreGrupo, 
                                                idCategoria = :idCategoria, 
                                                idTorneo = :idTorneo 
                                                WHERE idGrupo = :idGrupo
                                            ");

            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":vNombreGrupo", $vNombreGrupo);
            $statement->bindParam (":idCategoria", $idCategoria);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $idGrupo : false;
        }

        /**
         * La función elimina un registro de la tabla "tblgrupos" según el parámetro "idGrupo"
         * proporcionado.
         * 
         * @param idGrupo El parámetro "idGrupo" es el ID del grupo que se desea eliminar de la tabla
         * "tblgrupos".
         * 
         * @return un valor booleano. Si la ejecución de la declaración de eliminación es exitosa,
         * devolverá verdadero. De lo contrario, devolverá falso.
         */
        public function delete ($idGrupo) {
            $statement = $this->PDO->prepare ("DELETE FROM tblgrupos WHERE idGrupo = :idGrupo");
            $statement->bindParam (":idGrupo",$idGrupo);

            return ($statement->execute ()) ? true : false;
        }

        /**
         * La función "obtenerNombreCategoria" devuelve el nombre de una categoría en función de su ID.
         * 
         * @param idCategoria El parámetro "idCategoria" es el ID de la categoría de la que queremos
         * obtener el nombre.
         * 
         * @return the variable .
         */
        public function obtenerNombreCategoria ($idCategoria) {
            
            return $nombreCategoria;
        }

        /**
         * Obtiene todos los grupos directamente asociados a un torneo específico.
         *
         * Este método ejecuta una consulta SQL para recuperar la información de los grupos
         * que están directamente asociados a un torneo específico.
         *
         * @param int $idTorneo El ID del torneo del cual se quieren recuperar los grupos.
         * @return array Un array con la información de los grupos asociados al torneo o un array vacío si no hay grupos.
         */
        public function allGruposDirect($idTorneo) {
            $statement = $this->PDO->prepare("SELECT idGrupo, vNombreGrupo FROM tblgrupos WHERE idTorneo = :idTorneo");
            $statement->bindParam(':idTorneo', $idTorneo);
            $statement->execute();
            $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultados;
        }

	}
?>