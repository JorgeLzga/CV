<?php
    // Incluye el archivo que contiene la definición de la clase 'UsuarioModel'.
    include_once (__DIR__ . '/../models/UsuarioModel.php');

    /**
     * Controlador para la gestión de usuarios relacionados con equipos y estadísticas.
     */
    class UsuarioController {
        /** @var UsuarioModel $model Instancia del modelo 'UsuarioModel'. */
        private $model;

        /**
         * Constructor de la clase. Inicializa la instancia del modelo 'UsuarioModel'.
         */
        public function __construct () {

            $this->model = new usuarioModel ();
        }

        /**
         * Obtiene la información completa de un usuario asociado a un equipo.
         *
         * @param int $idTorneo Identificador del torneo al que pertenece el usuario.
         * @param int $idEquipo Identificador del equipo al que pertenece el usuario.
         *
         * @return array Arreglo que contiene la información completa del usuario o un arreglo vacío si no se encuentra.
         */
        public function selectOneUsuarioEquipoComplete ($idTorneo,$idEquipo) {

            $UsuarioEquipo = $this->model->readOneEquipoUsuarioComplete ($idTorneo,$idEquipo);

            return ($UsuarioEquipo !== false) ? $UsuarioEquipo : [];
        }

        /**
         * Obtiene todas las estadísticas de equipo asociadas a un usuario.
         *
         * @param int $idTorneo Identificador del torneo al que pertenece el usuario.
         * @param int $idEquipo Identificador del equipo al que pertenece el usuario.
         *
         * @return array Arreglo que contiene las estadísticas de equipo del usuario.
         */
        public function selectAllEstEquipoUsuario ($idTorneo,$idEquipo) {

            $estEquipoUsuario = $this->model->allEstEquipoUsuario ($idTorneo, $idEquipo);

            return $estEquipoUsuario;
        }

        /**
         * Obtiene todas las estadísticas de jugador asociadas a un usuario.
         *
         * @param int $idTorneo Identificador del torneo al que pertenece el usuario.
         * @param int $idEquipo Identificador del equipo al que pertenece el usuario.
         *
         * @return array Arreglo que contiene las estadísticas de jugador del usuario.
         */
        public function selectAllEstJugadorUsuario($idTorneo, $idEquipo) {

            $estJugadorUsuario = $this->model->allEstJugadorUsuario($idTorneo, $idEquipo);

            return $estJugadorUsuario;
        }

        /**
         * Genera un documento PDF con roles relacionados a un torneo.
         *
         * Este método utiliza el modelo para generar un documento PDF con roles asociados a un torneo específico.
         *
         * @param int $idTorneo El ID del torneo del cual se quieren generar los roles en el PDF.
         * @return mixed La representación del documento PDF o un valor específico según la implementación del modelo.
         */
        public function pdfrol($idTorneo) {
            // Llama al método del modelo para generar el documento PDF con roles.
            $pdfRol = $this->model->pdf($idTorneo);
            
            // Retorna el documento PDF o un valor específico según la implementación del modelo.
            return $pdfRol;
        }

        /**
         * Selecciona todos los registros de estadísticas de usuarios en un grupo específico de un torneo.
         *
         * Este método utiliza el modelo para recuperar todas las estadísticas de usuarios asociadas a un grupo específico de un torneo.
         *
         * @param int $idTorneo El ID del torneo del cual se quieren recuperar las estadísticas de usuarios.
         * @param int $idGrupo El ID del grupo del cual se quieren recuperar las estadísticas de usuarios.
         * @return array Un array con la información de las estadísticas de usuarios en el grupo o un array vacío si no hay estadísticas.
         */
        public function selectAllEstGrupoUsuario($idTorneo, $idGrupo) {
            // Llama al método del modelo para recuperar las estadísticas de usuarios en el grupo.
            $estGrupoUsuario = $this->model->allEstGrupoUsuario($idTorneo, $idGrupo);

            // Retorna las estadísticas de usuarios en el grupo si existen, de lo contrario, retorna un array vacío.
            return $estGrupoUsuario;
        }

        /**
         * Selecciona todos los registros de estadísticas con la máxima anotación.
         *
         * Este método utiliza el modelo para recuperar todas las estadísticas de usuarios con la máxima anotación.
         *
         * @return array Un array con la información de las estadísticas con la máxima anotación o un array vacío si no hay estadísticas.
         */
        public function selectAllMaxAnotacion() {
            // Llama al método del modelo para recuperar las estadísticas con la máxima anotación.
            $estMaxAnotacion = $this->model->allMaxAnotacion();

            // Retorna las estadísticas con la máxima anotación si existen, de lo contrario, retorna un array vacío.
            return $estMaxAnotacion;
        }

    }
?>