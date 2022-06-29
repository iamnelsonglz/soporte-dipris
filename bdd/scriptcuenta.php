<?php
// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

session_start();

// Opción para mostrar todos los usuarios
if (isset($_GET['select'])) {
    $username = $_SESSION['username'];
    verCuenta($username);
}

// Condición para modificar usuario
else if (isset($_POST['nombre_mod'])) {
    $username = $_SESSION['username'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre_mod'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    mod($username, $password, $nombre, $paterno, $materno);
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
        $search_query = "SELECT Usuario.username,Usuario.password,Usuario.nombre,Usuario.apellidoPaterno,Usuario.apellidoMaterno FROM Usuario 
        WHERE Usuario.username='$username';";
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
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// Función para modificar usuario
function mod($username, $password, $nombre, $paterno, $materno)
{
    global $mysqli;
    // Se crea la consulta para modificar departamento
    $sql_mod = "UPDATE Usuario SET password='$password', nombre='$nombre', apellidoPaterno='$paterno', apellidoMaterno='$materno' WHERE username='$username' LIMIT 1";
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