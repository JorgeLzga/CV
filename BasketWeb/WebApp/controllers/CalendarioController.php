<?php
    include_once (__DIR__ . '/../models/CalendarioModel.php');

    /* La clase CalendarioController es responsable de manejar las operaciones CRUD relacionadas con la
    clase CalendarioModel en una aplicación PHP. */
    class CalendarioController {
        private $model;

        /**
         * La función es un constructor que inicializa una nueva instancia de la clase CalendarioModel.
         */
        public function __construct () {
            $this->model = new CalendarioModel ();
        }

        /**
         * La función insertarCalendario inserta un nuevo registro en la base de datos y redirige al
         * usuario a una página específica en función del éxito o fracaso de la inserción.
         * 
         * @param vEqLocal Nombre o DNI del equipo local.
         * @param vEqVisitante El parámetro "vEqVisitante" representa al equipo visitante en una
         * entrada del calendario.
         * @param vFecha La variable vFecha representa la fecha del juego en el formato "AAAA-MM-DD".
         * @param vHora El parámetro "vHora" representa el tiempo del juego.
         * @param vSede El parámetro "vSede" representa el lugar o lugar donde se llevará a cabo el
         * juego o evento.
         * @param idCategoria El parámetro "idCategoria" representa el ID de categoría del juego. Se
         * utiliza para identificar la categoría o división a la que pertenece el juego.
         * @param vTipoJuego El parámetro "vTipoJuego" representa el tipo de juego que se está jugando.
         * Podría ser un valor de cadena que indique el tipo de juego, como "Amistoso", "Liga", "Copa",
         * etc.
         * @param idTorneo El parámetro idTorneo representa el ID del torneo en el que se inserta el
         * calendario.
         */
        public function insertarCalendario ($vEqLocal, $vEqVisitante, $vFecha, $vHora, $vSede, $idCategoria, $vTipoJuego, $idTorneo) {
            $idGrupo = $this->model->insert ($vEqLocal, $vEqVisitante, $vFecha, $vHora, $vSede, $idCategoria, $vTipoJuego, $idTorneo);

            if ($idGrupo != false) {
                header ("Location: infoCalendario.php?idTorneo=$idTorneo&success=inserted");
            } else {
                header ("Location: infoCalendario.php");
            }
        }

        /**
         * La función selectAllCalendario recupera todos los datos del calendario para un idTorneo
         * determinado.
         * 
         * @param idTorneo El parámetro "idTorneo" es el ID del torneo del que deseas recuperar todos
         * los eventos del calendario.
         * 
         * @return la variable , que es el resultado de llamar al método
         * allCalendario() en el objeto modelo.
         */
        public function selectAllCalendario ($idTorneo) {
            $calendario = $this->model->allCalendario ($idTorneo);
            return $calendario;
        }

        /**
         * La función "selectOneCalendario" recupera un calendario basado en el ID del torneo y una
         * fecha seleccionada opcional.
         * 
         * @param idTorneo La identificación del torneo para el cual deseas seleccionar el calendario.
         * @param fechaSeleccionada El parámetro "fechaSeleccionada" es un parámetro opcional que
         * representa una fecha seleccionada. Si se proporciona un valor para este parámetro, la
         * función recuperará los datos del calendario para la fecha especificada. Si no se proporciona
         * ningún valor, la función recuperará todos los datos del calendario para el torneo
         * determinado.
         * 
         * @return la variable .
         */
        public function selectOneCalendario ($idTorneo, $fechaSeleccionada = null) {

            if ($fechaSeleccionada !== null) {

                $calendario = $this->model->allCalendarioReadByFecha ($idTorneo, $fechaSeleccionada);

            } else {

                $calendario = $this->model->allCalendarioRead ($idTorneo);
            }

            return $calendario;
        }

        /**
         * La función "selectOneCalendarioCompleto" recupera un calendario completo para un torneo
         * específico y lo devuelve, o una matriz vacía si no existe.
         * 
         * @param idCalendario La identificación del calendario que desea seleccionar.
         * @param idTorneo El parámetro idTorneo es el identificador único de un torneo. Se utiliza
         * para especificar qué calendario de torneo se está seleccionando.
         * 
         * @return el valor de la variable  si no es falso, en caso contrario está
         * retornando un array vacío.
         */
        public function selectOneCalendarioCompleto ($idCalendario, $idTorneo) {

            $grupoCompleto = $this->model->readOneCalendarioComplete ($idCalendario, $idTorneo);

            return ($grupoCompleto !== false) ? $grupoCompleto : [];
        }

        /**
         * La función actualiza una entrada del calendario en una aplicación PHP y redirige a una
         * página de éxito si la actualización se realiza correctamente.
         * 
         * @param idCalendario El ID de la entrada del calendario que debe actualizarse.
         * @param vEqLocal El parámetro "vEqLocal" representa el valor actualizado para el equipo local
         * en la entrada del calendario.
         * @param vEqVisitante El parámetro "vEqVisitante" representa al equipo visitante en una
         * actualización del calendario.
         * @param vHora El parámetro "vHora" representa la hora actualizada del juego en el calendario.
         * @param vFecha El parámetro "vFecha" representa la fecha de actualización del evento del
         * calendario.
         * @param vSede El parámetro "vSede" representa el lugar o ubicación del juego. Se utiliza para
         * actualizar la sede de un evento del calendario específico en el sistema.
         * @param idCategoria El parámetro "idCategoria" es el ID de la categoría del evento del
         * calendario. Se utiliza para identificar la categoría a la que pertenece el evento.
         * @param vTipoJuego El parámetro "vTipoJuego" representa el tipo de juego que se juega en el
         * calendario. Podría ser un valor de cadena que indique el tipo de juego, como "amistoso",
         * "liga", "torneo", etc.
         * @param idTorneo El parámetro "idTorneo" representa el ID del torneo. Se utiliza para
         * identificar el torneo específico para el cual se actualiza el calendario.
         */
        public function updateCalendario ($idCalendario, $vEqLocal, $vEqVisitante, $vHora, $vFecha, $vSede, $idCategoria, $vTipoJuego, $idTorneo) {
            $idCalendario = $this->model->update ($idCalendario, $vEqLocal, $vEqVisitante, $vHora, $vFecha, $vSede, $idCategoria, $vTipoJuego, $idTorneo);

            if ($idCalendario != false) {

                header ("Location: infoCalendario.php?idTorneo=$idTorneo&success=updated");
                exit ();
            }
        }

        /**
         * Esta función PHP elimina una entrada del calendario y redirige al usuario a una página
         * específica según el éxito o el fracaso de la eliminación.
         * 
         * @param idCalendario La identificación del calendario que se va a eliminar.
         * @param idTorneo El parámetro "idTorneo" representa el ID del torneo asociado al calendario.
         */
        public function delete ($idCalendario, $idTorneo) {

            $deleted = $this->model->delete ($idCalendario);

            if ($deleted) {

                header ("Location: ../calendario/infoCalendario.php?idTorneo=$idTorneo&success=deleted");

            } else {
                
                header ("Location: ../calendario/infoCalendario.php?idTorneo=$idTorneo");
            }
        }
    }
?>