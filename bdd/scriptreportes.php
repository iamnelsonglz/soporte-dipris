<?php
// Session
session_start();

// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

/* ****************************** Script Administrador de reportes ****************************** */

if (isset($_GET['finish'])){
    todayfinish();
}

else if (isset($_GET['wait'])){
    todaywait();
}

else if (isset($_GET['tipo'])) {
    verTipo();
}

// Condición para registrar el reporte
else if (isset($_POST['describe'])) {
    $tipo = $_POST['tipo'];
    $describe = $_POST['describe'];
    $persona = $_SESSION['username'];
    add($tipo,$describe,$persona);
}

/* ****************************** Ver Reportes | Administrador ****************************** */

// Condición para mostrar todos los estados en el select
else if (isset($_GET['where'])) {
    verEstados();
    
}

// Condición para mostrar todos los estados en el select
else if (isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'];
    filtro($filtro);
}

// Condición para mostrar los usuarios de soporte para asignación
else if(isset($_GET['verasignacion'])){
    verAsignacion();
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

// Condición para mostrar los usuarios de categoria soporte
else if (isset($_GET['soporte'])){
    usuariosSoporte();
}

// Condición para asignar una tarea a un usuario de soporte
else if(isset($_POST['folio_reporte'])){
    $folio = $_POST['folio_reporte'];
    $usuario = $_POST['add_soporte'];
    asignar($folio,$usuario);
}



/* ****************************** Ver Historial de reportes personal ****************************** */

// Muestra el historial de reportes del usuario
else if (isset($_GET['historial'])){
    $username = $_SESSION['username'];
    verHistorial($username);
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

// Condición cuando no se cumple ninguna otra
else{
    header("Location: ../inicio.php");
    die();
}

/* ------------------------------------------------------------------------------------------------- */

// Ver la cantidad de reportes finalizados del día
function todayfinish(){
    global $mysqli;
    $select_query = "SELECT folio, usuario.nombre AS nombre, COUNT(folio) AS total FROM reporte
    INNER JOIN usuario ON reporte.usuario_responde = usuario.username
    WHERE reporte.estado = '2' AND fecha_respuesta >= CURDATE()
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

/* ****************************** Nuevo Reporte ****************************** */

// Ver tipos de reporte
function verTipo(){
    global $mysqli;
    $select_query = "SELECT idTipo, nombre FROM Tipo_reporte ORDER BY nombre ASC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "No se encontro resultados para los tipos de reportes";
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id' => $row['idTipo'],
            'nombre' => $row['nombre']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Registrar reporte
function add($tipo, $describe ,$persona){
    global $mysqli;
    // Se crea la consulta para agregar departamento
    $add_query = "INSERT INTO Reporte (fecha_reporte,descripcion,tipo,usuario_reporta)
     VALUES (now(),'$describe','$tipo','$persona')";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($add_query);
    // Si el registro fue exitoso
    if ($result) {
        echo "Reporte registrado";
    // Si el registro no fue exitoso
    } else {
        echo "No se pudo registar el reporte, por favor reintente";
    }
}

/* ****************************** Ver Reportes | Administrador ****************************** */

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

function filtro(){
    
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, usuario_reporta AS usuario FROM reporte
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
    WHERE estado = '3'
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
    WHERE estado = '4'
    ORDER BY Tipo_reporte.prioridad ASC, fecha_reporte DESC";
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

/* ****************************** Ver Historial de reportes personal ****************************** */

// Ver historial de reportes de usuario
function verHistorial($username){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte, tipo_problema.nombre AS tipo_problema, personal.username AS personal, descripcion, fecha_respuesta, respuesta, estado.nombre AS estado
    FROM Reporte 
    INNER JOIN Tipo_problema ON Reporte.tipo_problema = Tipo_problema.id
    INNER JOIN personal ON reporte.Personal_responde = personal.username
    INNER JOIN Estado ON Reporte.estado = Estado.idEstado
    WHERE personal_reporta = '$username'
    ORDER BY fecha_reporte";
    $result = $mysqli->query($select_query);
    if (!$result) {
        echo "El historial esta vacio";
    }else{
        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'folio' => $row['folio'],
                'fecha_reporte' => $row['fecha_reporte'],
                'tipo_problema' => $row['tipo_problema'],
                'descripcion' => $row['descripcion'],
                'personal' => $row['personal'],
                'fecha_respuesta' => $row['fecha_respuesta'],
                'respuesta' => $row['respuesta'],
                'estado' => $row['estado']
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
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuario.nombre AS usuario FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE estado = '2' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin 23:59:59')
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

function filtrarReportesFinalizado($fechainicio,$fechafin){
    global $mysqli;
    $select_query = "SELECT folio, fecha_reporte AS fecha, tipo_reporte.nombre AS tipo, Usuario.nombre AS usuario FROM reporte
    INNER JOIN Tipo_reporte ON reporte.tipo = tipo_reporte.idTipo
    INNER JOIN usuario ON Reporte.usuario_reporta = Usuario.username
    INNER JOIN Categoria ON Usuario.categoria = Categoria.idCategoria
    WHERE estado = '3' AND (fecha_reporte BETWEEN '$fechainicio' AND '$fechafin 23:59:59')
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
?>