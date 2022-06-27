<?php
// Se inicia sesion 
session_start();

// Se indica que se va usar la conexión a la base de datos
require '../bdd/conexion.php';

// Opción para inicio de sesión
if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    login($user, $pass);

// Opción para cerrar sesión
} else if (isset($_GET['logout'])) {
    cerrarSesion();

// Opción para redirigir a inicio
} else {
    header("Location: ../inicio.php");
    die();
}

// Función para iniciar sesión
function login($user, $pass)
{
    global $mysqli;
    if (!empty($user) && !empty($pass)) {
        $search_query = "SELECT username,categoria.tipo AS tipo FROM Usuario 
        inner join categoria ON Usuario.categoria = categoria.idCategoria
        WHERE username='$user' AND password='$pass' LIMIT 1";
        $result = $mysqli->query($search_query);
        if (!$result) {
            echo "";
        } else {
            $json = array();
            while ($row = mysqli_fetch_array($result)) {
                $json[] = array(
                    'username' => $row['username'],
                    'tipo' => $row['tipo']
                );
                // Guardar valores
                if (!empty($row['username']) && !empty($row['tipo'])) {
                    $username = $row['username'];
                    $tipo = $row['tipo'];
                    // Si no existe la sesion, se guardan los valores en la sesión
                    $_SESSION['username'] = $username;
                    $_SESSION['tipo'] = $tipo;
                    $jsonstring = json_encode($json);    
                    echo $jsonstring;
                }else{
                    echo "";
                }
            }          
        }
    }
}

// Función para cerrar sesión
function cerrarSesion()
{
    // Se destruye la sesion
    session_destroy();
}
