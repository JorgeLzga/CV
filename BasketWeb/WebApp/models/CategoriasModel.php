<?php
    include_once (__DIR__ . '/../config/dataBase.php');

	/**
	 * Modelo para la gestión de operaciones relacionadas con la tabla 'tblcategorias'.
	 */
	class categoriasModel {
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
		 * Obtiene todas las categorías de la base de datos.
		 *
		 * @return array Arreglo asociativo con todas las categorías o un arreglo vacío si hay un error.
		 */
		public function allCategorias () {
			try {
		        $statement = $this->PDO->query ("SELECT * FROM tblcategorias");

				if (!$statement) { throw new Exception ("Error en la consulta SQL");}
				$statement->execute ();
				return $statement->fetchAll (PDO::FETCH_ASSOC);

			} catch (Exception $e) {
				echo "Error: " . $e->getMessage ();
				return array (); 
			}
		}

		/**
		 * Obtiene la ID de categoría asociada a un grupo y torneo específicos.
		 *
		 * @param int $idGrupo Identificador del grupo.
		 * @param int $idTorneo Identificador del torneo.
		 *
		 * @return int|false Retorna la ID de categoría o false en caso de fallo.
		 */
		public function readOneCategoria ($idGrupo, $idTorneo) {
            $statement = $this->PDO->prepare ("SELECT idCategoria FROM tblgrupos WHERE idGrupo = :idGrupo AND idTorneo = :idTorneo");
            $statement->bindParam (":idGrupo", $idGrupo);
            $statement->bindParam (":idTorneo", $idTorneo);
            return ($statement->execute ()) ? $statement->fetchColumn () : false;
        }

		/**
		 * Obtiene la ID de categoría asociada a un evento de calendario y torneo específicos.
		 *
		 * @param int $idCalendario Identificador del evento de calendario.
		 * @param int $idTorneo Identificador del torneo.
		 *
		 * @return int|false Retorna la ID de categoría o false en caso de fallo.
		 */
        public function readOneCategoriaCalendario ($idCalendario, $idTorneo) {
            $statement = $this->PDO->prepare ("SELECT idCategoria FROM tblcalendario WHERE idCalendario = :idCalendario AND idTorneo = :idTorneo");
            $statement->bindParam (":idCalendario", $idCalendario);
            $statement->bindParam (":idTorneo", $idTorneo);
            return ($statement->execute ()) ? $statement->fetchColumn () : false;
        }
	}
?>