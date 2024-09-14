<?php
    include_once (__DIR__ . '/../config/dataBase.php');

	/* La clase `patrocinadorModel` es una clase PHP que maneja operaciones de base de datos para la tabla
    "tblpatrocinadores", incluida la inserción, recuperación, actualización y eliminación de registros. */
    class patrocinadorModel {

		public $PDO;

		/**
         * La función crea una nueva instancia de la clase DataBase y asigna la propiedad PDO a la conexión.
         */
        public function __construct (){
			$vConexion = new DataBase ();
			$this->PDO = $vConexion->getConexion ();
		}

        /**
         * La función inserta un nuevo registro en la tabla "tblpatrocinadores" con los valores
         * proporcionados para "vNombrePatrocinador", "vImgPatrocinador" e "idTorneo".
         * 
         * @param vNombrePatrocinador La variable vNombrePatrocinador representa el nombre del
         * patrocinador. Es un valor de cadena.
         * @param vImgPatrocinador El parámetro "vImgPatrocinador" es la URL de la imagen o ruta del
         * archivo del patrocinador. Se utiliza para almacenar la imagen del patrocinador en la base de
         * datos.
         * @param idTorneo El parámetro "idTorneo" es el ID del torneo al que pertenece el
         * patrocinador. Se utiliza para asociar el patrocinador a un torneo específico en la base de
         * datos.
         * 
         * @return el último ID insertado si la ejecución de la declaración es exitosa. De lo
         * contrario, devuelve falso.
         */
        public function insert ($vNombrePatrocinador, $vImgPatrocinador, $idTorneo) {
            $statement = $this->PDO->prepare("
                                                INSERT INTO tblpatrocinadores
                                                (vNombrePatrocinador, 
                                                vImgPatrocinador, 
                                                idTorneo)

                                                VALUES 
                                                (:vNombrePatrocinador, 
                                                :vImgPatrocinador, 
                                                :idTorneo)
                                            ");

            $statement->bindParam (":vNombrePatrocinador", $vNombrePatrocinador);
            $statement->bindParam (":vImgPatrocinador", $vImgPatrocinador);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $this->PDO->lastInsertId () : false;
        }


        /**
         * La función "allPatrocinadores" recupera todos los patrocinadores de la base de datos,
         * ordenados por nombre del torneo y nombre del patrocinador.
         * 
         * @return el resultado de la consulta SQL ejecutada por la declaración PDO. Si la ejecución es
         * exitosa, devolverá una matriz que contiene todas las filas extraídas de la base de datos. Si
         * la ejecución falla, devolverá falso.
         */
        public function allPatrocinadores () {
            $statement = $this->PDO->prepare("
                                                SELECT * FROM tblpatrocinadores p
                                                LEFT OUTER JOIN tbltorneos t ON p.idTorneo = t.idTorneo
                                                ORDER BY t.vNombreTorneo ASC, p.vNombrePatrocinador ASC
                                            ");
                return ($statement->execute ()) ? $statement->fetchAll () : false;
        }


        /**
         * La función "readOnePatrocinador" recupera una sola fila de datos de la tabla
         * "tblpatrocinadores", junto con datos relacionados de la tabla "tblTorneos", basándose en el
         * "idPatrocinador" proporcionado.
         * 
         * @param idPatrocinador El parámetro "idPatrocinador" es el identificador único del
         * patrocinador (sponsor) que se desea recuperar de la base de datos.
         * 
         * @return el resultado de la ejecución de la consulta. Si la consulta tiene éxito, devolverá
         * la fila recuperada de la base de datos. Si la consulta falla, devolverá falso.
         */
        public function readOnePatrocinador ($idPatrocinador) {
            $statement = $this->PDO->prepare ("
                                                SELECT p.*, t.*
                                                FROM tblpatrocinadores AS p
                                                JOIN tblTorneos AS t ON p.idTorneo = t.idTorneo
                                                WHERE p.idPatrocinador = :idPatrocinador
                                                LIMIT 1;
                                            ");

            $statement->bindParam (":idPatrocinador",$idPatrocinador);

            return ($statement->execute ()) ? $statement->fetch () : false;
        }


        /**
         * La función actualiza un registro en la tabla "tblpatrocinadores" con los parámetros dados.
         * 
         * @param idPatrocinador El ID del patrocinador (sponsor) que deseas actualizar.
         * @param vNombrePatrocinador El parámetro "vNombrePatrocinador" es una cadena que representa
         * el nombre actualizado del patrocinador.
         * @param vImgPatrocinador El parámetro "vImgPatrocinador" es una cadena que representa la URL
         * o ruta de la imagen del patrocinador.
         * @param idTorneo El parámetro "idTorneo" es el ID del torneo al que está asociado el
         * patrocinador.
         * 
         * @return el valor de  si el método ejecutar() de la declaración es exitoso, de
         * lo contrario devuelve falso.
         */
        public function update ($idPatrocinador, $vNombrePatrocinador, $vImgPatrocinador, $idTorneo) {

            $statement = $this->PDO->prepare ("
                                                UPDATE tblpatrocinadores SET 
                                                vNombrePatrocinador = :vNombrePatrocinador, 
                                                vImgPatrocinador = :vImgPatrocinador, 
                                                idTorneo = :idTorneo 
                                                WHERE idPatrocinador = :idPatrocinador
                                            ");

            $statement->bindParam (":idPatrocinador",$idPatrocinador);
            $statement->bindParam (":vNombrePatrocinador", $vNombrePatrocinador);
            $statement->bindParam (":vImgPatrocinador", $vImgPatrocinador);
            $statement->bindParam (":idTorneo", $idTorneo);

            return ($statement->execute ()) ? $idPatrocinador : false;
        }


        /**
         * La función elimina una fila de la tabla "tblpatrocinadores" según el "idPatrocinador"
         * proporcionado.
         * 
         * @param idPatrocinador El parámetro "idPatrocinador" es el identificador único del
         * patrocinador (sponsor) que se desea eliminar de la tabla "tblpatrocinadores".
         * 
         * @return un valor booleano. Si la ejecución de la declaración de eliminación es exitosa,
         * devolverá verdadero. De lo contrario, devolverá falso.
         */
        public function delete ($idPatrocinador) {

            $statement = $this->PDO->prepare ("DELETE FROM tblpatrocinadores WHERE idPatrocinador = :idPatrocinador");
            $statement->bindParam (":idPatrocinador",$idPatrocinador);

            return ($statement->execute ()) ? true : false;
        }
    }
?>