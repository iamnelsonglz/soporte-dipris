<?php

// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

// Condición para mostrar todos los registros
if (isset($_GET['select'])) {
    verRegistro();
}

// Condición para mostrar si un registro ya existe
else if (isset($_POST['search'])) {
    $search = $_POST['search'];
    buscarRegistro($search);
}

// Condición para agregar registro a la base de datos
else if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $prioridad = $_POST['prioridad'];
    add($nombre, $prioridad);
}

// Condición para mostrar el registro a modificar
else if (isset($_POST['id'])) {
    $id = $_POST['id'];
    verRegistroMod($id);
}

// Condición para modificar registro a la base de datos
else if (isset($_POST['id_mod'])) {
    $id = $_POST['id_mod'];
    $nombre = $_POST['nombre_mod'];
    $prioridad = $_POST['prioridad'];
    mod($id, $nombre, $prioridad);
}

// Condición para eliminar registro a la base de datos
else if (isset($_POST['id_del'])) {
    $id_del = $_POST['id_del'];
    del($id_del);
}

// Funcion para buscar si existe un registro
function buscarRegistro($search)
{
    global $mysqli;
    if (!empty($search)) {
        $search_query = "SELECT nombre FROM Tipo_personal WHERE nombre='$search' LIMIT 1";
        $result = $mysqli->query($search_query);
        if (!$result) {
            die('Error de consulta ');
        }

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'nombre' => $row['nombre'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// Funcion para mostrar los registros
function verRegistro()
{
    global $mysqli;
    $select_query = "SELECT * FROM Tipo_personal ORDER BY nombre ASC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        die('Error de consulta');
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'prioridad' => $row['prioridad']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Funcion para registrar 
function add($nombre, $prioridad)
{
    global $mysqli;
    // Se crea la consulta para agregar departamento
    $add_query = "INSERT INTO Tipo_personal (nombre,prioridad)
     VALUES ('$nombre','$prioridad')";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($add_query);
    // Si el registro fue exitoso
    if ($result) {
        echo "Registro guardado";
    // Si el registro no fue exitoso
    } else {
        echo "No se pudo guardar el registro";
    }
}

function verRegistroMod($id)
{
    global $mysqli;
    if (!empty($id)) {
        $search_query = "SELECT * FROM Tipo_personal WHERE id='$id' LIMIT 1;";
        $result = $mysqli->query($search_query);
        if (!$result) {
            die('Error de consulta ');
        }

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'prioridad' => $row['prioridad']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

/* Funcion para modificar los campos del registro */
function mod($id, $nombre, $prioridad)
{
    global $mysqli;
    // Se crea la consulta para modificar departamento
    $sql_mod = "UPDATE Tipo_personal SET nombre='$nombre', prioridad='$prioridad' WHERE id='$id' LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($sql_mod);
    // Si se modifico con exito
    if ($result) {
        echo "Registro modificado";
        // Si no se modifico con exito
    } else {
        echo "No se pudo modificar el registro";
    }
}

/* Funcion para eliminar los campos del registro */
function del($id_del)
{
    global $mysqli;
    // Se crea la consulta para eliminar el departamento
    $sql_del = "DELETE FROM Tipo_personal WHERE id = '$id_del' LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($sql_del);
    // Si se elimino con exito
    if ($result) {
        echo "Registro eliminado";
    } else {
        // Si no se elimino con exito
        echo "No se pudo eliminar el registro";
    }
}
?>