<?php
require('../fpdf/fpdf.php');
require '../bdd/conexion.php';

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    if(isset($_POST['fechainicio']) && isset($_POST['fechafin']) && isset($_POST['where'])){
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
        $where = $_POST['where'];
        $estado="";
        switch($where){
            case 1:
                $estado = "en espera";
                break;
            case 2:
                $estado = "en atención";
                break;
            case 3:
                $estado = "finalizado";
                break;
            case 4:
                $estado = "cancelado";
                break;
            default:
                $estado = "desconocido";
                break;
        }
    }else{
        header("Location: ../inicio.php");
        die();
    }

    // Arial bold 15
    $this->SetFont('Arial','B',14);
    $this->Image('../imagenes/SsN.png', 15, 10, 50, 25);
    $this->Image('../imagenes/SSChiapas.png', 230, 10, 50, 25);
    $this->Cell(110);
    $this->Cell(20, 7, utf8_decode("Secretaría de Salud"), 0, 1, "J");
    $this->Cell(106);
    $this->Cell(20, 7, utf8_decode("Dirección de Protección"), 0, 1, "J");
    $this->Cell(104);
    $this->Cell(20, 7, "contra Riesgos Sanitarios", 0, 1, "J");
    
    
    $this->SetFont('Arial','',12);
    $this->Ln(10);
    $this->Cell(265, 8, utf8_decode("Asunto: Reporte de solicitudes con estado $estado.") ,0,1,"R");
    $this->Ln(10);
    $this->SetFont('Arial','B',12);
    $this->Cell(10);
    $this->Cell(50, 8, "Fecha de inicio:" ,1,0,"J");
    $this->SetFont('Arial','',12);
    $this->Cell(30, 8, "$fechainicio" ,1,1,"C");
    $this->Cell(10);
    $this->SetFont('Arial','B',12);
    $this->Cell(50, 8, utf8_decode("Fecha de terminación:") ,1,0,"J");
    $this->SetFont('Arial','',12);
    $this->Cell(30, 8, "$fechafin" ,1,1,"C");
   
    

    $this->SetFont('Arial','B',13);
    
    $this->Ln(10);
    $this->Cell(10);
    $this->Cell(42,10,'Fecha reporte',1,0,'C',0);
	$this->Cell(40,10,'Tipo',1,0,'C',0);
	$this->Cell(65,10,'Personal que reporta',1,0,'C',0);
    $this->Cell(42,10,'Fecha respuesta',1,0,'C',0);
    $this->Cell(65,10,'Personal que responde',1,1,'C',0);
  
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

global $mysqli;

$pdf = new PDF("L");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$title =  utf8_decode("Reporte de solicitud informática");
$pdf->SetTitle($title);

if(isset($_POST['fechainicio']) && isset($_POST['fechafin']) && isset($_POST['where'])){
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    $estado = $_POST['where'];

    switch($estado){
        case 1:
            $consulta ="SELECT fecha_reporte AS fecha, tipo_reporte.nombre AS tipo,
            Usuarioa.nombre AS nombrereporta, Usuarioa.apellidoPaterno AS paternoreporta, Usuarioa.apellidoMaterno AS maternoreporta,
            IF(Usuariob.username='root', 'Aún no asignado', Usuariob.nombre ) AS nombreresponde, IF(Usuariob.username='root', '', Usuariob.apellidoPaterno ) AS paternoresponde, IF(Usuariob.username='root', '', Usuariob.apellidoMaterno ) AS maternoresponde,
            IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecharespuesta FROM reporte
            INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
            INNER JOIN usuario AS Usuarioa ON Reporte.usuario_reporta = Usuarioa.username
            INNER JOIN usuario AS Usuariob ON Reporte.usuario_responde = Usuariob.username
            INNER JOIN Categoria ON Usuarioa.categoria = Categoria.idCategoria
            WHERE estado = '$estado' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin'+1)
            ORDER BY Usuarioa.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte ASC";
            break;
        case 2:
            $consulta ="SELECT fecha_reporte AS fecha, tipo_reporte.nombre AS tipo,
            Usuarioa.nombre AS nombrereporta, Usuarioa.apellidoPaterno AS paternoreporta, Usuarioa.apellidoMaterno AS maternoreporta,
            IF(Usuariob.username='root', 'Aún no asignado', Usuariob.nombre ) AS nombreresponde, IF(Usuariob.username='root', '', Usuariob.apellidoPaterno ) AS paternoresponde, IF(Usuariob.username='root', '', Usuariob.apellidoMaterno ) AS maternoresponde,
            IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecharespuesta FROM reporte
            INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
            INNER JOIN usuario AS Usuarioa ON Reporte.usuario_reporta = Usuarioa.username
            INNER JOIN usuario AS Usuariob ON Reporte.usuario_responde = Usuariob.username
            INNER JOIN Categoria ON Usuarioa.categoria = Categoria.idCategoria
            WHERE estado = '$estado' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin'+1)
            ORDER BY Usuarioa.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte ASC";    
            break;
        case 3:
            $consulta ="SELECT fecha_reporte AS fecha, tipo_reporte.nombre AS tipo,
            Usuarioa.nombre AS nombrereporta, Usuarioa.apellidoPaterno AS paternoreporta, Usuarioa.apellidoMaterno AS maternoreporta,
            IF(Usuariob.username='root', 'Aún no asignado', Usuariob.nombre ) AS nombreresponde, IF(Usuariob.username='root', '', Usuariob.apellidoPaterno ) AS paternoresponde, IF(Usuariob.username='root', '', Usuariob.apellidoMaterno ) AS maternoresponde,
            IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecharespuesta FROM reporte
            INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
            INNER JOIN usuario AS Usuarioa ON Reporte.usuario_reporta = Usuarioa.username
            INNER JOIN usuario AS Usuariob ON Reporte.usuario_responde = Usuariob.username
            INNER JOIN Categoria ON Usuarioa.categoria = Categoria.idCategoria
            WHERE estado = '$estado' AND (fecha_respuesta BETWEEN '$fechainicio' AND '$fechafin'+1)
            ORDER BY Usuarioa.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte ASC";
            break;
        case 4:
            $consulta ="SELECT fecha_reporte AS fecha, tipo_reporte.nombre AS tipo,
            Usuarioa.nombre AS nombrereporta, Usuarioa.apellidoPaterno AS paternoreporta, Usuarioa.apellidoMaterno AS maternoreporta,
            IF(Usuariob.username='root', 'Aún no asignado', Usuariob.nombre ) AS nombreresponde, IF(Usuariob.username='root', '', Usuariob.apellidoPaterno ) AS paternoresponde, IF(Usuariob.username='root', '', Usuariob.apellidoMaterno ) AS maternoresponde,
            IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecharespuesta FROM reporte
            INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
            INNER JOIN usuario AS Usuarioa ON Reporte.usuario_reporta = Usuarioa.username
            INNER JOIN usuario AS Usuariob ON Reporte.usuario_responde = Usuariob.username
            INNER JOIN Categoria ON Usuarioa.categoria = Categoria.idCategoria
            WHERE estado = '$estado' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin'+1)
            ORDER BY Usuarioa.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte ASC";
            break;
        default:
            break;
    }
    $result = $mysqli->query($consulta);

    if (!$result) {
        echo "No se encontro resultados";
    }else{
        while ($row = mysqli_fetch_array($result)) {
            $fechareporte = $row['fecha'];
            $tipo = $row['tipo'];
            $nombrereporta = $row['nombrereporta'];
            $paternoreporta = $row['paternoreporta'];
            $maternoreporta = $row['maternoreporta'];
            $fecharesponde = $row['fecharespuesta'];
            $nombreresponde = $row['nombreresponde'];
            $paternoresponde = $row['paternoresponde'];
            $maternoresponde = $row['maternoresponde'];

            $pdf->Cell(10);
            $pdf->Cell(42,10,utf8_decode("$fechareporte"),1,0,'C',0);
            $pdf->Cell(40, 10, utf8_decode("$tipo"),1,0,'C',0);
            $pdf->Cell(65,10, utf8_decode("$nombrereporta $paternoreporta $maternoreporta"),1,0,'C',0);
            $pdf->Cell(42,10,utf8_decode("$fecharesponde"),1,0,'C',0);
            $pdf->Cell(65,10,utf8_decode("$nombreresponde $paternoresponde $maternoresponde"),1,1,'C',0);
        };
    }
}else{
    header("Location: ../inicio.php");
    die();
}
$pdf->Output();

