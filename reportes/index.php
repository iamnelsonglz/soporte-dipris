<?php
require('../fpdf/fpdf.php');



class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    if(isset($_POST['fechainicio']) && isset($_POST['fechafin'])){
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
    }else{
        header("Location: ../inicio.php");
        die();
    }
	
    // Arial bold 15
    $this->SetFont('Arial','B',14);
    $this->Image('../imagenes/SsN.png', 5, 5, 50, 25);
    $this->Image('../imagenes/SSChiapas.png', 155, 5, 50, 25);
    $this->Cell(68);
    $this->Cell(20, 7, "''Secretaria de salud", 0, 1, "J");
    $this->Cell(64);
    $this->Cell(20, 7, utf8_decode("Dirección de Protección"), 0, 1, "J");
    $this->Cell(60);
    $this->Cell(20, 7, "Contra Riesgos Sanitarios''", 0, 1, "J");
    
    $this->SetFont('Arial','B',12);
    $this->Ln(10);
    $this->Cell(48, 8, "Fecha de inicio:" ,1,0,"J");
    $this->Cell(35, 8, "$fechainicio" ,1,1,"C");
    $this->Cell(48, 8, "Fecha de Terminacion:" ,1,0,"J");
    $this->Cell(35, 8, "$fechafin" ,1,1,"C");
    
    $this->SetFont('Arial','B',14);
    $this->Ln(10);
    $this->Cell(3);
    $this->Cell(50,10,'Folio',1,0,'C',0);
	$this->Cell(45,10,'Reporte',1,0,'C',0);
	$this->Cell(45,10,'Nombre',1,0,'C',0);
    $this->Cell(45,10,'Descripcion',1,1,'C',0);
  
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página') .$this->PageNo().'/{nb}',0,0,'C');
}
}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$title =  "''Reportes de Servicio Tecnico''";
$pdf->SetTitle($title);
	

/*while ($row=$resultado->fetch_assoc()) {
	$pdf->Cell(50,10,$row['nombre'],1,0,'C',0);
	$pdf->Cell(45,10,$row['tipo_reporte'],1,0,'C',0);
	$pdf->Cell(45,10,$row['persona'],1,0,'C',0);
    $pdf->Cell(45,10,$row['descripcion'],1,1,'C',0);

}*/
$pdf->Output();
