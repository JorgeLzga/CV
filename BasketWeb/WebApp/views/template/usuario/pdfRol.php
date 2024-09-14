<?php
    require('../../../fpdf/fpdf.php');

    include_once('../../../controllers/TorneosController.php');
    include_once('../../../controllers/UsuarioController.php');

    class PDF extends FPDF {
        public $lstTorneo;
        public $lstCalendarioRoles;

        function __construct($lstTorneo, $lstCalendarioRoles, $orientation = 'P', $unit = 'mm', $size = 'A4') {
            parent::__construct($orientation, $unit, $size);
            $this->SetMargins(25, 12, 25);
            $this->lstTorneo = $lstTorneo;
            $this->lstCalendarioRoles = $lstCalendarioRoles;
        }

        function Header() {
            $this->SetFillColor(166, 47, 20);
            $this->Rect(0, 0, $this->GetPageWidth(), 10, 'F');

            $this->SetFont('Arial', 'B', 20);
            $textoEnMayusculas = strtoupper($this->lstTorneo['vNombreTorneo']);

            $this->SetFillColor(255, 255, 255);

            $this->SetTextColor(166, 47, 20); 
            $this->Cell(0, 15, utf8_decode($textoEnMayusculas), 0, 1, 'C', true);

            $this->Ln(5);
        }

        function Footer() {
            $this->SetFillColor(166, 47, 20); // Color de fondo
            $this->Rect(0, $this->GetPageHeight() - 15, $this->GetPageWidth(), 15, 'F'); 

            $this->SetY(-10);

            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(255, 255, 255); 
            $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
        }


    }

    $idTorneo = $_GET['idTorneo'];

    $objTorneosControllador = new torneosController();
    $lstTorneo = $objTorneosControllador->selectOneTorneo($idTorneo);

    $objCalendarioRolesControllador = new usuarioController();
    $lstCalendarioRoles = $objCalendarioRolesControllador->pdfrol($idTorneo);

    $pdf = new PDF($lstTorneo, $lstCalendarioRoles);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',12);
    
    foreach ($lstCalendarioRoles as $rol) {

        $pdf->SetFillColor(217, 130, 54);
        $pdf->SetTextColor(255, 255, 255); 
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 12, utf8_decode('Partido ' . $rol['vTipoJuego']), 0, 1, 'C', true); 
    
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(166, 47, 20); 
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, utf8_decode(' Equipo Local'), 1, 0, 'L',true);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(90, 10, utf8_decode(' '.$rol['NombreLocal']), 1, 0, 'L',true);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(166, 47, 20); 
        $pdf->Cell(30, 10, utf8_decode(' '.$rol['ResultadoLocal']), 1, 1, 'L',true);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(166, 47, 20); 
        $pdf->Cell(40, 10, utf8_decode(' Equipo Visitante'), 1, 0, 'L', true);

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);  
        $pdf->Cell(90, 10, utf8_decode(' '.$rol['NombreVisitante']), 1, 0, 'L',true);
       
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(166, 47, 20); 
        $pdf->Cell(30, 10, utf8_decode(' '.$rol['ResultadoVisitante']), 1, 1, 'L', true);
        
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->Cell(160, 10, utf8_decode('Sede: '.$rol['vSede']), 1, 1, 'C',true);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->Cell(80, 10, utf8_decode('Fecha: '.$rol['vFecha']), 1, 0, 'C', true);
        $pdf->Cell(80, 10, utf8_decode('Hora: ' .$rol['vHora']), 1, 1, 'C', true);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(166, 47, 20);  
        $pdf->Cell(160, 12, utf8_decode('Estatus: '.$rol['Estado'].' '. $rol['EquipoGanador']), 1, 1, 'C', true);

        $pdf->Ln(15);

    }

    $nombreTorneo = $lstTorneo['vNombreTorneo']; 
    $nombreArchivo = 'reporte_' . $nombreTorneo . '.pdf'; 

    $pdf->Output($nombreArchivo, 'I');



?>
