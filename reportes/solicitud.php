<?php
session_start();

require('../fpdf/fpdf.php');
require '../bdd/conexion.php';

class PDF extends FPDF
{
// Cabecera
function Header(){
    if(isset($_SESSION['tipo'])){
        if($_SESSION['tipo']==1 || $_SESSION['tipo']==2){
            if (isset($_GET['folio'])){
                ///////
                $folio = $_GET['folio'];
                global $mysqli;
                $consulta_fecha="SELECT CONCAT(ELT(WEEKDAY(now()) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'))
                AS dia_semana, DAYOFMONTH(now()) AS dia,
                CONCAT(ELT (MONTH(now()), 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre','Noviembre', 'Diciembre'))
                AS mes,YEAR(now()) AS nyear;";
                $result = $mysqli->query($consulta_fecha);
                if (!$result) {
                    echo "No se encontro resultados";
                }else{
                    while ($row = mysqli_fetch_array($result)) {
                        $dia_semana = $row['dia_semana'];
                        $dia = $row['dia'];
                        $mes = $row['mes'];
                        $nyear = $row['nyear'];
                    };
                }
    
            }else{
                echo "No se encontro resultados";
            }
        }
    }else{
        header("Location: ../index.php");
        die();
    }

    // Arial bold 14
    $this->SetFont('Arial','B',14);
  
    $this->Image('../imagenes/SsN.png', 10, 10, 50, 25);
    $this->Image('../imagenes/SSChiapas.png', 150, 10, 50, 25);
    $this->Cell(190, 20, utf8_decode("''Solicitud de Servicio Técnico''"), 0, 1, "C");

    $this->SetFont('Arial', 'I', 10);
    $this->Ln(10);
    $this->Cell(5);
    $this->Cell(20, 7, utf8_decode("SECREATARÍA DE SALUD."), 0, 1, "L");
    $this->Cell(5);
    $this->Cell(20, 7, utf8_decode("INSTITUTO DE SALUD."), 0, 1, "L");
    $this->Cell(5);
    $this->Cell(20, 7, utf8_decode("DIRECCIÓN DE PROTECCIÓN CONTRA RIESGOS SANITARIOS."), 0, 1, "L");
    $this->Cell(5); 
    $this->Cell(20, 7, utf8_decode("COORDINACIÓN DE INFORMÁTICA."), 0, 1, "L");

    $this->Ln(5);
    $this->Cell(185, 7, utf8_decode("Asunto: Solicitud de servicio técnico a bien informático.") , 0, 1, "R");
    $this->Cell(185, 7, utf8_decode("Tuxtla Gutiérrez Chiapas A: $dia_semana $dia de $mes de $nyear.") ,0 , 1, "R");

    $this->SetFont('Arial', 'B', 10);
    $this->Ln(10);
    $this->Cell(5);
    $this->Cell(20, 7, utf8_decode("A quien corresponda."),0 , 1, "L");
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

$folio = $_GET['folio'];

global $mysqli;
$query = "SELECT CONCAT(ELT(WEEKDAY(fecha_reporte) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'))
AS semana_reporte, DAYOFMONTH(fecha_reporte) AS dia_reporte,
CONCAT(ELT (MONTH(fecha_reporte), 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre','Noviembre', 'Diciembre'))
AS mes_reporte,YEAR(fecha_reporte) AS reporteyear,
Usuario.nombre AS nombre, Usuario.apellidoPaterno AS paterno, Usuario.apellidoMaterno AS materno, folio, descripcion, tipo_reporte.nombre AS tipo FROM reporte
INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
WHERE Reporte.folio = '$folio';";
$result = $mysqli->query($query);
if (!$result) {
    echo "No se encontro resultados";
}else{
    while ($row = mysqli_fetch_array($result)) {
        $semana_reporte = $row['semana_reporte'];
        $dia_reporte = $row['dia_reporte'];
        $mes_reporte = $row['mes_reporte'];
        $reporteyear = $row['reporteyear'];
        $nombre = $row['nombre'];
        $paterno = $row['paterno'];
        $materno = $row['materno'];
        $folio = $row['folio'];
        $descripcion = $row['descripcion'];
        $tipo = $row['tipo'];

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
        $title =  utf8_decode("Solicitud informática - Folio: $folio");
        $pdf->SetTitle($title);
        $pdf->Ln(10);
        $pdf->Cell(5);
        $pdf->MultiCell(180,7,utf8_decode("Por medio del presente documento, se comunica que el C. $nombre $paterno $materno ha realizado una solicitud de atención a un bien informático el día $semana_reporte $dia_reporte de $mes_reporte de $reporteyear de tipo $tipo y con folio $folio."),0,'J',0);
        $pdf->Ln(10);
        $pdf->Cell(5);
        $pdf->Cell(180, 7, utf8_decode("El solicitante indico lo siguiente:"), 0, 1, "L");
        $pdf->SetFont('Arial','I',12);
        $pdf->Cell(5);
        $pdf->MultiCell(180,7,utf8_decode("$descripcion."),0,'J',0);
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln(40);
        $pdf->Cell(5);
        $pdf->Cell(180, 7, utf8_decode("ATENTAMENTE:"), 0, 1, "C");
        $pdf->Ln(15);
        $pdf->Cell(5);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(180, 7, utf8_decode("Luis Daniel Aguilar Ruíz."), 0, 1, "C");
        $pdf->Cell(5);
        $pdf->Cell(180, 7, utf8_decode("Coordinador de Informática."), 0, 1, "C");
    };
}

/*
function generar($dia_semana,$dia,$mes,$nyear,$semana_reporte,$dia_reporte,$mes_reporte,$reporteyear,$nombre,$paterno,$materno,$folio,$descripcion,$tipo){
    $pdf = new FPDF();
    $pdf->AddPage();

    // Arial bold 15
    $pdf->SetFont('Arial','B',15);
    // Calculamos ancho y posición del título.
    $pdf->Image('../imagenes/SsN.png', 5, 10, 50, 25);
    $pdf->Image('../imagenes/SSChiapas.png', 155, 10, 50, 25);
    $pdf->Cell(190, 20, utf8_decode("''Solicitud de Servicio Técnico''"), 0, 1, "C");


        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(20, 50, "SECREATARIA DE SALUD", 0, 1, "J");
        $pdf->Cell(20, -40, "INSTITUTO DE SALUD", 0, 1, "J");
        $pdf->Cell(20, 50, utf8_decode("DIRECCIÓN DE PROTECCION CONTRA RIESGOS SANITARIOS"), 0, 1, "J");
        $pdf->Cell(20, -40, utf8_decode("COORDINACIÓN DE INFORMÁTICA"), 0, 1, "J");

        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(120);
        $pdf->Cell(20, 70, "Oficio: $folio" , 0, 1, "R");
        $pdf->Cell(120);
        $pdf->Cell(20, -60, "Asunto: $tipo", 0, 1, "J");
        $pdf->Cell(270, 70, utf8_decode("Tuxtla Gutiérrez Chiapas A: $dia_semana $dia de $mes de $nyear") ,0 , 1, "C");

        $pdf->Cell(60, -20, utf8_decode("Ing. Luis Daniel Aguilar Ruíz"), 0, 1, "J");
        $pdf->Cell(57, 30, utf8_decode("Coordinador de informática"), 0, 1,"J");

        $pdf->Cell(57, 5, utf8_decode("Descripción: "), 0, 1, "J");
        $pdf->Ln(20);
        $pdf->MultiCell(150, 5, utf8_decode($descripcion));

        $pdf->Cell(57, 80, "A T E N T A M E N T E", 0, 1, "J");
        $pdf->Cell(57, -5, "Solicitante: ", 0, 1, "J");
        $pdf->Cell(57, 15, utf8_decode("$nombre $paterno $materno"), 0, 1, "J");
        //$pdf->Image('../imagenes/soporte-tecnico.jpg', 100, 200, 90, 50);

        $title =  utf8_decode("''Solicitud de Servicio Técnico''");
        $pdf->SetTitle($title);
        $pdf->Output(); 
}
*/
$pdf->Output(); 
?>




