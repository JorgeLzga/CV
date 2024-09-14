<?php
	// Incluye el archivo que contiene la definición de la clase 'DataBase'.
    include_once (__DIR__ . '/../config/dataBase.php');

	/**
	 * Modelo para la gestión de operaciones relacionadas con el calendario de eventos.
	 */
	class CalendarioModel {
	    /** @var PDO $PDO Conexión a la base de datos. */
		public $PDO;

		/**
		 * Constructor de la clase. Inicializa la instancia del modelo y la conexión a la base de datos.
		 */
		public function __construct () {
			$vConexion = new DataBase ();
			$this->PDO = $vConexion->getConexion ();
		}
		

		/**
		 * Obtiene todos los eventos de calendario asociados a un torneo.
		 *
		 * @param int $idTorneo Identificador del torneo.
		 *
		 * @return array Arreglo que contiene todos los eventos de calendario del torneo.
		 */
		public function allCalendario ($idTorneo) {
			
			try {
		        $statement = $this->PDO->prepare ("SELECT * FROM tblequipos WHERE idTorneo = :idTorneo");
				$statement->bindParam (':idTorneo', $idTorneo);

				if (!$statement) { 
					throw new Exception ("Error en la preparación de la consulta SQL");
				}

				$statement->execute ();
				return $statement->fetchAll (PDO::FETCH_ASSOC);

			} catch (Exception $e) {

				echo "Error: " . $e->getMessage ();
				return array (); 
			}
		}

		/**
		 * Obtiene todos los eventos de calendario detallados asociados a un torneo.
		 *
		 * @param int $idTorneo Identificador del torneo.
		 *
		 * @return array Arreglo que contiene todos los eventos de calendario detallados del torneo.
		 */
		public function allCalendarioRead ($idTorneo) {
			try {
				$statement = $this->PDO->prepare ("
													SELECT c.*, e.vNombreEquipo AS nombreLocal, e2.vNombreEquipo AS nombreVisitante
													FROM tblcalendario c
													INNER JOIN tblequipos e ON c.vEqLocal = e.idEquipo
													INNER JOIN tblequipos e2 ON c.vEqVisitante = e2.idEquipo
													WHERE c.idTorneo = :idTorneo
													ORDER BY vFecha ASC;
												");

				$statement->bindParam(':idTorneo', $idTorneo);

				if (!$statement) { 
					throw new Exception ("Error en la preparación de la consulta SQL");
				}

				$statement->execute ();
					return $statement->fetchAll (PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				echo "Error: " . $e->getMessage ();
				return array (); 
			}
		}
		
		/**
		 * Obtiene todos los eventos de calendario detallados asociados a un torneo y una fecha específica.
		 *
		 * @param int $idTorneo Identificador del torneo.
		 * @param string $fechaSeleccionada Fecha seleccionada.
		 *
		 * @return array Arreglo que contiene todos los eventos de calendario detallados del torneo y la fecha seleccionada.
		 */
		public function allCalendarioReadByFecha ($idTorneo, $fechaSeleccionada) {
			try {
				$statement = $this->PDO->prepare ("
													SELECT c.*, e.vNombreEquipo AS nombreLocal, e2.vNombreEquipo AS nombreVisitante
													FROM tblcalendario c
													INNER JOIN tblequipos e ON c.vEqLocal = e.idEquipo
													INNER JOIN tblequipos e2 ON c.vEqVisitante = e2.idEquipo
													WHERE c.idTorneo = :idTorneo AND c.vFecha = :fechaSeleccionada
													ORDER BY vFecha ASC
												");

				$statement->bindParam (':idTorneo', $idTorneo);
				$statement->bindParam (':fechaSeleccionada', $fechaSeleccionada);

				if (!$statement) { 
					throw new Exception ("Error en la preparación de la consulta SQL");
				}

				$statement->execute ();
				return $statement->fetchAll (PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				echo "Error: " . $e->getMessage ();
				return array (); 
			}
		}

		/**
		 * Inserta un nuevo evento de calendario en la base de datos.
		 *
		 * @param string $vEqLocal Nombre del equipo local.
		 * @param string $vEqVisitante Nombre del equipo visitante.
		 * @param string $vFecha Fecha del evento.
		 * @param string $vHora Hora del evento.
		 * @param string $vSede Sede del evento.
		 * @param int $idCategoria Identificador de la categoría del evento.
		 * @param string $vTipoJuego Tipo de juego del evento.
		 * @param int $idTorneo Identificador del torneo asociado al evento.
		 *
		 * @return int|false Retorna el identificador del evento insertado o false en caso de fallo.
		 */
		public function insert ($vEqLocal, $vEqVisitante, $vFecha, $vHora, $vSede, $idCategoria, $vTipoJuego, $idTorneo) {
            $statement = $this->PDO->prepare ("
                                                INSERT INTO tblcalendario
                                                (vEqLocal, 
                                                vEqVisitante, 
                                                vFecha,
                                                vHora,
                                                vSede,
                                                idCategoria,
                                                vTipoJuego,
                                                idTorneo)

                                                VALUES 
                                                (:vEqLocal, 
                                                :vEqVisitante, 
                                                :vFecha,
                                                :vHora,
                                                :vSede,
                                                :idCategoria,
                                                :vTipoJuego,
                                                :idTorneo)
                                            ");

            $statement->bindParam (":vEqLocal", $vEqLocal);
            $statement->bindParam (":vEqVisitante", $vEqVisitante);
            $statement->bindParam (":vFecha", $vFecha);
            $statement->bindParam (":vHora", $vHora);
            $statement->bindParam (":vSede", $vSede);
            $statement->bindParam (":idCategoria", $idCategoria);
            $statement->bindParam ("vTipoJuego",$vTipoJuego);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $this->PDO->lastInsertId () : false;
        }

		/**
		 * Obtiene la información completa de un evento de calendario.
		 *
		 * @param int $idCalendario Identificador del evento de calendario.
		 * @param int $idTorneo Identificador del torneo asociado al evento de calendario.
		 *
		 * @return array|false Retorna la información completa del evento de calendario o false en caso de fallo.
		 */
		public function readOneCalendarioComplete ($idCalendario, $idTorneo) {
			try {
				$statement = $this->PDO->prepare ("
					SELECT c.*, e.vNombreEquipo AS nombreLocal, e2.vNombreEquipo AS nombreVisitante
					FROM tblcalendario c
					INNER JOIN tblequipos e ON c.vEqLocal = e.idEquipo
					INNER JOIN tblequipos e2 ON c.vEqVisitante = e2.idEquipo
					WHERE c.idCalendario = :idCalendario AND c.idTorneo = :idTorneo
				");
				
				$statement->bindParam (":idCalendario", $idCalendario);
				$statement->bindParam (":idTorneo", $idTorneo);

				if (!$statement) { 
					throw new Exception ("Error en la preparación de la consulta SQL");
				}

				$statement->execute ();
				return $statement->fetch (PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				echo "Error: " . $e->getMessage ();
				return false;
			}
		}

		/**
		 * Actualiza un evento de calendario en la base de datos.
		 *
		 * @param int $idCalendario Identificador del evento de calendario.
		 * @param string $vEqLocal Nombre del equipo local.
		 * @param string $vEqVisitante Nombre del equipo visitante.
		 * @param string $vHora Hora del evento.
		 * @param string $vFecha Fecha del evento.
		 * @param string $vSede Sede del evento.
		 * @param int $idCategoria Identificador de la categoría del evento.
		 * @param string $vTipoJuego Tipo de juego del evento.
		 * @param int $idTorneo Identificador del torneo asociado al evento.
		 *
		 * @return int|false Retorna el identificador del evento actualizado o false en caso de fallo.
		 */
        public function update ($idCalendario, $vEqLocal, $vEqVisitante, $vHora, $vFecha, $vSede, $idCategoria, $vTipoJuego, $idTorneo) {
        $statement = $this->PDO->prepare ("
											UPDATE tblcalendario SET 
											vEqLocal = :vEqLocal,
											vEqVisitante = :vEqVisitante,
											vHora = :vHora,
											vFecha = :vFecha,
											vSede = :vSede,
											idCategoria = :idCategoria,
											vTipoJuego = :vTipoJuego,
											idTorneo = :idTorneo
											WHERE idCalendario = :idCalendario
                                            ");

			$statement->bindParam (":idCalendario", $idCalendario);
			$statement->bindParam (":vEqLocal", $vEqLocal);
			$statement->bindParam (":vEqVisitante", $vEqVisitante);
			$statement->bindParam (":vHora", $vHora);
			$statement->bindParam (":vFecha", $vFecha);
			$statement->bindParam (":vSede", $vSede);
			$statement->bindParam (":idCategoria", $idCategoria);
			$statement->bindParam (":vTipoJuego", $vTipoJuego);
			$statement->bindParam (":idTorneo", $idTorneo);

			return ($statement->execute ()) ? $idCalendario : false;
        }

		/**
		 * Elimina un evento de calendario de la base de datos.
		 *
		 * @param int $idCalendario Identificador del evento de calendario a eliminar.
		 *
		 * @return bool Retorna true si la eliminación fue exitosa, false en caso contrario.
		 */
        public function delete ($idCalendario) {

			$statement = $this->PDO->prepare ("DELETE FROM tblcalendario WHERE idCalendario = :idCalendario");
			$statement->bindParam (":idCalendario", $idCalendario);
			
			return $statement->execute ();
		}
	}
?>