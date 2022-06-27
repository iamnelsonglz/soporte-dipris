<?php
// Session
session_start();

// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

/* ****************************** Nuevo Reporte ****************************** */

if (isset($_GET['estado'])) {
    verEstados();
}

// Condición para mostrar todos los reportes pendientes
else if (isset($_GET['pendientes'])) {
    verReportesPendientes();
}

// Condición para asignar una tarea a un usuario de soporte
else if(isset($_POST['autoasignar'])){
    $folio = $_POST['autoasignar'];
    $usuario = $_SESSION['username'];
    asignar($folio,$usuario);
}

else if(isset($_GET['atencion'])){
    $username = $_SESSION['username'];
    filtrarReporteAtencion($username);

}

else if(isset($_GET['finalizado'])){
    $username = $_SESSION['username'];
    filtrarReporteFinalizado($username);

}

else if(isset($_GET['responderver'])){
    $folio = $_GET['responderver'];
    verReporteReponder($folio);

}

else if(isset($_GET['respuestaver'])){
    $folio = $_GET['respuestaver'];
    verRepuestaReporte($folio);

}

else if(isset($_POST['responder'])){
    $folio = $_POST['responder'];
    $respuesta = $_POST['respuesta'];
    responderReporte($folio,$respuesta);

}

else{
    
}

/* *********************************************************** */

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

// Ver reportes registrados
function verReportesPendientes(){
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

function filtrarReporteAtencion($username){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuario.nombre AS usuario FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE estado = '2' and usuario_responde = '$username'
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

function filtrarReporteFinalizado($username){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuario.nombre AS usuario FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE estado = '3' and usuario_responde = '$username'
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

function verReporteReponder($folio){
    global $mysqli;
    $select_query = "SELECT folio, usuario.nombre AS nombre, usuario.apellidoPaterno AS paterno, usuario.apellidoMaterno AS materno, fecha_reporte AS fecha, descripcion, tipo_reporte.nombre AS tipo, Departamento.nombre AS departamento, planta FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN estado ON reporte.estado = estado.idEstado
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Departamento ON Usuario.departamento = Departamento.idDepartamento
    WHERE folio = $folio and estado='2' Limit 1";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'nombre' => $row['nombre'],
                'paterno' => $row['paterno'],
                'materno' => $row['materno'],
                'fecha' => $row['fecha'],
                'descripcion' => $row['descripcion'],
                'tipo' => $row['tipo'],
                'departamento' => $row['departamento'],
                'planta' => $row['planta'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

function responderReporte($folio,$respuesta){
    global $mysqli;
    $query = "UPDATE Reporte SET fecha_respuesta = now(), estado='3', respuesta='$respuesta' 
    WHERE folio='$folio' and estado='2' LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($query);
    // Si se modifico con exito
    if ($result) {
        echo "Reporte con folio ".$folio." respondido";
        // Si no se modifico con exito
    } else {
        echo "No se pudo modificar el registro";
    }
}

function verRepuestaReporte($folio){
    global $mysqli;
    $select_query = "SELECT folio, usuario.nombre AS nombre, usuario.apellidoPaterno AS paterno, usuario.apellidoMaterno AS materno, fecha_reporte AS fecha, descripcion, tipo_reporte.nombre AS tipo, Departamento.nombre AS departamento, planta, respuesta FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN estado ON reporte.estado = estado.idEstado
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Departamento ON Usuario.departamento = Departamento.idDepartamento
    WHERE folio = $folio and estado='3' Limit 1";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "";
    }else{

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'nombre' => $row['nombre'],
                'paterno' => $row['paterno'],
                'materno' => $row['materno'],
                'fecha' => $row['fecha'],
                'descripcion' => $row['descripcion'],
                'tipo' => $row['tipo'],
                'departamento' => $row['departamento'],
                'planta' => $row['planta'],
                'respuesta' => $row['respuesta'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

?>