<?php
// Session
session_start();

// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

if (isset($_GET['wait'])){
    $username = $_SESSION['username'];
    todaywait($username);
}

else if (isset($_GET['attention'])){
    $username = $_SESSION['username'];
    todayattention($username);
}

else if (isset($_GET['historial'])) {
    $estado = $_GET['estado'];
    $username = $_SESSION['username'];
    verHistorial($username,$estado);
}

else if (isset($_GET['filtrar'])) {
    $estado = $_GET['estado'];
    $fechainicio = $_GET['inicio'];
    $fechafin = $_GET['fin'];
    $username = $_SESSION['username'];
    filtrarHistorial($username,$estado,$fechainicio,$fechafin);
}

else if (isset($_POST['cancelar_reporte'])){
    $folio = $_POST['cancelar_reporte'];
    cancelarSolicitud($folio);
}
    
else{
    
}

/* *********************************************************** */

function todaywait($username){
    global $mysqli;
    $select_query = "SELECT count(folio) AS total FROM reporte 
    WHERE reporte.estado = '1' AND usuario_reporta = '$username'";
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

function todayattention($username){
    global $mysqli;
    $select_query = "SELECT count(folio) AS total FROM reporte 
    WHERE reporte.estado = '2' AND usuario_reporta ='$username'";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "No se encontro resultados";
        $nombre = 'no hay reportes finalizados';
        $total = '0';
        $json[] = array(
            'total' => $total
        );
        $jsonstring = json_encode($json);
        echo $jsonstring;
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

// Ver historial de solicitudes
function verHistorial($username,$estado){
    global $mysqli;
    global $select_query;
    if($estado == '1' || $estado == '2'){
        $select_query = "SELECT folio, fecha_reporte AS fecha, descripcion, tipo_reporte.nombre AS tipo, estado.nombre AS estado, IF(usuario_responde='root', 'Aún no asignado', usuario_responde) AS usuario, IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecha_respuesta, IF(respuesta IS NULL, 'Aún no hay respuesta', respuesta) AS respuesta FROM reporte
        INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
        INNER JOIN estado ON reporte.estado = estado.idEstado
        INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
        INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
        WHERE usuario_reporta='$username' and reporte.estado = '$estado'
        ORDER BY fecha_reporte DESC";
    }else{
        $select_query = "SELECT folio, fecha_reporte AS fecha, descripcion, tipo_reporte.nombre AS tipo, estado.nombre AS estado, IF(usuario_responde='root', 'Aún no asignado', usuario_responde) AS usuario, IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecha_respuesta, IF(respuesta IS NULL, 'Aún no hay respuesta', respuesta) AS respuesta FROM reporte
        INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
        INNER JOIN estado ON reporte.estado = estado.idEstado
        INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
        INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
        WHERE usuario_reporta='$username' and reporte.estado = '$estado' AND fecha_respuesta >= CURDATE()
        ORDER BY fecha_reporte DESC";
    }
    
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'descripcion' => $row['descripcion'],
                'tipo' => $row['tipo'],
                'estado' => $row['estado'],
                'usuario' => $row['usuario'],
                'fecha_respuesta' => $row['fecha_respuesta'],
                'respuesta' => $row['respuesta']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

}

// Ver historial de solicitudes
function filtrarHistorial($username,$estado,$fechainicio,$fechafin){
    global $mysqli;
    global $select_query;
    if($estado == '1' || $estado == '2'){
        $select_query = "SELECT folio, fecha_reporte AS fecha, descripcion, tipo_reporte.nombre AS tipo, estado.nombre AS estado, IF(usuario_responde='root', 'Aún no asignado', usuario_responde) AS usuario, IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecha_respuesta, IF(respuesta IS NULL, 'Aún no hay respuesta', respuesta) AS respuesta FROM reporte
        INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
        INNER JOIN estado ON reporte.estado = estado.idEstado
        INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
        INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
        WHERE usuario_reporta='$username' and reporte.estado = '$estado' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin 23:59:59')
        ORDER BY fecha_reporte DESC";
    }
    else{
        $select_query = "SELECT folio, fecha_reporte AS fecha, descripcion, tipo_reporte.nombre AS tipo, estado.nombre AS estado, IF(usuario_responde='root', 'Aún no asignado', usuario_responde) AS usuario, IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecha_respuesta, IF(respuesta IS NULL, 'Aún no hay respuesta', respuesta) AS respuesta FROM reporte
        INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
        INNER JOIN estado ON reporte.estado = estado.idEstado
        INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
        INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
        WHERE usuario_reporta='$username' and reporte.estado = '$estado' AND (fecha_respuesta BETWEEN '$fechainicio' AND '$fechafin 23:59:59')
        ORDER BY fecha_reporte DESC";
    }
    
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha' => $row['fecha'],
                'descripcion' => $row['descripcion'],
                'tipo' => $row['tipo'],
                'estado' => $row['estado'],
                'usuario' => $row['usuario'],
                'fecha_respuesta' => $row['fecha_respuesta'],
                'respuesta' => $row['respuesta']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

}

// Cancelar solicitud
function cancelarSolicitud($folio){
    global $mysqli;
    $query = "UPDATE Reporte SET estado='4', fecha_respuesta = now() WHERE folio='$folio' and estado != 4  LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($query);
    // Si se modifico con exito
    if ($result) {
        echo "Solicitud con folio ".$folio." cancelada";
        // Si no se modifico con exito
    } else {
        echo "No fué posible cancelar la solicitud, por favor reintente";
    }
}

?>