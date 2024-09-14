<?php
    include_once (__DIR__ . '/../models/EquiposModel.php');

	/* La clase equiposController es responsable de manejar operaciones CRUD para equipos en una
	aplicación PHP. */
	class equiposController {
		private $model;

		/**
		 * La función constructora inicializa una nueva instancia de la clase equiposModel.
		 */
		public function __construct () {

			$this->model = new equiposModel ();
		}

		/**
		 * La función "insertarEquipo" inserta un nuevo equipo en una base de datos y redirige al usuario a
		 * una página específica en función del éxito o fracaso de la inserción.
		 * 
		 * @param vNombreEquipo El nombre del equipo.
		 * @param vImgEquipo Es probable que el parámetro "vImgEquipo" sea una cadena que represente el
		 * nombre del archivo de imagen o la URL de la imagen del equipo. Podría ser una ruta al archivo de
		 * imagen en el servidor o una URL que apunte a la ubicación de la imagen en Internet.
		 * @param vNombreCapitan El nombre del capitán del equipo.
		 * @param vCorreoCapitan El parámetro "vCorreoCapitan" es la dirección de correo electrónico del
		 * capitán del equipo.
		 * @param vCelularCapitan El parámetro "vCelularCapitan" es el número de teléfono móvil/celular del
		 * capitán del equipo.
		 * @param idGrupo La identificación del grupo al que pertenece el equipo.
		 * @param idTorneo El id del torneo al que pertenece el equipo.
		 */
		
		public function insertarEquipo ($vNombreEquipo, 
										$vImgEquipo, 
										$vNombreCapitan, 
										$vCorreoCapitan, 
										$vCelularCapitan, 
										$idGrupo, 
										$idTorneo) {
		
			$idEquipo = $this->model->insert ($vNombreEquipo, 
											$vImgEquipo, 
											$vNombreCapitan, 
											$vCorreoCapitan, 
											$vCelularCapitan, 
											$idGrupo, 
											$idTorneo);

			($idEquipo != false) ? 
				header("Location: ../grupo/infoGrupo.php?idTorneo=$idTorneo&idGrupo=$idGrupo&success=inserted") : 
				header("Location: infoGrupo.php");
		}

		/**
		 * La función "selectOneEquipo" recupera información sobre un equipo específico en función de los ID
		 * del grupo y del torneo.
		 * 
		 * @param idGrupo La identificación del grupo al que pertenece el equipo.
		 * @param idTorneo El parámetro idTorneo representa el ID de un torneo.
		 * 
		 * @return la información de un solo equipo (equipo) según el ID de grupo (idGrupo) y el ID de torneo
		 * (idTorneo) proporcionados. Si se encuentra la información, será devuelta. De lo contrario, se
		 * devolverá una matriz vacía.
		 */
		
		public function selectOneEquipo ($idGrupo, $idTorneo) {

			$infoEquipo = $this->model->readOneEquipo($idGrupo, $idTorneo);

			if ($infoEquipo) { return $infoEquipo; } else { return []; }
		}

		/**
		 * La función selectOneEquipoComplete recupera un registro completo de un equipo específico según su
		 * ID, ID de grupo e ID de torneo.
		 * 
		 * @param idEquipo La identificación del equipo que desea seleccionar.
		 * @param idGrupo La identificación del grupo al que pertenece el equipo.
		 * @param idTorneo El parámetro idTorneo representa el ID de un torneo.
		 * 
		 * @return el resultado de la llamada al método `->model->readOneEquipoComplete (,
		 * , )`.
		 */
		public function selectOneEquipoComplete ($idEquipo, $idGrupo, $idTorneo) {

			return $this->model->readOneEquipoComplete ($idEquipo, $idGrupo, $idTorneo);
		}

		/**
		 * La función actualiza la información de un equipo y redirige al usuario a la página apropiada según
		 * el éxito de la actualización.
		 * 
		 * @param idEquipo El ID del equipo que necesita ser actualizado.
		 * @param vNombreEquipo El nombre del equipo.
		 * @param vImgEquipo El parámetro "vImgEquipo" probablemente sea una variable que contiene el archivo
		 * de imagen del equipo. Podría ser una cadena que represente la ruta del archivo o datos binarios de
		 * la imagen.
		 * @param vNombreCapitan La variable vNombreCapitan representa el nombre del capitán del equipo.
		 * @param vCorreoCapitan El parámetro "vCorreoCapitan" es la dirección de correo electrónico del
		 * capitán del equipo.
		 * @param vCelularCapitan El parámetro "vCelularCapitan" es la variable que representa el número de
		 * celular del capitán del equipo.
		 * @param idGrupo La identificación del grupo al que pertenece el equipo.
		 * @param idTorneo El id del torneo al que pertenece el equipo.
		 */
		public function updateEquipo ($idEquipo, 
									$vNombreEquipo, 
									$vImgEquipo, 
									$vNombreCapitan, 
									$vCorreoCapitan, 
									$vCelularCapitan, 
									$idGrupo, 
									$idTorneo) {

			$idEquipo = $this->model->update ($idEquipo, 
												$vNombreEquipo, 
												$vImgEquipo, 
												$vNombreCapitan, 
												$vCorreoCapitan, 
												$vCelularCapitan, 
												$idGrupo, 
												$idTorneo);

			($idEquipo != false) ? 
				header("Location: ../grupo/infoGrupo.php?idTorneo=$idTorneo&idGrupo=$idGrupo&success=updated") : 
				header("Location: infoGrupo.php");
		}

		/**
		 * La función elimina un equipo y redirige al usuario a la página apropiada según el éxito o el
		 * fracaso de la eliminación.
		 * 
		 * @param idEquipo El ID del equipo que deseas eliminar.
		 * @param idGrupo El ID del grupo al que pertenece el equipo.
		 * @param idTorneo La identificación del torneo.
		 * 
		 * @return una ubicación de encabezado. Si la operación de eliminación tiene éxito, redirigirá a
		 * "../grupo/infoGrupo.php?idTorneo=&idGrupo=&success=deleted". Si la operación de
		 * eliminación falla, redirigirá a "infoGrupo.php".
		 */
		public function delete ($idEquipo, $idGrupo, $idTorneo) {

			return ($this->model->delete ($idEquipo)) ? 
				header("Location: ../grupo/infoGrupo.php?idTorneo=$idTorneo&idGrupo=$idGrupo&success=deleted") : 
				header("Location: infoGrupo.php");
		}

		/**
		 * Selecciona todos los equipos asociados a un torneo por su ID.
		 *
		 * Esta función utiliza el modelo para recuperar todos los equipos directamente
		 * asociados a un torneo específico.
		 *
		 * @param int $idTorneo El ID del torneo del cual se quieren recuperar los equipos.
		 * @return array|null Un array con la información de los equipos o null si no se encuentran equipos.
		 */
		public function selectAllEquiposById($idTorneo) {
		    // Llama al método del modelo para recuperar los equipos del torneo.
		    $equipos = $this->model->allEquiposDirect($idTorneo);

		    // Retorna los equipos recuperados.
		    return $equipos;
		}
	}
?>