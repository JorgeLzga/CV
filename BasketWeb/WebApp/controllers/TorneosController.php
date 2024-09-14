<?php
	
	//Ruta de archivo del modelo de torneos.
    include_once(__DIR__ . '/../models/TorneosModel.php');

    // Define la clase torneosController.
	class torneosController{

		// Propiedad para almacenar una instancia del modelo de torneos.
		private $model;

		// Constructor de la clase.
		public function __construct(){

			// Crea una instancia del modelo de torneos y la asigna a la propiedad de $model.
			$this->model = new torneosModel();

		}


		/**
		 * Muestra los torneos asociados a un organizador específico.
		 *
		 * Este método utiliza el modelo para seleccionar los torneos asociados a un organizador específico.
		 *
		 * @param string $vUsuarioOrganizador El nombre de usuario del organizador del cual se quieren recuperar los torneos.
		 * @return array Un array con la información de los torneos o un array vacío si no se encuentran torneos.
		 */
		public function mostrarTorneosDelOrganizador($vUsuarioOrganizador) {
		    // Llama al método del modelo para seleccionar los torneos del organizador.
		    $torneosDelOrganizador = $this->model->selectTorneosByOrganizador($vUsuarioOrganizador);

		    // Retorna los torneos si existen, de lo contrario, retorna un array vacío.
		    return ($torneosDelOrganizador !== false) ? $torneosDelOrganizador : [];
		}


	    /**
		 * Muestra los torneos asociados a un administrador por su ID.
		 *
		 * Esta función utiliza el modelo para recuperar los torneos asociados a un administrador específico.
		 *
		 * @param int $idTorneo El ID del administrador del cual se quieren recuperar los torneos.
		 * @return array Un array con la información de los torneos o un array vacío si no se encuentran torneos.
		 */
		public function mostrarTorneosDelAdministrador($idTorneo) {
		    // Llama al método del modelo para recuperar los torneos asociados al administrador.
		    $torneos = $this->model->selectTorneosByAdmin($idTorneo);

		    // Verifica si se recuperaron torneos, devuelve el array de torneos o un array vacío.
		    return ($torneos !== false) ? $torneos : [];
		}

		/**
		 * Inserta un nuevo torneo en la base de datos.
		 *
		 * Este método realiza la inserción de un nuevo torneo utilizando los parámetros proporcionados.
		 * Antes de la inserción, verifica si el organizador ya existe en la base de datos.
		 *
		 * @param string $vNombreTorneo El nombre del torneo a ser insertado.
		 * @param string $vImagenTorneo La ruta de la imagen asociada al torneo.
		 * @param string $vSedeTorneo La sede o ubicación del torneo.
		 * @param string $vPremio01 Descripción del primer premio.
		 * @param string $vPremio02 Descripción del segundo premio.
		 * @param string $vPremio03 Descripción del tercer premio.
		 * @param string $vOtroPremio Otra descripción de premio opcional.
		 * @param string $vNombreOrganizador El nombre del organizador del torneo.
		 * @param string $vUsuarioOrganizador El nombre de usuario del organizador.
		 * @param string $vContrasenaOrganizador La contraseña del organizador.
		 * @return void No retorna un valor específico, pero puede redirigir a otra página en caso de error.
		 */
		// Método para insertar un nuevo torneo
		public function insertarTorneo($vNombreTorneo, 
										$vImagenTorneo, 
										$vSedeTorneo, 
										$vPremio01, 
										$vPremio02, 
										$vPremio03, 
										$vOtroPremio, 
										$vNombreOrganizador, 
										$vUsuarioOrganizador, 
										$vContrasenaOrganizador) {

	        $usuarioExiste = $this->model->usuarioExiste($vUsuarioOrganizador);
	        // Si el usuario ya existe, redirige a la página de formulario con un mensaje de error.
	        if ($usuarioExiste) {

	            header("Location: frmTorneo.php?danger=error");
	            exit();

	        }

	        // Llama al método del modelo para insertar un nuevo torneo.
	        $idTorneo = $this->model->insert($vNombreTorneo, 
	        								$vImagenTorneo, 
	        								$vSedeTorneo, 
	        								$vPremio01, 
	        								$vPremio02,
	        								$vPremio03, 
	        								$vOtroPremio, 
	        								$vNombreOrganizador, 
	        								$vUsuarioOrganizador, 
	        								$vContrasenaOrganizador);
	        // Redirige a la página de control con un mensaje de éxito si la inserción es exitosa.
	        return ($idTorneo != false) ?
	            header("Location: ../panelControl.php?success=inserted") :
	            header("Location: ../panelControl.php");
	    }


		//Metodo para seleccionar todos los torneos.
	
		/**
		 * Selecciona todos los torneos disponibles en la base de datos.
		 *
		 * Este método utiliza el modelo para recuperar todos los torneos almacenados en la base de datos.
		 *
		 * @return array Un array con la información de todos los torneos o un array vacío si no hay torneos.
		 */
		public function selectAllTorneos() {
		    // Llama al método del modelo para recuperar todos los torneos.
		    $torneos = $this->model->allTorneos();

		    // Retorna los torneos si existen, de lo contrario, retorna un array vacío.
		    return $torneos;
		}


		//Metodo para seleccionar un torneo por su id.
		/**
		 * Selecciona un torneo específico por su ID.
		 *
		 * Este método utiliza el modelo para recuperar la información de un torneo específico identificado por su ID.
		 *
		 * @param int $idTorneo El ID del torneo que se quiere recuperar.
		 * @return array|false Un array con la información del torneo o false si el torneo no existe.
		 */
		public function selectOneTorneo($idTorneo) {
		    // Llama al método del modelo para recuperar la información del torneo por su ID.
		    $torneo = $this->model->readOneTorneo($idTorneo);

		    // Retorna el torneo si existe, de lo contrario, retorna false.
		    return ($torneo !== false) ? $torneo : false;
		}

		
		//Metodo para seleccionar un torneo con patrocinadores.
		/**
		 * Selecciona la información completa de un torneo específico por su ID.
		 *
		 * Este método utiliza el modelo para recuperar la información completa de un torneo identificado por su ID.
		 *
		 * @param int $idTorneo El ID del torneo que se quiere recuperar.
		 * @return array|false Un array con la información completa del torneo o un array vacío si el torneo no existe.
		 */
		public function selectOneTorneoComplete($idTorneo) {
		    // Llama al método del modelo para recuperar la información completa del torneo por su ID.
		    $torneoCompleto = $this->model->readOneTorneoComplete($idTorneo);

		    // Retorna la información completa del torneo si existe, de lo contrario, retorna un array vacío.
		    return ($torneoCompleto !== false) ? $torneoCompleto : [];
		}


		//Metodo para actualizar un torneo
		/**
		 * Actualiza la información de un torneo existente.
		 *
		 * Este método utiliza el modelo para actualizar la información de un torneo identificado por su ID.
		 *
		 * @param int $idTorneo El ID del torneo que se quiere actualizar.
		 * @param string $vNombreTorneo El nuevo nombre del torneo.
		 * @param string $vImagenTorneo La nueva ruta de la imagen asociada al torneo.
		 * @param string $vSedeTorneo La nueva sede o ubicación del torneo.
		 * @param string $vPremio01 La nueva descripción del primer premio.
		 * @param string $vPremio02 La nueva descripción del segundo premio.
		 * @param string $vPremio03 La nueva descripción del tercer premio.
		 * @param string $vOtroPremio La nueva descripción de otro premio opcional.
		 * @param string $vNombreOrganizador El nuevo nombre del organizador del torneo.
		 * @param string $vUsuarioOrganizador El nuevo nombre de usuario del organizador.
		 * @return void Redirige a la página correspondiente con un mensaje de éxito o sin redirección en caso de error.
		 */
		public function updateTorneo($idTorneo,
									$vNombreTorneo, 
									$vImagenTorneo,
									$vSedeTorneo, 
									$vPremio01,
									$vPremio02, 
									$vPremio03, 
									$vOtroPremio, 
									$vNombreOrganizador,
		                            $vUsuarioOrganizador){

			// Llama al método del modelo para actualizar un torneo.
		    return ($this->model->update($idTorneo,
		    							$vNombreTorneo, 
		    							$vImagenTorneo, 
		    							$vSedeTorneo, 
		    							$vPremio01, 
		    							$vPremio02, 
		    							$vPremio03, 
		    							$vOtroPremio, 
		                                $vNombreOrganizador, 
		                                $vUsuarioOrganizador)) 
		                                != false ? 
		                        header("Location: ../panelControl.php?success=updated") : 
		                        header("Location: ");

		}

		/**
		 * Elimina un torneo por su ID.
		 *
		 * Este método utiliza el modelo para eliminar un torneo identificado por su ID.
		 *
		 * @param int $idTorneo El ID del torneo que se quiere eliminar.
		 * @return void Redirige a la página correspondiente con un mensaje de éxito o redirige a la página de edición en caso de error.
		 */
		public function delete($idTorneo){
		    // Llama al método del modelo para eliminar un torneo.
		    $resultado = $this->model->delete($idTorneo);

		    // Verifica el resultado y redirige a la página correspondiente.
		    if ($resultado) {
		        header("Location: ../panelControl.php?success=deleted");
		    } else {
		        // Redirige a la página de edición con el ID del torneo en caso de error.
		        header("Location: fromEditTorneo.php?idTorneo=".$idTorneo);
		    }
		}

	}
?>