<?php
// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

session_start();

// Opción para mostrar todos los usuarios
if (isset($_GET['select'])) {
    $username = $_SESSION['username'];
    verCuenta($username);
}

// Opción para mostrar los departamentos a seleccionar
else if (isset($_GET['depto'])) {
    verDepto();
}

// Opción para mostrar los tipos de usuario a seleccionar
else if (isset($_GET['tipo'])) {
    verTipo();
}

// Condición para modificar usuario
else if (isset($_POST['nombre_mod'])) {
    $username = $_SESSION['username'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre_mod'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $departamento = $_POST['departamento'];
    $tipo = $_POST['tipo'];
    mod($username, $password, $nombre, $paterno, $materno, $departamento, $tipo);
}

else{
    header("Location: ../inicio.php");
    die();
}

// Función para ver el usuario a modificar
function verCuenta($username)
{
    global $mysqli;
    if (!empty($username)) {
        $search_query = "SELECT Usuario.username,Usuario.password,Usuario.nombre,Usuario.apellidoPaterno,Usuario.apellidoMaterno,departamento.idDepartamento,departamento.nombre AS departamento_nombre,Categoria.idCategoria AS tipo_id,Categoria.nombre AS tipo_nombre FROM Usuario INNER JOIN departamento on usuario.departamento = departamento.idDepartamento INNER JOIN Categoria on Usuario.categoria = Categoria.idCategoria WHERE Usuario.username='$username';";
        $result = $mysqli->query($search_query);
        if (!$result) {
            die('Error de consulta ');
        }

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'username' => $row['username'],
                'password' => $row['password'],
                'nombre' => $row['nombre'],
                'paterno' => $row['apellidoPaterno'],
                'materno' => $row['apellidoMaterno'],
                'iddepartamento' => $row['idDepartamento'],
                'departamento' => $row['departamento_nombre'],
                'idtipo' => $row['tipo_id'],
                'tipo' => $row['tipo_nombre']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// Función para rellenar la lista desplegable de departamentos
function verDepto(){
    global $mysqli;
    $select_query = "SELECT * FROM Departamento ORDER BY nombre ASC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        die('Error de consulta');
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'idDepartamento' => $row['idDepartamento'],
            'nombre' => $row['nombre']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Función para rellenar la lista desplegable de tipos de personal
function verTipo(){
    global $mysqli;
    $select_query = "SELECT * FROM Categoria ORDER BY nombre ASC";
    $result = $mysqli->query($select_query);
    if (!$result) {
        die('Error de consulta');
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'id' => $row['idCategoria'],
            'nombre' => $row['nombre']
        );
    }
    $jsonstring = json_encode($json);
    echo 
    $jsonstring;
}

// Función para modificar usuario
function mod($username, $password, $nombre, $paterno, $materno, $departamento, $tipo)
{
    global $mysqli;
    // Se crea la consulta para modificar departamento
    $sql_mod = "UPDATE Usuario SET password='$password', nombre='$nombre', apellidoPaterno='$paterno', apellidoMaterno='$materno', departamento='$departamento', categoria='$tipo' WHERE username='$username' LIMIT 1";
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

?>