<?php 
	/* La clase anterior es una clase PHP que maneja la conexión a una base de datos MySQL. */
	class DataBase{
		
		/* Estas líneas de código declaran variables privadas que almacenan los detalles de conexión para la
		base de datos MySQL. */
		private $host = "localhost";
		private $database_name ="basketdb";
		private $username="root";
		private $password="";

		public $vConexion;

		/**
		 * La función establece una conexión a una base de datos MySQL usando PDO en PHP.
		 * 
		 * @return el objeto de conexión de la base de datos.
		 */
		public function getConexion () {
			$this->vConexion = null;

			try{

				/* La línea de código `->vConexion = new PDO ("mysql:host=".->host.
				";dbname=".->database_name, ->nombre de usuario, ->contraseña );` está creando un
				nuevo objeto PDO (objetos de datos PHP) para establecer una conexión a una base de datos MySQL. */
				$this->vConexion = new PDO ("mysql:host=".$this->host. ";dbname=".$this->database_name, $this->username, $this->password);
				$this->vConexion->exec ("set names utf8");

			} catch(PDOException $exception) {
				
				echo "Error al Conectar a la base de Datos" . $exception->getMessage ();
			}

			/* La línea `return ->vConexion;` devuelve el objeto de conexión de la base de datos. Esto
			permite que otras partes del código utilicen la conexión de base de datos establecida para
			ejecutar consultas e interactuar con la base de datos. */
			return $this->vConexion;
		}
	}
?>