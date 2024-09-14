<?php
    include_once (__DIR__ . '/../models/EstJugadorModel.php');

    /**
     * Controlador para la gestión de estadísticas de jugadores.
     */
    class estJugadorController {
        private $model;

        /**
         * Constructor de la clase. Inicializa la instancia del modelo 'estJugadorModel'.
         */
        public function __construct () {

            $this->model = new estJugadorModel ();

        }

        /**
         * Obtiene todas las estadísticas de jugadores para un torneo específico.
         *
         * @param int $idTorneo El identificador del torneo para el cual se obtendrán las estadísticas de jugadores.
         *
         * @return array Un arreglo que contiene todas las estadísticas de jugadores del torneo especificado.
         */
        public function selectAllEstJugador ($idTorneo) {

            $estJugador = $this->model->allEstJugador ($idTorneo);
            
            return $estJugador;
        }
    }
?>