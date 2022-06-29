<?php
// Session
session_start();

// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';


if (isset($_GET['tipo'])) {
    verTipo();
}

else if (isset($_POST['describe'])) {
    $tipo = $_POST['tipo'];
    $describe = $_POST['describe'];
    $persona = $_SESSION['username'];
    add($tipo,$describe,$persona);
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

// Registrar solicitud
function add($tipo, $describe ,$persona){
    global $mysqli;
    // Se crea la consulta para agregar departamento
    $add_query = "INSERT INTO Reporte (fecha_reporte,descripcion,tipo,usuario_reporta)
     VALUES (now(),'$describe','$tipo','$persona')";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($add_query);
    // Si el registro fue exitoso
    if ($result) {
        echo "Solicitud registrada";
    // Si el registro no fue exitoso
    } else {
        echo "No se pudo registar la solicitud, por favor reintente";
    }
}

?>