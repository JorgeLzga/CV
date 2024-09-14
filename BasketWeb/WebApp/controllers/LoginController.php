<?php
    session_start ();
    include_once (__DIR__ . '/../models/LoginModel.php');

    /**
     * Controlador para la gestión de la autenticación y sesión de usuarios.
     */
    class LoginController {
        private $model;

        /**
         * Constructor de la clase. Inicializa la instancia del modelo 'LoginModel'.
         */
        public function __construct () {

            $this->model = new LoginModel ();
        }

        /**
         * Autentica a un usuario y redirige según su rol y permisos.
         *
         * @param string $vUsuario Nombre de usuario.
         * @param string $vContrasena Contraseña del usuario.
         *
         * @return void Redirige a la página correspondiente según el rol y los permisos del usuario.
         */
        
        public function ingresarUsuario ($vUsuario, $vContrasena) {
            // Valida el usuario normal.
            $usuarioValido = $this->model->validarUsuario ($vUsuario, $vContrasena);
            // Valida el usuario organizador.
            $usuarioValidoOrganizador = $this->model->validarUsuarioOrganizador ($vUsuario, $vContrasena);

            if ($usuarioValido['idRol'] == '1') {

                // Usuario normal
                $_SESSION ['vUsuario'] = $usuarioValido ['vUsuario']; 
                $_SESSION ['idRol'] = $usuarioValido ['idRol']; 

                header ("Location: ../../../views/template/panelControl.php");
                exit ();

            } elseif ($usuarioValidoOrganizador ['idRol'] == '2') {

                // Usuario organizador
                $_SESSION ['vUsuarioOrganizador'] = $usuarioValidoOrganizador ['vUsuarioOrganizador'];
                $_SESSION ['idRol'] = $usuarioValidoOrganizador ['idRol']; 
                $idTorneo = $usuarioValidoOrganizador ['idTorneo'];

                if ($idTorneo) {
                    header ("Location: ../../../views/template/torneo/infoTorneo.php?idTorneo=$idTorneo");
                    exit ();

                } else {
                    echo "El usuario organizador no tiene un torneo asignado.";
                    exit ();
                }
            
            } else {
                // Usuario no autorizado
                echo "No tiene permiso para acceder.";
                header ("Location: login.php?error=Usuario o contraseña incorrectos");
                exit ();        
            }
        }

        /**
         * Cierra la sesión del usuario.
         *
         * @return void Redirige a la página de inicio después de cerrar la sesión.
         */
        public function cerrarSesion () {

            $_SESSION = array ();
            session_destroy ();
            
            header ("Location: /WebApp/index.php");
            exit ();
        }
    }
?>