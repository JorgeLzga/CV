<?php
    include_once (__DIR__ . '/../models/EstEquipoModel.php');

    /* La clase estEquipoController es responsable de recuperar todos los datos de estEquipo para un
    idTorneo determinado. */
    class estEquipoController {
        private $model;

        /**
         * La función es un constructor que inicializa una nueva instancia de la clase estEquipoModel.
         */
        public function __construct () {

            $this->model = new estEquipoModel ();
            
        }

        /**
         * Obtiene todos los registros de estadísticas de equipos para un torneo específico.
         *
         * @param int $idTorneo El identificador del torneo para el cual se obtendrán las estadísticas de equipos.
         *
         * @return array Un arreglo que contiene todas las estadísticas de equipos del torneo especificado.
         */
        public function selectAllEstEquipo ($idTorneo) {

            $estEquipo = $this->model->allEstEquipo ($idTorneo);

            return $estEquipo;
        }
    }
?>