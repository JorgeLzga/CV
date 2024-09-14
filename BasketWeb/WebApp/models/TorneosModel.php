<?php
	 // Es la ruta del archivo de configuración de la base de datos
    include_once(__DIR__ . '/../config/dataBase.php');

    // Se define la clase torneosModel
	class torneosModel{

		// Permite almacenar la conexión a la base de datos
		public $PDO;

		// Constructor de la clase
		public function __construct(){

			// Crea una instancia de la clase DataBase para obtener la conexión a la base de datos.
			$vConexion = new DataBase();

			$this->PDO = $vConexion->getConexion(); // Almacena la conexión en la propiedad PDO
        }
		

		// Método que permite seleccionar torneos por cada organizador.
		public function selectTorneosByOrganizador($vUsuarioOrganizador) {

			// Prepara una consulta SQL con un solo parametro.
	        $stmt = $this->PDO->prepare("SELECT * FROM tbltorneos WHERE vUsuarioOrganizador = :vUsuarioOrganizador");
	        // Asocia el valor del parámetro con la variable ya proporcionada.
	        $stmt->bindParam(':vUsuarioOrganizador', $vUsuarioOrganizador);

	        // Ejecuta la consulta
	        $stmt->execute();

	        // Obtiene todos los resultados como un array asociativo
	        $torneosDelOrganizador = $stmt->fetchAll(PDO::FETCH_ASSOC);

	        //Retorna el resultado
	        return $torneosDelOrganizador;
	    }

		// Método que permite seleccionar torneos por el administrador.
	    public function selectTorneosByAdmin($idTorneo) {

	    	// Prepara una consulta SQL con un solo parametro.
		    $stmt = $this->PDO->prepare("SELECT * FROM tbltorneos WHERE idTorneo = :idTorneo");
		    $stmt->bindParam(':idTorneo', $idTorneo);
		    $stmt->execute();
		    $torneos = $stmt->fetchAll(PDO::FETCH_ASSOC);

		    return $torneos;
		}
	    
        // Método para insertar un nuevo torneo en la base de datos	
		public function insert($vNombreTorneo, 
								$vImagenTorneo, 
								$vSedeTorneo, 
								$vPremio01, 
								$vPremio02, 
								$vPremio03, 
								$vOtroPremio, 
								$vNombreOrganizador, 
								$vUsuarioOrganizador, 
								$vContrasenaOrganizador) {

			// Encripta la contraseña del organizador
		    $vContrasenaOrganizador = $this->passwordEncrypt($vContrasenaOrganizador);

		      // Prepara una consulta SQL para insertar los datos
		    $statement = $this->PDO->prepare("
										    	INSERT INTO tbltorneos 
										    	(vNombreTorneo, 
										    	vImagenTorneo, 
										    	vSedeTorneo, 
										    	vPremio01, 
										    	vPremio02, 
										    	vPremio03, 
										    	vOtroPremio, 
										    	vNombreOrganizador, 
										    	vUsuarioOrganizador, 
										    	vContrasenaOrganizador)

										    	VALUES 
										    	(:vNombreTorneo, 
										    	:vImagenTorneo, 
										    	:vSedeTorneo, 
										    	:vPremio01, 
										    	:vPremio02, 
										    	:vPremio03, 
										    	:vOtroPremio, 
										    	:vNombreOrganizador, 
										    	:vUsuarioOrganizador, 
										    	:vContrasenaOrganizador)
									    	");
			// Asocia cada parámetro con su respectiva variable
		    $statement->bindParam(":vNombreTorneo", $vNombreTorneo);
		    $statement->bindParam(":vImagenTorneo", $vImagenTorneo);
		    $statement->bindParam(":vSedeTorneo", $vSedeTorneo);
		    $statement->bindParam(":vPremio01", $vPremio01);
		    $statement->bindParam(":vPremio02", $vPremio02);
		    $statement->bindParam(":vPremio03", $vPremio03);
		    $statement->bindParam(":vOtroPremio", $vOtroPremio);
		    $statement->bindParam(":vNombreOrganizador", $vNombreOrganizador);
		    $statement->bindParam(":vUsuarioOrganizador", $vUsuarioOrganizador);
		    $statement->bindParam(":vContrasenaOrganizador", $vContrasenaOrganizador);

		    // Ejecuta la consulta y retorna el ID del último registro que se
		    // inserto o false "falso" si falla el registro.

		    return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
		}

		// Método para encriptar una contraseña utilizando password_hash
		public function passwordEncrypt($vContrasenaOrganizador){

			 // Encripta la contraseña
			$passwordEncrypted = password_hash($vContrasenaOrganizador, PASSWORD_DEFAULT);
			//Retorna el resultado
			return $passwordEncrypted;

		}

 		 // Método que verifica si la contraseña coincide con su versión encriptada
		public function passwordDecryted($passwordEncrypted, $passwordCandidate){

			// Retorna true "verdadero" si la contraseña coincide, de lo contrario, retorna false "falso"
			return(password_verify($passwordCandidate,$passwordEncrypted)) ? true : false;

		}

		// Método para obtener todos los torneos de la base de datos
		public function allTorneos() {

		    try {
		    	 // Realiza una consulta SQL para seleccionar la tabla que contiene todos los datos
		    	 // del torneo.
		        $statement = $this->PDO->query("SELECT * FROM tbltorneos");

		        // Lanza una excepción si la consulta no se ejecuta correctamente.
		        if (!$statement) { throw new Exception("Error en la consulta SQL");}

 				// Ejecuta la consulta.
		        $statement->execute();

		        	//Retorna todos los resultados como un array asociativo.
		        	return $statement->fetchAll(PDO::FETCH_ASSOC);

		     // Captura cualquier excepción y muestra un mensaje de error.. 
		    } catch (Exception $e) { echo "Error: " . $e->getMessage();

		    	//Retorna un array vacio en caso de error.
		        return array(); 
		    }
		}

		 // Método para leer la información de un torneo específico.
		public function readOneTorneo($idTorneo){

			// Prepara una consulta SQL para seleccionar un torneo por su id correspondiente.
		    $statement = $this->PDO->prepare("
			    								SELECT  *
			                            		FROM tbltorneos
			                                    WHERE idTorneo = :idTorneo
		                                    ");
		      // Asocia el parámetro con la variable ya proporcionada.
		    $statement->bindParam(":idTorneo", $idTorneo);

		    // Ejecuta la consulta y retorna el resultado o false "falso" si falla.
		    return ($statement->execute()) ? $statement->fetch() : false;
		}

		// Método que lee la información completa de un torneo (incluyendo a los patrocinadores).
		public function readOneTorneoComplete($idTorneo) {

			 // Prepara una consulta SQL para seleccionar un torneo y sus patrocinadores correspondientes.
		    $statement = $this->PDO->prepare("
										        SELECT t.*, p.*
										        FROM tbltorneos t
										        LEFT JOIN tblpatrocinadores p ON t.idTorneo = p.idTorneo
										        WHERE t.idTorneo = :idTorneo
		    								");

		      // Asocia el parámetro con la variable proporcionada.
		    $statement->bindParam(":idTorneo", $idTorneo);

			 //Retorna el resultado de la ejecución de la consulta SQL.		    
		    return ($statement->execute()) ? $statement->fetchAll() : false;
		}

		// Método para actualizar los torneos en la base de datos.
		public function update($idTorneo, $vNombreTorneo, $vImagenTorneo, $vSedeTorneo, $vPremio01, $vPremio02, $vPremio03, $vOtroPremio, $vNombreOrganizador, $vUsuarioOrganizador){
		    // Prepara una consulta SQL para actualizar los campos de un torneo específico.
		    $statement = $this->PDO->prepare("
		        UPDATE tbltorneos SET 
		        vNombreTorneo = :vNombreTorneo, 
		        vImagenTorneo = :vImagenTorneo, 
		        vSedeTorneo = :vSedeTorneo, 
		        vPremio01 = :vPremio01,
		        vPremio02 = :vPremio02, 
		        vPremio03 = :vPremio03, 
		        vOtroPremio = :vOtroPremio,
		        vNombreOrganizador = :vNombreOrganizador,
		        vUsuarioOrganizador = :vUsuarioOrganizador
		        WHERE idTorneo = :idTorneo
		    ");

		    // Asocia cada parámetro con su respectiva variable.
		    $statement->bindParam(":idTorneo", $idTorneo);
		    $statement->bindParam(":vNombreTorneo", $vNombreTorneo);
		    $statement->bindParam(":vImagenTorneo", $vImagenTorneo);
		    $statement->bindParam(":vSedeTorneo", $vSedeTorneo);
		    $statement->bindParam(":vPremio01", $vPremio01);
		    $statement->bindParam(":vPremio02", $vPremio02);
		    $statement->bindParam(":vPremio03", $vPremio03);
		    $statement->bindParam(":vOtroPremio", $vOtroPremio);
		    $statement->bindParam(":vNombreOrganizador", $vNombreOrganizador);
		    $statement->bindParam(":vUsuarioOrganizador", $vUsuarioOrganizador);

		    $statement->execute();

		    // Verifica si se actualizó algún registro.
		    if ($statement->rowCount() >= 0) {
		        // Retorna el ID del torneo actualizado o cualquier otro indicador de éxito.
		        return $idTorneo;
		    } else {
		        // Retorna algún indicador de fallo (por ejemplo, false).
		        return false;
		    }
		}


		// Método para eliminar un torneo de la base de datos por su id.
		public function delete($idTorneo){
			// Prepara una consulta SQL para eliminar un torneo por su id.
			$statement = $this->PDO->prepare("DELETE FROM tbltorneos WHERE idTorneo = :idTorneo");
			// Asocia el parámetro con la variable proporcionada.
			$statement->bindParam(":idTorneo",$idTorneo);

			 // Retorna true "verdadero" si la eliminación se ejecuta correctamente, 
			 // de lo contrario, retorna false "falso".
			return ($statement->execute()) ? true : false;
		}

		// Método para verificar si un usuario existe en la base de datos.
		public function usuarioExiste($vUsuarioOrganizador) {

			    // Prepara una consulta SQL para contar la cantidad de registros que coinciden con el usuario proporcionado.
	        $statement = $this->PDO->prepare("SELECT COUNT(*) as count FROM tbltorneos WHERE vUsuarioOrganizador = :vUsuarioOrganizador");
	        // Asocia el parámetro con la variable proporcionada.
	        $statement->bindParam(":vUsuarioOrganizador", $vUsuarioOrganizador);
	         // Ejecuta la consulta.
	        $statement->execute();
	        // Obtiene el resultado como un array asociativo.
	        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

	       // Retorna true "verdadero" si hay al menos un registro, de lo contrario, retorna false "falso".
	        return ($resultado['count'] > 0); 
	    }

	}
	
?>	