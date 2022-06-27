<?php
session_start();
require('../fpdf/fpdf.php');
require '../bdd/conexion.php';

if(isset($_SESSION['tipo'])){
    if($_SESSION['tipo']==1){
        if (isset($_GET['folio'])){
            $folio = $_GET['folio'];
            consulta($folio);
        }else{
            echo "No se encontro resultados";
        }
    }
}else{
    header("Location: ../index.php");
    die();
}




function consulta($folio){
    global $mysqli;
    $select_query = "SELECT CONCAT(ELT(WEEKDAY(now()) + 1, 'Lunes', 'Martes', 'Miercoles', 'Juevez', 'Viernes', 'Sabado', 'Domingo'))
    AS dia_semana, 
    DAYOFMONTH(now()) AS dia,
    CONCAT(ELT (MONTH(now()), 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Noviembre', 'Diciembre'))
    AS mes,
    YEAR(now()) AS nyear, Usuario.nombre AS nombre, Usuario.apellidoPaterno AS paterno, Usuario.apellidoMaterno AS materno, folio, descripcion, tipo_reporte.nombre AS tipo FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    WHERE Reporte.folio = '$folio';";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "No se encontro resultados";
    }else{
        while ($row = mysqli_fetch_array($result)) {
            $dia_semana = $row['dia_semana'];
            $dia = $row['dia'];
            $mes = $row['mes'];
            $nyear = $row['nyear'];
            $nombre = $row['nombre'];
            $paterno = $row['paterno'];
            $materno = $row['materno'];
            $folio = $row['folio'];
            $descripcion = $row['descripcion'];
            $tipo = $row['tipo'];
            generar($dia_semana,$dia,$mes,$nyear,$nombre,$paterno,$materno,$folio,$descripcion,$tipo);
        };
        
    }
}

function generar($dia_semana,$dia,$mes,$nyear,$nombre,$paterno,$materno,$folio,$descripcion,$tipo){
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
        $pdf->Cell(20, 70, "Oficio: $folio" , 0, 1, "J");
        $pdf->Cell(120);
        $pdf->Cell(20, -60, "Asunto: $tipo", 0, 1, "J");
        $pdf->Cell(270, 70, utf8_decode("Tuxtla Gutiérrez Chiapas A: $dia_semana $dia de $mes de $nyear") /*.date(" d - Y - m")*/,0 , 1, "C");

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


?>




