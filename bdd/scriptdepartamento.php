<?php
// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

// Opción para mostrar todos los departamentos
if (isset($_GET['select'])) {
    verRegistro();
}

// Opción para mostrar si un departamento ya existe
else if (isset($_GET['buscarnombre'])) {
    $search = $_GET['buscarnombre'];
    buscarDepartamentoExistente($search);
}

// Opción para agregar nuevo departamento
else if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $planta = $_POST['planta'];
    add($nombre, $planta);
}

// Opción para mostrar el departamento a modificar
else if (isset($_POST['id'])) {
    $id = $_POST['id'];
    verRegistroMod($id);
}

// Opción para modificar departamento
else if (isset($_POST['id_mod'])) {
    $id = $_POST['id_mod'];
    $nombre = $_POST['nombre_mod'];
    $planta = $_POST['planta'];
    mod($id, $nombre, $planta);
}

// Opción para eliminar departamento
else if (isset($_POST['id_del'])) {
    $id_del = $_POST['id_del'];
    del($id_del);

// Opción para redirigir a inicio
}else{
    header("Location: ../inicio.php");
    die();
}

// Función para buscar si existe un departamento
function buscarDepartamentoExistente($search){
    global $mysqli;
    if (!empty($search)) {
        $search_query = "SELECT nombre FROM Departamento WHERE nombre='$search' LIMIT 1";
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

// Función para mostrar los departamentos
function verRegistro()
{
    global $mysqli;
    $select_query = "SELECT * FROM Departamento ORDER BY nombre ASC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        die('Error de consulta');
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id' => $row['idDepartamento'],
            'nombre' => $row['nombre'],
            'planta' => $row['planta']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Funcion para agregar departamento 
function add($nombre, $planta)
{
    global $mysqli;
    // Se crea la consulta para agregar departamento
    $add_query = "INSERT INTO Departamento (nombre,planta)
     VALUES ('$nombre','$planta')";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($add_query);
    // Si el registro fue exitoso
    if ($result) {
        echo "Departamento guardado";
    // Si el registro no fue exitoso
    } else {
        echo "No se pudo guardar el departamento";
    }
}

// Función para mostrar el departamento a modificar
function verRegistroMod($id)
{
    global $mysqli;
    if (!empty($id)) {
        $search_query = "SELECT * FROM Departamento WHERE idDepartamento='$id' LIMIT 1;";
        $result = $mysqli->query($search_query);
        if (!$result) {
            die('Error de consulta ');
        }

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'id' => $row['idDepartamento'],
                'nombre' => $row['nombre'],
                'planta' => $row['planta']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// Funcion para modificar el departamento
function mod($id, $nombre, $planta)
{
    global $mysqli;
    // Se crea la consulta para modificar departamento
    $sql_mod = "UPDATE Departamento SET nombre='$nombre', planta='$planta' WHERE idDepartamento='$id' LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($sql_mod);
    // Si se modifico con exito
    if ($result) {
        echo "Departamento modificado";
        // Si no se modifico con exito
    } else {
        echo "No se pudo modificar el departamento";
    }
}

// Funcion para eliminar el departamento
function del($id_del)
{
    global $mysqli;
    // Se crea la consulta para eliminar el departamento
    $sql_del = "DELETE FROM Departamento WHERE idDepartamento = '$id_del' LIMIT 1";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($sql_del);
    // Si se elimino con exito
    if ($result) {
        echo "Departamento eliminado";
    } else {
        // Si no se elimino con exito
        echo "No se pudo eliminar el departamento";
    }
}
?>