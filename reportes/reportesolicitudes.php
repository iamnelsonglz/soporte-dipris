<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
	
    // Arial bold 15
    $this->SetFont('Arial','B',16);
    $this->Image('../imagenes/SsN.png', 5, 5, 50, 25);
    $this->Image('../imagenes/SSChiapas.png', 155, 5, 50, 25);
    $this->Cell(190, 7, "''Reporte de Servicio Tecnico''", 0, 1, "C");
    // Salto de línea
    $this->Ln(20);

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


//$pdf = new PDF("L");
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
	

/*while ($row=$resultado->fetch_assoc()) {
	$pdf->Cell(50,10,$row['nombre'],1,0,'C',0);
	$pdf->Cell(45,10,$row['tipo_reporte'],1,0,'C',0);
	$pdf->Cell(45,10,$row['persona'],1,0,'C',0);
    $pdf->Cell(45,10,$row['descripcion'],1,1,'C',0);

}*/
$pdf->Output();

?>