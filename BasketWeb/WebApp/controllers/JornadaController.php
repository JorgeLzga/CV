<?php
	
    include_once(__DIR__ . '/../models/JornadaModel.php');

	class JornadaController{

		private $model;

		public function __construct(){

			$this->model = new JornadaModel();

		}
		
		/**
		 * La función "insertarJornada" inserta un nuevo registro en una tabla de base de datos y redirige al
		 * usuario a una página específica según el éxito o fracaso de la inserción.
		 * 
		 * @param fechaSeleccionada La fecha seleccionada para el juego.
		 * @param vPuntosTotal Los puntos totales anotados por el jugador en el juego.
		 * @param vTirosde3 El parámetro "vTirosde3" representa el número de tiros de tres puntos realizados
		 * por un jugador en un partido.
		 * @param vFaltas El parámetro "vFaltas" representa el número de faltas cometidas por un jugador en
		 * un partido.
		 * @param idEquipo El ID del equipo para el que juega el jugador en el partido determinado.
		 * @param idJugador El ID del jugador para quien se insertan los datos.
		 * @param idCalendario El parámetro idCalendario representa el identificador único de un calendario.
		 * Se utiliza para asociar los datos insertados a un calendario específico.
		 * @param idTorneo La identificación del torneo.
		 */
		public function insertarJornada($fechaSeleccionada,
										$vPuntosTotal,
		                                $vTirosde3,
		                                $vFaltas,
		                                $idEquipo,
		                                $idJugador,
		                                $idCalendario,
		                                $idTorneo){
		
			$idJugador = $this->model->insert($vPuntosTotal,
				                                $vTirosde3,
				                                $vFaltas,
				                                $idEquipo,
				                                $idJugador,
				                                $idCalendario,
				                                $idTorneo);

			($idJugador != false) ?  
				header("Location: infoJornada.php?idTorneo=$idTorneo&idCalendario=$idCalendario&vFecha=$fechaSeleccionada&success=inserted") : 
				header("Location: infoJornada.php");
		}

		/**
		 * La función "insertarJornadaDefault" inserta un registro predeterminado en una tabla de base de
		 * datos y redirige al usuario a una página específica según el éxito o el fracaso de la inserción.
		 * 
		 * @param fechaSeleccionada La fecha seleccionada para la jornada.
		 * @param vPuntosDefault Los puntos predeterminados para el jugador en el partido.
		 * @param idEquipo El ID del equipo para el cual se insertan los puntos predeterminados.
		 * @param idCalendario El parámetro idCalendario representa el ID del calendario. Se utiliza para
		 * identificar un calendario específico en la base de datos.
		 * @param idTorneo El ID del torneo.
		 */
		public function insertarJornadaDefault($fechaSeleccionada,
										$vPuntosDefault,
		                                $idEquipo,
		                                $idCalendario,
		                                $idTorneo){
		
			$idJugador = $this->model->insertDefault($vPuntosDefault,
				                                $idEquipo,
				                                $idCalendario,
				                                $idTorneo);

			($idJugador != false) ?  
				header("Location: infoJornada.php?idTorneo=$idTorneo&idCalendario=$idCalendario&vFecha=$fechaSeleccionada&success=inserted") : 
				header("Location: infoJornada.php");
		}

		/**
		 * La función selectAllJornadaEqLocal recupera todos los partidos de un calendario y torneo
		 * específico.
		 * 
		 * @param idCalendario La identificación del calendario.
		 * @param idTorneo El parámetro idTorneo es el ID del torneo. Se utiliza para filtrar los resultados
		 * y recuperar todos los partidos de un torneo específico.
		 * 
		 * @return el resultado de la llamada al método `->model->allJornadaEqLocal(,
		 * )`.
		 */
		public function selectAllJornadaEqLocal($idCalendario,$idTorneo) {

	        return $this->model->allJornadaEqLocal($idCalendario, $idTorneo);

	    }

	    /**
		 * La función selectAllJornadaEqVisitante devuelve todos los partidos de un torneo y calendario
		 * específico donde el equipo es visitante.
		 * 
		 * @param idCalendario La identificación del calendario para el cual desea seleccionar todos los
		 * partidos.
		 * @param idTorneo El parámetro idTorneo es el ID del torneo para el cual quieres seleccionar
		 * todos los partidos donde un equipo juega como visitante.
		 * 
		 * @return el resultado de la llamada al método
		 * `->model->allJornadaEqVisitante(, )`.
		 */
		public function selectAllJornadaEqVisitante($idCalendario, $idTorneo) {

	        return $this->model->allJornadaEqVisitante($idCalendario, $idTorneo);

	    }


	   	/**
		 * La función selectAllJornadaEquipoLocal recupera todos los partidos de un calendario y torneo
		 * específico.
		 * 
		 * @param idCalendario La identificación del calendario para el cual desea seleccionar todos los
		 * partidos.
		 * @param idTorneo El parámetro idTorneo es el ID del torneo para el cual quieres seleccionar
		 * todos los partidos donde juega el equipo local.
		 * 
		 * @return el resultado de la llamada al método "allJornadaEquipoLocal(,)"
		 * del modelo.
		 */
		public function selectAllJornadaEquipoLocal($idCalendario,$idTorneo) {

	        return $this->model->allJornadaEquipoLocal($idCalendario,$idTorneo);

	    }

	   	/**
		 * La función selectAllJornadaEquipoVisitante devuelve todos los datos de jornada, equipo y
		 * visitante del modelo según el idCalendario e idTorneo proporcionados.
		 * 
		 * @param idCalendario La identificación del calendario.
		 * @param idTorneo El parámetro idTorneo es el ID del torneo. Se utiliza para filtrar los
		 * resultados y recuperar todos los partidos de un torneo específico.
		 * 
		 * @return el resultado de la llamada al método
		 * `->model->allJornadaEquipoVisitante(,)`.
		 */
		public function selectAllJornadaEquipoVisitante($idCalendario,$idTorneo) {

	        return $this->model->allJornadaEquipoVisitante($idCalendario,$idTorneo);

	    }

	    /**
		 * La función actualiza las estadísticas de un jugador para un juego específico y redirige al
		 * usuario a una página de éxito o error.
		 * 
		 * @param fechaSeleccionada La fecha seleccionada para la actualización.
		 * @param idHistoriCoJugador El ID del registro histórico del desempeño del jugador en un juego.
		 * @param vPuntosTotal Los puntos totales anotados por el jugador en el juego.
		 * @param vTirosde3 El parámetro "vTirosde3" representa el número de tiros de tres puntos
		 * realizados por un jugador en un partido.
		 * @param vFaltas El número de faltas cometidas por el jugador en el juego seleccionado.
		 * @param idEquipo La identificación del equipo.
		 * @param idJugador La identificación del jugador cuyos datos se están actualizando.
		 * @param idCalendario El parámetro idCalendario es el identificador único de un calendario o
		 * horario específico. Se utiliza para identificar en qué calendario o programación se realiza la
		 * operación de actualización.
		 * @param idTorneo La identificación del torneo.
		 */
		public function updateJornada($fechaSeleccionada,
	    						$idHistoriCoJugador,
                                $vPuntosTotal,
                                $vTirosde3,
                                $vFaltas,
                                $idEquipo,
                                $idJugador,
                                $idCalendario,
                                $idTorneo){

			 $idHistoriCoJugador = $this->model->update(
			 					$idHistoriCoJugador,
                                $vPuntosTotal,
                                $vTirosde3,
                                $vFaltas,
                                $idEquipo,
                                $idJugador,
                                $idCalendario,
                                $idTorneo);

			($idHistoriCoJugador != false) ? 
				 header("Location: frmEditJornada.php?idTorneo=$idTorneo&idCalendario=$idCalendario&vFecha=$fechaSeleccionada&success=updated") : 
				 header("Location: frmEditJornada.php");
		}   
	}
?>