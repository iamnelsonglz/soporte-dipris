<?php
require('../fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

    // Arial bold 15
    $pdf->SetFont('Arial','B',15);
    // Calculamos ancho y posición del título.
    $pdf->Image('../imagenes/SsN.png', 5, 5, 50, 25);
    $pdf->Image('../imagenes/SSChiapas.png', 155, 5, 50, 25);
    $pdf->Cell(190, 7, "''Solicitud de Servicio Tecnico''", 0, 1, "C");


        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(20, 50, "SECREATARIA DE SALUD", 0, 1, "J");
        $pdf->Cell(20, -40, "INSTITUTO DE SALUD", 0, 1, "J");
        $pdf->Cell(20, 50, "DIRECCION DE PROTECCION CONTRA RIESGOS SANITARIOS", 0, 1, "J");
        $pdf->Cell(20, -40, "COORDINACION DE INFORMATICA", 0, 1, "J");

        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(120);
        $pdf->Cell(20, 70, "Oficio:" , 0, 1, "J");
        $pdf->Cell(120);
        $pdf->Cell(20, -60, "Asunto:", 0, 1, "J");

        $pdf->Cell(270, 70, "Tuxtla Gutierrez Chiapas; A " .date(" d - Y - m"),0 , 1, "C");

        $pdf->Cell(60, -20, "Ing. Luis Daniel Aguilar Ruiz", 0, 1, "J");
        $pdf->Cell(57, 30, "Coordinador de informatica", 0, 1,"J");

        $pdf->Cell(57, 5, "Descripcion: ", 0, 1, "J");
        $pdf->Ln(20);
        $pdf->MultiCell(150,5,'se eneijfkjnmfklamvokaenmvjkanbjakdnbjknbomiaeknmhbioeaknmboienboeaioufonhskjdnvoajlndsvbmoiakjlndsvjsn');

        $pdf->Cell(57, 80, "A T E N T A M E N T E", 0, 1, "J");
        $pdf->Cell(57, -5, "solicitante: ", 1, 1, "J");
        $pdf->Image('../imagenes/soporte-tecnico.jpg', 100, 200, 90, 50);







        $title =  "''Solicitud de Servicio Tecnico''";
        $pdf->SetTitle($title);
        $pdf->Output(); 
?>




