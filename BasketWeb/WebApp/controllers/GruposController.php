<?php
    include_once (__DIR__ . '/../models/GruposModel.php');

	/* La clase gruposController es responsable de manejar operaciones CRUD para grupos en una aplicación
	PHP. */
	class gruposController {

		private $model;

		/**
		 * La función constructora inicializa una nueva instancia de la clase gruposModel.
		 */
		public function __construct () {
			
			$this->model = new gruposModel ();
		}

		/**
		 * La función "insertarGrupos" inserta un nuevo grupo en la base de datos y redirige al usuario a una
		 * página que muestra la lista de grupos para un torneo específico.
		 * 
		 * @param vNombreGrupo El nombre del grupo que se insertará.
		 * @param idCategoria La identificación de la categoría a la que pertenece el grupo.
		 * @param idTorneo El parámetro idTorneo representa el ID del torneo al que pertenece el grupo.
		 */
		public function insertarGrupos ($vNombreGrupo, $idCategoria, $idTorneo) {		
			$idGrupo = $this->model->insert ($vNombreGrupo, $idCategoria, $idTorneo);

			($idGrupo != false) ?  
				header("Location: ../grupo/lstGrupo.php?idTorneo=$idTorneo&success=inserted"): 
				header("Location: ../grupo/lstGrupo.php?idTorneo=$idTorneo");
		}

		/**
		 * La función selectAllGrupos recupera todos los grupos del modelo.
		 * 
		 * @return la variable , que contiene el resultado de llamar al método allGrupos() sobre el
		 * objeto modelo.
		 */
		public function selectAllGrupos () {

			$grupos = $this->model->allGrupos (); return $grupos;
		}

		/**
		 * La función "selectOneGrupo" recupera información sobre un grupo específico en un torneo según el
		 * ID del grupo y el ID del torneo proporcionados.
		 * 
		 * @param idGrupo La identificación del grupo que desea seleccionar.
		 * @param idTorneo El parámetro idTorneo representa el ID de un torneo.
		 * 
		 * @return la información de un grupo específico en un torneo. Si se encuentra la información,
		 * devolverá la información del grupo. Si no se encuentra la información, devolverá una matriz vacía.
		 */
		public function selectOneGrupo ($idGrupo, $idTorneo) {

			$infoGrupo = $this->model->readOneGrupo ($idGrupo, $idTorneo);

			if ($infoGrupo) { return $infoGrupo; } else { return []; }
		}

		/**
		 * La función "selectOneGrupoComplete" recupera un registro de grupo completo según el ID de grupo
		 * proporcionado.
		 * 
		 * @param idGrupo La identificación del grupo que desea seleccionar.
		 * 
		 * @return el valor de la variable  si no es falso. Si  es falso,
		 * entonces se devuelve un array vacío.
		 */
		public function selectOneGrupoComplete ($idGrupo) {

			$grupoCompleto = $this->model->readOneGrupoComplete ($idGrupo);

			return ($grupoCompleto !== false) ? $grupoCompleto : [];
		}

		/**
		 * La función actualiza la información de un grupo en una base de datos y redirige al usuario a una
		 * página que muestra el grupo actualizado.
		 * 
		 * @param idGrupo El ID del grupo que debe actualizarse.
		 * @param vNombreGrupo El parámetro "vNombreGrupo" es una cadena que representa el nombre actualizado
		 * del grupo.
		 * @param idCategoria El parámetro idCategoria es el ID de la categoría a la que pertenece el grupo.
		 * @param idTorneo El parámetro idTorneo es el ID del torneo al que pertenece el grupo.
		 */
		public function updateGrupo ($idGrupo, $vNombreGrupo, $idCategoria, $idTorneo) {

			$idGrupo = $this->model->update ($idGrupo, $vNombreGrupo, $idCategoria, $idTorneo);

			($idGrupo != false) ?  
				header("Location: ../grupo/lstGrupo.php?idTorneo=$idTorneo&success=updated"): 
				header("Location: ../grupo/lstGrupo.php?idTorneo=$idTorneo");
		}

		/**
		 * La función elimina un grupo y redirige al usuario a la página de lista de grupos con un mensaje de
		 * éxito si la eliminación se realiza correctamente.
		 * 
		 * @param idGrupo La identificación del grupo que debe eliminarse.
		 * @param idTorneo La identificación del torneo al que pertenece el grupo.
		 * 
		 * @return una redirección de ubicación del encabezado. Si la operación de eliminación tiene éxito,
		 * redirigirá a "../grupo/lstGrupo.php?idTorneo=&success=deleted". Si la operación de
		 * eliminación falla, redirigirá a "../grupo/lstGrupo.php?idTorneo=".
		 */
		public function delete ($idGrupo, $idTorneo) {
			
			return ($this->model->delete ($idGrupo)) ? 
				header("Location: ../grupo/lstGrupo.php?idTorneo=$idTorneo&success=deleted") :
				header("Location: ../grupo/lstGrupo.php?idTorneo=$idTorneo");
		}

		/**
		 * Selecciona todos los grupos asociados a un torneo por su ID.
		 *
		 * Esta función utiliza el modelo para recuperar todos los grupos directamente
		 * asociados a un torneo específico.
		 *
		 * @param int $idTorneo El ID del torneo del cual se quieren recuperar los grupos.
		 * @return array|null Un array con la información de los grupos o null si no se encuentran grupos.
		 */
		public function selectAllGruposById($idTorneo) {
		    // Llama al método del modelo para recuperar los grupos del torneo.
		    $grupos = $this->model->allGruposDirect($idTorneo);

		    // Retorna los grupos recuperados.
		    return $grupos;
		}

	}
?>