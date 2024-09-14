<?php
	// Incluye el archivo que contiene la definición de la clase 'JugadoresModel'.
    include_once (__DIR__ . '/../models/JugadoresModel.php');

	/**
	 * Controlador para la gestión de jugadores.
	 */
	class jugadoresController {
		private $model;

		/**
		 * Constructor de la clase. Inicializa la instancia del modelo 'JugadoresModel'.
		 */
		public function __construct () {

			$this->model = new jugadoresModel ();
		}

		/**
		 * Inserta un nuevo jugador en la base de datos.
		 *
		 * @param string $vNombreJugador Nombre del jugador.
		 * @param string $vApellidoJugador Apellido del jugador.
		 * @param string $vFechaNacimiento Fecha de nacimiento del jugador.
		 * @param string $vCorreoJugador Correo electrónico del jugador.
		 * @param string $vCelularJugador Número de celular del jugador.
		 * @param string $vTipoSangre Tipo de sangre del jugador.
		 * @param string $vContactoEmergencia Información de contacto de emergencia del jugador.
		 * @param string $vImgJugador Ruta de la imagen del jugador.
		 * @param int $idGrupo Identificador del grupo al que pertenece el jugador.
		 * @param int $idTorneo Identificador del torneo al que pertenece el jugador.
		 * @param int $idEquipo Identificador del equipo al que pertenece el jugador.
		 *
		 * @return mixed|false Retorna el identificador del jugador insertado o false si falla.
		 */
		public function insertarJugadores ($vNombreJugador, 
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
		
			$idJugador = $this->model->insert ($vNombreJugador, 
												$vApellidoJugador, 
												$vFechaNacimiento, 
												$vCorreoJugador, 
												$vCelularJugador, 
												$vTipoSangre, 
												$vContactoEmergencia, 
												$vImgJugador,
												$idGrupo, 
												$idTorneo, 
												$idEquipo);

			// Redirecciona según el resultado de la inserción.
			($idJugador != false) ?  
				header("Location: ../equipo/infoEquipo.php?idTorneo=$idTorneo&idGrupo=$idGrupo&idEquipo=$idEquipo&success=inserted") : 
				header("Location: infoEquipo.php");
		}

		/**
		 * Obtiene la información de un jugador específico en un grupo, torneo y equipo determinados.
		 *
		 * @param int $idGrupo Identificador del grupo al que pertenece el jugador.
		 * @param int $idTorneo Identificador del torneo al que pertenece el jugador.
		 * @param int $idEquipo Identificador del equipo al que pertenece el jugador.
		 *
		 * @return array Arreglo que contiene la información del jugador o un arreglo vacío si no se encuentra.
		 */
		public function selectOneJugador ($idGrupo, $idTorneo, $idEquipo) {

			$infoJugador = $this->model->readOneJugador ($idGrupo, $idTorneo, $idEquipo);

			if ($infoJugador) { return $infoJugador; } else { return []; }
		}

		/**
		 * Obtiene la información completa de un jugador específico.
		 *
		 * @param int $idJugador Identificador del jugador.
		 * @param int $idGrupo Identificador del grupo al que pertenece el jugador.
		 * @param int $idTorneo Identificador del torneo al que pertenece el jugador.
		 * @param int $idEquipo Identificador del equipo al que pertenece el jugador.
		 *
		 * @return array Arreglo que contiene la información completa del jugador.
		 */
		public function selectOneJugadorComplete ($idJugador, $idGrupo, $idTorneo, $idEquipo) {

			return $this->model->readOneJugadorComplete ($idJugador, $idGrupo, $idTorneo, $idEquipo);
		}

		/**
		 * Actualiza los datos de un jugador en la base de datos.
		 *
		 * @param int $idJugador Identificador del jugador a actualizar.
		 * @param string $vNombreJugador Nuevo nombre del jugador.
		 * @param string $vApellidoJugador Nuevo apellido del jugador.
		 * @param string $vFechaNacimiento Nueva fecha de nacimiento del jugador.
		 * @param string $vCorreoJugador Nuevo correo electrónico del jugador.
		 * @param string $vCelularJugador Nuevo número de celular del jugador.
		 * @param string $vTipoSangre Nuevo tipo de sangre del jugador.
		 * @param string $vContactoEmergencia Nueva información de contacto de emergencia del jugador.
		 * @param string $vImgJugador Nueva ruta de la imagen del jugador.
		 * @param int $idGrupo Nuevo identificador del grupo al que pertenece el jugador.
		 * @param int $idTorneo Nuevo identificador del torneo al que pertenece el jugador.
		 * @param int $idEquipo Nuevo identificador del equipo al que pertenece el jugador.
		 *
		 * @return mixed|false Retorna el identificador del jugador actualizado o false si falla.
		 */
		public function updateJugador ($idJugador, 
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
										$idEquipo) {

			$idJugador = $this->model->update ($idJugador, 
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
												$idEquipo);

			// Redirecciona según el resultado de la actualización.
			($idJugador != false) ? 
				header("Location: ../equipo/infoEquipo.php?idTorneo=$idTorneo&idGrupo=$idGrupo&idEquipo=$idEquipo&success=updated") : 
				header("Location: infoEquipo.php");
		}

		/**
		 * Elimina un jugador de la base de datos.
		 *
		 * @param int $idJugador Identificador del jugador a eliminar.
		 * @param int $idEquipo Identificador del equipo al que pertenece el jugador.
		 * @param int $idGrupo Identificador del grupo al que pertenece el jugador.
		 * @param int $idTorneo Identificador del torneo al que pertenece el jugador.
		 *
		 * @return void Redirecciona a la página de información del equipo con un mensaje de éxito o redirecciona a la página principal del equipo en caso de error.
		 */
		public function delete ($idJugador, $idEquipo, $idGrupo, $idTorneo) {
			
			return ($this->model->delete ($idJugador)) ? 
				header("Location: ../equipo/infoEquipo.php?idTorneo=$idTorneo&idGrupo=$idGrupo&idEquipo=$idEquipo&success=deleted") : 
				header("Location: infoEquipo.php");
		}
	}
?>