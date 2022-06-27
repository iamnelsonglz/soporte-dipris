<?php
// Session
session_start();

// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

/* ****************************** Nuevo Reporte ****************************** */

// Condición para mostrar todos los reportes pendientes
if (isset($_GET['historialespera'])) {
    $username = $_SESSION['username'];
    verHistorialEspera($username);
}

// Condición para mostrar todos los reportes pendientes
else if (isset($_GET['historial'])) {
    $username = $_SESSION['username'];
    verHistorial($username);
}

else if (isset($_POST['cancelar_reporte'])){
    $folio = $_POST['cancelar_reporte'];
    cancelarReporte($folio);
}
    
else{
    
}

/* *********************************************************** */

// Ver historial de reportes
function verHistorialEspera($username){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, descripcion, tipo_reporte.nombre AS tipo, estado.nombre AS estado, IF(usuario_responde='root', 'Aún no asignado', usuario_responde) AS usuario, IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecha_respuesta, IF(respuesta IS NULL, 'Aún no hay respuesta', respuesta) AS respuesta FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN estado ON reporte.estado = estado.idEstado
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE usuario_reporta='$username' and reporte.estado = '1'
    ORDER BY fecha_reporte DESC";
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

// Ver historial de reportes
function verHistorial($username){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, descripcion, tipo_reporte.nombre AS tipo, estado.nombre AS estado, IF(usuario_responde='root', 'Aún no asignado', usuario_responde) AS usuario, IF(fecha_respuesta IS NULL, 'Aún no respondido', fecha_respuesta) AS fecha_respuesta, IF(respuesta IS NULL, 'Aún no hay respuesta', respuesta) AS respuesta FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN estado ON reporte.estado = estado.idEstado
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE usuario_reporta='$username' and reporte.estado != 1
    ORDER BY fecha_reporte DESC";
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

function cancelarReporte($folio){
    global $mysqli;
    $query = "UPDATE Reporte SET estado='4' WHERE folio='$folio' and estado != 4  LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($query);
    // Si se modifico con exito
    if ($result) {
        echo "Reporte con folio ".$folio." cancelado";
        // Si no se modifico con exito
    } else {
        echo "No fué posible cancelar este reporte";
    }
}

// Asignar tarea
function asignar($folio,$usuario){
    global $mysqli;
    $query = "UPDATE Reporte SET usuario_responde='$usuario', estado='2' WHERE folio='$folio' and estado='1' LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($query);
    // Si se modifico con exito
    if ($result) {
        echo "Reporte con folio ".$folio." asignado a ".$usuario;
        // Si no se modifico con exito
    } else {
        echo "No fué posible asignar esta tarea";
    }
}

?>