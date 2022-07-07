<?php
// Session
session_start();

// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

if (isset($_GET['finish'])){
    todayfinish();
}

else if (isset($_GET['wait'])){
    todaywait();
}

else if (isset($_GET['attention'])){
    todayattention();
}

// Condición para mostrar todos los estados en el select
else if (isset($_GET['where'])) {
    verEstados();
    
}

// Condición para mostrar los usuarios de categoria soporte
else if (isset($_GET['soporte'])){
    usuariosSoporte();
}

// Condición para mostrar todos los reportes pendientes
else if (isset($_GET['espera'])) {
    verReportesEspera();
}

else if(isset($_GET['atencion'])){
    verReportesAtencion();
}

else if(isset($_GET['finalizado'])){
    verReportesFinalizado();
}

else if(isset($_GET['cancelado'])){
    verReportesCancelado();
}

else if(isset($_GET['esperafiltro'])){
    $fechainicio = $_GET['inicio'];
    $fechafin = $_GET['fin'];
    filtrarReportesEspera($fechainicio,$fechafin);
}

else if(isset($_GET['atencionfiltro'])){
    $fechainicio = $_GET['inicio'];
    $fechafin = $_GET['fin'];
    filtrarReportesAtencion($fechainicio,$fechafin);
}

else if(isset($_GET['finalizadofiltro'])){
    $fechainicio = $_GET['inicio'];
    $fechafin = $_GET['fin'];
    filtrarReportesFinalizado($fechainicio,$fechafin);
}

else if(isset($_GET['canceladofiltro'])){
    $fechainicio = $_GET['inicio'];
    $fechafin = $_GET['fin'];
    filtrarReportesCancelado($fechainicio,$fechafin);
}

// Condición para asignar una tarea a un usuario de soporte
else if(isset($_POST['folio_reporte'])){
    $folio = $_POST['folio_reporte'];
    $usuario = $_POST['add_soporte'];
    asignar($folio,$usuario);
}

// Condición cuando no se cumple ninguna otra
else{
    header("Location: ../inicio.php");
    die();
}

/* ****************************** Ver Reportes | Administrador ****************************** */

// Ver la cantidad de reportes finalizados del día
function todayfinish(){
    global $mysqli;
    $select_query = "SELECT folio, usuario.nombre AS nombre, COUNT(folio) AS total FROM reporte
    INNER JOIN usuario ON reporte.usuario_responde = usuario.username
    WHERE reporte.estado = '3' AND fecha_respuesta >= CURDATE()
    GROUP BY usuario.nombre";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "No se encontro resultados";
        $nombre = 'no hay reportes finalizados';
        $total = '0';
        $json[] = array(
            'nombre' => $nombre,
            'total' => $total
        );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'nombre' => $row['nombre'],
            'total' => $row['total']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Ver la cantidad de reportes en atención del día
function todayattention(){
    global $mysqli;
    $select_query = "SELECT folio, usuario.nombre AS nombre, COUNT(folio) AS total FROM reporte
    INNER JOIN usuario ON reporte.usuario_responde = usuario.username
    WHERE reporte.estado = '2'
    GROUP BY usuario.nombre";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "No se encontro resultados";
        $nombre = 'no hay reportes finalizados';
        $total = '0';
        $json[] = array(
            'nombre' => $nombre,
            'total' => $total
        );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'nombre' => $row['nombre'],
            'total' => $row['total']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

function todaywait(){
    global $mysqli;
    $select_query = "SELECT count(folio) AS total FROM reporte 
    WHERE reporte.estado = '1'";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "No se encontro resultados";
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'total' => $row['total']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Ver estados de reporte existentes
function verEstados(){
    global $mysqli;
    $select_query = "SELECT idEstado, nombre FROM Estado ORDER BY idEstado ASC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "No se encontro resultados para los estados de reportes";
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'idEstado' => $row['idEstado'],
            'nombre' => $row['nombre']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Ver usuarios de categoria soporte
function usuariosSoporte(){
    global $mysqli;
    $select_query = "SELECT username,nombre FROM usuario WHERE categoria=2 ";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "No se encontro resultados para los estados de reportes";
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'usuario' => $row['username'],
            'nombre' => $row['nombre']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Ver reportes registrados
function verReportesEspera(){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuario.nombre AS usuario FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE estado = '1' 
    ORDER BY Usuario.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte DESC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'tipo' => $row['tipo'],
                'usuario' => $row['usuario']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

}

function verReportesAtencion(){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuarioa.nombre AS usuario, Usuariob.username AS username, Usuariob.nombre AS responde FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario AS Usuarioa ON Reporte.usuario_reporta = Usuarioa.username
    INNER JOIN usuario AS Usuariob ON Reporte.usuario_responde = Usuariob.username
    INNER JOIN Categoria ON Usuarioa.categoria = Categoria.idCategoria
    WHERE estado = '2' 
    ORDER BY Usuarioa.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte DESC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'tipo' => $row['tipo'],
                'usuario' => $row['usuario'],
                'user' => $row['username'],
                'responde' => $row['responde']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

function verReportesFinalizado(){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuarioa.nombre AS usuario, Usuariob.nombre AS responde FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario AS Usuarioa ON Reporte.usuario_reporta = Usuarioa.username
    INNER JOIN usuario AS Usuariob ON Reporte.usuario_responde = Usuariob.username
    INNER JOIN Categoria ON Usuarioa.categoria = Categoria.idCategoria
    WHERE estado = '3'  AND fecha_reporte >= CURDATE()
    ORDER BY Usuarioa.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte DESC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'tipo' => $row['tipo'],
                'usuario' => $row['usuario'],
                'responde' => $row['responde']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

function verReportesCancelado(){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, usuario_reporta AS usuario FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE estado = '4' AND fecha_reporte >= CURDATE()
    ORDER BY Usuario.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte DESC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'tipo' => $row['tipo'],
                'usuario' => $row['usuario']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

function filtrarReportesEspera($fechainicio,$fechafin){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuario.nombre AS usuario FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE estado = '1' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin 23:59:59')
    ORDER BY Usuario.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte DESC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'tipo' => $row['tipo'],
                'usuario' => $row['usuario']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

function filtrarReportesAtencion($fechainicio,$fechafin){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuarioa.nombre AS usuario, Usuariob.username AS username, Usuariob.nombre AS responde FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario AS Usuarioa ON Reporte.usuario_reporta = Usuarioa.username
    INNER JOIN usuario AS Usuariob ON Reporte.usuario_responde = Usuariob.username
    INNER JOIN Categoria ON Usuarioa.categoria = Categoria.idCategoria
    WHERE estado = '2'  AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin 23:59:59')
    ORDER BY Usuarioa.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte DESC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'tipo' => $row['tipo'],
                'usuario' => $row['usuario'],
                'user' => $row['username'],
                'responde' => $row['responde']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

function filtrarReportesFinalizado($fechainicio,$fechafin){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuarioa.nombre AS usuario, Usuariob.nombre AS responde FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario AS Usuarioa ON Reporte.usuario_reporta = Usuarioa.username
    INNER JOIN usuario AS Usuariob ON Reporte.usuario_responde = Usuariob.username
    INNER JOIN Categoria ON Usuarioa.categoria = Categoria.idCategoria
    WHERE estado = '3' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin 23:59:59')
    ORDER BY Usuarioa.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte DESC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'tipo' => $row['tipo'],
                'usuario' => $row['usuario'],
                'responde' => $row['responde']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

function filtrarReportesCancelado($fechainicio,$fechafin){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuario.nombre AS usuario FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE estado = '4' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin 23:59:59')
    ORDER BY Usuario.categoria ASC, Tipo_reporte.prioridad ASC, fecha_reporte DESC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'tipo' => $row['tipo'],
                'usuario' => $row['usuario']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// Asignar tarea
function asignar($folio,$usuario){
    global $mysqli;
    $query = "UPDATE Reporte SET usuario_responde='$usuario', estado='2' WHERE folio='$folio'  LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($query);
    // Si se modifico con exito
    if ($result) {
        echo "Reporte con folio ".$folio." asignado a ".$usuario;
        // Si no se modifico con exito
    } else {
        echo "No se pudo modificar el registro";
    }
}
?>