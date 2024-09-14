<?php
    include_once (__DIR__ . '/../config/dataBase.php');

    /**
     * Modelo para la gestión de operaciones relacionadas con el acceso a la pagina.
     */
    class PerfilModel {
        public $PDO;

        /**
         * Constructor de la clase que inicializa la conexión a la base de datos.
         */
        public function __construct () {
            $vConexion = new DataBase ();
            $this->PDO = $vConexion->getConexion ();
        }
        
        /**
         * Obtiene el perfil de todos los torneos.
         *
         * @return array Retorna un arreglo asociativo con la información de los torneos.
         */
        public function obtenerPerfil () {
            $statement = $this->PDO->prepare ("SELECT idTorneo, vNombreOrganizador, vUsuarioOrganizador, vImagenTorneo FROM tbltorneos");
            $statement->execute ();
            return $statement->fetchAll (PDO::FETCH_ASSOC);
        }

        /**
         * Actualiza el perfil de un torneo.
         *
         * @param int $idTorneo ID del torneo.
         * @param string $vUsuarioOrganizador Nuevo nombre de usuario del organizador.
         * @param string $vContrasenaOrganizador Nueva contraseña del organizador.
         *
         * @return bool Retorna true si la actualización es exitosa, de lo contrario, retorna false.
         */
        public function actualizarPerfil ($idTorneo, $vUsuarioOrganizador, $vContrasenaOrganizador){
            $contrasenaHasheada = password_hash ($vContrasenaOrganizador, PASSWORD_DEFAULT);

            $statement = $this->PDO->prepare ("
                                                UPDATE tbltorneos SET 
                                                vUsuarioOrganizador = :vUsuarioOrganizador, 
                                                vContrasenaOrganizador = :vContrasenaOrganizador 
                                                WHERE idTorneo = :idTorneo
                                            ");

            $statement->bindParam(":vUsuarioOrganizador", $vUsuarioOrganizador);
            $statement->bindParam(":vContrasenaOrganizador", $contrasenaHasheada);
            $statement->bindParam(":idTorneo", $idTorneo);

            return $statement->execute();
        }     

        /**
         * Obtiene el perfil de un torneo por su ID.
         *
         * @param int $idTorneo ID del torneo.
         *
         * @return array|false Retorna un arreglo asociativo con la información del torneo si se encuentra,
         *                     de lo contrario, retorna false.
         */
        public function obtenerPerfilPorId ($idTorneo) {            
            $statement = $this->PDO->prepare ("
                                                SELECT idTorneo, 
                                                vNombreOrganizador, 
                                                vUsuarioOrganizador, 
                                                vContrasenaOrganizador 
                                                FROM tbltorneos 
                                                WHERE idTorneo = :id
                                            ");

            $statement->bindParam (":id", $idTorneo);
            $statement->execute ();

            return $statement->fetch (PDO::FETCH_ASSOC);
        }
    }
?>