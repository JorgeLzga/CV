<?php
    include_once (__DIR__ . '/../config/dataBase.php');

    /**
     * Modelo para la gestión de operaciones relacionadas con el acceso a la pagina.
     */
    class LoginModel {
        private $PDO;

        /**
         * Constructor de la clase que inicializa la conexión a la base de datos.
         */
        public function __construct () {
            $vConexion = new DataBase ();
            $this->PDO = $vConexion->getConexion ();
        }

        /**
         * Valida un usuario administrador por su nombre de usuario y contraseña.
         *
         * @param string $vUsuario Nombre de usuario del administrador.
         * @param string $vContrasena Contraseña del administrador.
         *
         * @return array|false Retorna un arreglo asociativo con la información del administrador si la validación es exitosa,
         *                     de lo contrario, devuelve false.
         */
        public function validarUsuario ($vUsuario, $vContrasena) {
            $consulta = "SELECT * FROM tbladministrador WHERE vUsuario = :vUsuario";
            
            $stmt = $this->PDO->prepare ($consulta);
            $stmt->bindParam (":vUsuario", $vUsuario);
            $stmt->execute ();
            $row = $stmt->fetch (PDO::FETCH_ASSOC);

            if ($row) {
                $hashed_password = $row ['vContrasena'];
                if (password_verify ($vContrasena, $hashed_password)) {
                    return $row;
                }
            }
            return false;
        }

        /**
         * Valida un usuario organizador por su nombre de usuario y contraseña.
         *
         * @param string $vUsuarioOrganizador Nombre de usuario del organizador.
         * @param string $vContrasena Contraseña del organizador.
         *
         * @return array|false Retorna un arreglo asociativo con la información del organizador si la validación es exitosa,
         *                     de lo contrario, devuelve false.
         */
        public function validarUsuarioOrganizador( $vUsuarioOrganizador, $vContrasena) {
            
            $query = "SELECT * FROM tbltorneos WHERE vUsuarioOrganizador = :vUsuarioOrganizador";
            $stmt = $this->PDO->prepare ($query);
            $stmt->bindParam (":vUsuarioOrganizador", $vUsuarioOrganizador);
            $stmt->execute ();
            $row = $stmt->fetch (PDO::FETCH_ASSOC);

            if ($row) {
                $hashed_password = $row ['vContrasenaOrganizador'];
                if (password_verify($vContrasena, $hashed_password)) {
                    return $row;
                }
            }
            return false;
        }
    }
?>