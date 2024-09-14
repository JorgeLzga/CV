<?php
	include_once (__DIR__ . '/../models/CategoriasModel.php');

	/* La clase categoriasController es responsable de manejar solicitudes relacionadas con categorías e
	interactuar con la clase categoriasModel. */
	class categoriasController{
		private $model;

		/**
		 * La función constructora inicializa una nueva instancia de la clase categoriasModel.
		 */
		public function __construct () {

			$this->model = new categoriasModel ();
		}

		/**
		 * La función selectAllCategorias recupera todas las categorías del modelo.
		 * 
		 * @return todas las categorías.
		 */
		public function selectAllCategorias () {

			$categorias = $this->model->allCategorias ();
			return $categorias;

		}

		/**
		 * La función selectOneCategoria recupera una única categoría basada en los ID de grupo y torneo
		 * proporcionados.
		 * 
		 * @param idGrupo La identificación del grupo.
		 * @param idTorneo El parámetro idTorneo es el ID del torneo. Se utiliza para identificar un torneo
		 * específico en la base de datos.
		 * 
		 * @return el resultado de la llamada al método `->model->readOneCategoria(,
		 * )`.
		 */
		public function selectOneCategoria ($idGrupo, $idTorneo) {

			return $this->model->readOneCategoria ($idGrupo, $idTorneo);
		}

		/**
		 * La función selectOneCategoriaCalendario recupera una sola categoría de la base de datos según el
		 * calendario y los ID de torneo proporcionados.
		 * 
		 * @param idCalendario La identificación del calendario.
		 * @param idTorneo El parámetro idTorneo es el ID del torneo. Se utiliza para identificar un torneo
		 * específico en la base de datos.
		 * 
		 * @return el resultado de la llamada al método
		 * `->model->readOneCategoriaCalendario(, )`.
		 */
		public function selectOneCategoriaCalendario ($idCalendario, $idTorneo) {

			return $this->model->readOneCategoriaCalendario ($idCalendario, $idTorneo);
			
		}
	}
?>