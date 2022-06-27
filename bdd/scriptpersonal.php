<?php
// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

// Opción para mostrar todos los usuarios
if (isset($_GET['select'])) {
    verRegistro();
}

// Opción para mostrar los departamentos a seleccionar
else if (isset($_GET['depto'])) {
    verDepto();
}

// Opción para mostrar los tipos de usuario a seleccionar
else if (isset($_GET['tipo'])) {
    verTipo();
}

// Opción para mostrar si un usuario ya existe
else if (isset($_POST['search'])) {
    $search = $_POST['search'];
    buscarRegistro($search);
}

// Condición para agregar usuarios
else if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $departamento = $_POST['departamento'];
    $tipo = $_POST['tipo'];
    add($username, $password,$nombre,$paterno,$materno,$departamento,$tipo);
}

// Condición para mostrar el usuario a modificar
else if (isset($_POST['id'])) {
    $id = $_POST['id'];
    verRegistroMod($id);
}

// Condición para modificar usuario
else if (isset($_POST['username_mod'])) {
    $username = $_POST['username_mod'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $departamento = $_POST['departamento'];
    $tipo = $_POST['tipo'];
    mod($username, $password, $nombre, $paterno, $materno, $departamento, $tipo);
}

// Condición para eliminar usuario
else if (isset($_POST['id_del'])) {
    $id_del = $_POST['id_del'];
    del($id_del);
}else{
    header("Location: ../inicio.php");
    die();
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
    echo $jsonstring;
}

// Función para buscar si existe un usuario
function buscarRegistro($search)
{
    global $mysqli;
    if (!empty($search)) {
        $search_query = "SELECT username FROM Usuario WHERE username='$search' LIMIT 1";
        $result = $mysqli->query($search_query);
        if (!$result) {
            die('Error de consulta ');
        }

        $json = array();
        while ($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'username' => $row['username'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}

// Funcion para mostrar los usuarios
function verRegistro()
{
    global $mysqli;
    $select_query = "SELECT * FROM Usuario WHERE not username = 'root' ORDER BY nombre";
    $result = $mysqli->query($select_query);
    if (!$result) {
        die('Error de consulta');
    }

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'username' => $row['username'],
            'nombre' => $row['nombre'],
            'paterno' => $row['apellidoPaterno'],
            'materno' => $row['apellidoMaterno']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

// Función para guardar los usuarios 
function add($username, $password,$nombre,$paterno,$materno,$departamento,$tipo)
{
    global $mysqli;
    // Se crea la consulta para agregar departamento
    $add_query = "INSERT INTO Usuario (username,password,nombre,apellidoPaterno,apellidoMaterno,departamento,categoria)
     VALUES ('$username','$password','$nombre','$paterno','$materno','$departamento','$tipo')";
    // Se llama la variable de conexión y se ejecuta el query
    $result = $mysqli->query($add_query);
    // Si el registro fue exitoso
    if ($result) {
        echo "Usuario registrado";
    // Si el registro no fue exitoso
    } else {
        echo "No se pudo registar al usuario";
    }
}

// Función para ver el usuario a modificar
function verRegistroMod($id)
{
    global $mysqli;
    if (!empty($id)) {
        $search_query = "SELECT Usuario.username,Usuario.password,Usuario.nombre,Usuario.apellidoPaterno,Usuario.apellidoMaterno,departamento.idDepartamento,departamento.nombre AS departamento_nombre,Categoria.idCategoria AS tipo_id,Categoria.nombre AS tipo_nombre FROM Usuario INNER JOIN departamento on usuario.departamento = departamento.idDepartamento INNER JOIN Categoria on Usuario.categoria = Categoria.idCategoria WHERE Usuario.username='$id';";
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

// Función para eliminar usuario
function del($id_del)
{
    global $mysqli;
    // Se crea la consulta para eliminar el departamento
    $sql_del = "DELETE FROM Usuario WHERE username = '$id_del' LIMIT 1";
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