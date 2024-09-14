<?php
    include_once (__DIR__ . '/../models/PatrocinadorModel.php');

	/* La clase patrocinadorController es responsable de manejar las operaciones CRUD para la clase
	patrocinadorModel en una aplicación PHP. */
	class patrocinadorController {

		private $model;

		/**
		 * La función es un constructor que inicializa una nueva instancia de la clase patrocinadorModel.
		 */
		public function __construct () {
			
			$this->model = new patrocinadorModel ();
		}

		/**
		 * La función insertarPatrocinador inserta un nuevo patrocinador en la base de datos y redirige al
		 * usuario a una página de éxito o error.
		 * 
		 * @param vNombrePatrocinador El nombre del patrocinador.
		 * @param vImgPatrocinador El parámetro "vImgPatrocinador" es una cadena que representa la imagen del
		 * patrocinador. Podría ser una URL o una ruta de archivo al archivo de imagen.
		 * @param idTorneo La identificación del torneo al que se agrega el patrocinador.
		 */
		public function insertarPatrocinador ($vNombrePatrocinador, $vImgPatrocinador, $idTorneo) {

			$idPatrocinador = $this->model->insert ($vNombrePatrocinador, $vImgPatrocinador, $idTorneo);

			($idPatrocinador != false) ? 
				header("Location: ../patrocinador/lstPatrocinador.php?success=inserted") : 
				header("Location: lstPatrocinador.php");
		}

		/**
		 * La función "selectAllPatrocinadores" recupera todos los patrocinadores del modelo y los devuelve.
		 * 
		 * @return la variable , que contiene a todos los patrocinadores del modelo.
		 */
		public function selectAllPatrocinadores () {

			$patrocinadores = $this->model->allPatrocinadores (); return $patrocinadores;
		}

		/**
		 * La función "selectOnePatrocinador" devuelve el resultado de leer un patrocinador del modelo, o
		 * redirige a una página diferente si el resultado es falso.
		 * 
		 * @param idPatrocinador El parámetro "idPatrocinador" es el identificador único de un patrocinador
		 * (sponsor) que se pasa a la función.
		 * 
		 * @return el resultado de la llamada al método `->model->readOnePatrocinador()`
		 * si no es falso. De lo contrario, está redirigiendo al usuario a la página "lstPatrocinador.php".
		 */
		public function selectOnePatrocinador ($idPatrocinador) {

			return ($this->model->readOnePatrocinador ($idPatrocinador) != false) ? $this->model->readOnePatrocinador ($idPatrocinador) : 
				header("Location: lstPatrocinador.php");
		}

		/**
		 * La función actualiza un patrocinador (patrocinador) en una base de datos y redirige al usuario a
		 * una página de éxito o error.
		 * 
		 * @param idPatrocinador El ID del patrocinador (sponsor) que deseas actualizar.
		 * @param vNombrePatrocinador La variable vNombrePatrocinador representa el nombre actualizado del
		 * patrocinador.
		 * @param vImgPatrocinador El parámetro "vImgPatrocinador" es una variable que representa la imagen
		 * del patrocinador. Probablemente sea una cadena que contiene la ruta del archivo o la URL de la
		 * imagen.
		 * @param idTorneo El parámetro idTorneo es el ID del torneo al que está asociado el patrocinador.
		 * 
		 * @return una redirección de ubicación del encabezado. Si la operación de actualización es exitosa,
		 * se redireccionará a "../patrocinador/lstPatrocinador.php?success=updated". Si la operación de
		 * actualización falla, se redireccionará a "lstPatrocinador.phpp".
		 */
		public function updatePatrocinador ($idPatrocinador,$vNombrePatrocinador, $vImgPatrocinador, $idTorneo) {

			return ($this->model->update ($idPatrocinador, $vNombrePatrocinador, $vImgPatrocinador, $idTorneo)) != false ? 
				header("Location: ../patrocinador/lstPatrocinador.php?success=updated") : 
				header("Location: lstPatrocinador.phpp");
		}

		/**
		 * La función de eliminación redirige al usuario a una página de éxito si la eliminación se realiza
		 * correctamente, o a la página de lista si falla.
		 * 
		 * @param idPatrocinador El parámetro "idPatrocinador" es el ID del patrocinador (sponsor) que
		 * necesita ser eliminado.
		 * 
		 * @return una ubicación de encabezado. Si la operación de eliminación tiene éxito, se redireccionará
		 * a "../patrocinador/lstPatrocinador.php?success=deleted". Si la operación de eliminación falla, se
		 * redireccionará a "lstPatrocinador.php".
		 */
		public function delete ($idPatrocinador) {

			return ($this->model->delete ($idPatrocinador)) ? 
				header("Location: ../patrocinador/lstPatrocinador.php?success=deleted") : 
				header("Location: lstPatrocinador.php");
		}
	}
?>