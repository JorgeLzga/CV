<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/dataBase.php';
    include_once '../models/EstEquipoModel.php';

    $idTorneo = isset($_GET['idTorneo']) ? $_GET['idTorneo'] : null;
    $equipoModel = new estEquipoModel();
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($idTorneo)) {

        $equipos = $equipoModel->allEstEquipo($idTorneo);

        header('Content-Type: application/json');
        echo json_encode($equipos);

    } else {

        http_response_code(400); 
        echo json_encode(array("message" => "Solicitud incorrecta o faltan parámetros"));
    }
?>
