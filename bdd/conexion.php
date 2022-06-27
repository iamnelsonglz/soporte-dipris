<?php
    // Se declaran las variables con los datos de la base de datos
    $dbserver = "localhost";
    $dbuser = "root";
    $dbpassword = "";
    $dbname = "bdreportes";

    // Se crea una variable para conexión a mysql
    $mysqli = new mysqli($dbserver,$dbuser,$dbpassword,$dbname);

    // Se verifica si se realizo la conexión 
    if($mysqli->connect_error){
        die('Error en la conexión de la base de datos' . $mysqli->connect_error);
    }    
?>