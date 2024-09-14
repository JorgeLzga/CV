<?php
    // Incluye el archivo que contiene la definición de la clase 'PerfilModel'.
    include_once (__DIR__ . '/../models/PerfilModel.php');

    /**
     * Controlador para la gestión de perfiles de usuario.
     */
    class PerfilController {
        /** @var PerfilModel $model Instancia del modelo 'PerfilModel'. */
        private $model;

        /**
         * Constructor de la clase. Inicializa la instancia del modelo 'PerfilModel'.
         */
        public function __construct () {

            $this->model = new PerfilModel ();
        }

        /**
         * Obtiene el perfil de usuario.
         *
         * @return array|null Retorna el perfil de usuario o null si no se encuentra.
         */
        public function obtenerPerfil () {

            return $this->model->obtenerPerfil ();
        }

        /**
         * Obtiene el perfil de usuario por su identificador.
         *
         * @param int $idTorneo Identificador del torneo asociado al perfil.
         *
         * @return array|null Retorna el perfil de usuario o null si no se encuentra.
         */
        public function obtenerPerfilPorId ($idTorneo) {

            return $this->model->obtenerPerfilPorId ($idTorneo);
        }

        /**
         * Actualiza el perfil de usuario.
         *
         * @param int $idTorneo Identificador del torneo asociado al perfil.
         * @param string $vUsuarioOrganizador Nuevo nombre de usuario organizador.
         * @param string $vContrasenaOrganizador Nueva contraseña del usuario organizador.
         *
         * @return void Redirige a la página de información del perfil con un mensaje de éxito o sin éxito.
         */
        public function actualizarPerfil ($idTorneo, $vUsuarioOrganizador, $vContrasenaOrganizador) {
            
            // Llama al método 'actualizarPerfil' del modelo para actualizar el perfil.
            return ($this->model->actualizarPerfil ($idTorneo, $vUsuarioOrganizador, $vContrasenaOrganizador))?
                // Redirecciona según el resultado de la actualización.
                header("Location: infoPerfil.php?success=inserted") : 
                header("Location: infoPerfil.php");
        }
    }
?>