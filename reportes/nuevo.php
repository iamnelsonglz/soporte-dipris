<?php
// Session
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['tipo']) && $_SESSION['tipo'] == '3') {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icono en pestaña -->
    <link rel="icon" type="image/x-icon" href="../imagenes/favicon.ico" />
    <!-- Estilos -->
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/stylethings.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/mlateral.css">
    <script src="https://kit.fontawesome.com/25f7695136.js" crossorigin="anonymous"></script>
    <!-- Script's para Jquery y Ajax -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/reporteadd.js"></script>
    <title>Crear Reporte</title>
</head>

<body id="body">
    <!--barra del icono del menu-->
    <header>
        <div class="icon_menu" title="Menu">
            <i class="fa-solid fa-align-justify" id="btn_open"></i>
        </div>
        <p class="hola">Reporte</p>
    </header>
    <!--Fin de la barra del icono del menu-->

    <!--Barra lateral(Vertical) Inicio-->
    <div class="menu__side" id="menu_side">

<!--Inicio del menu lateral(Vertical)-->
<!--Donde ira el icono usuario-->
<div class="name__page">
        <i username="<?php echo ($_SESSION['username']) ?>" class="fa-solid fa-circle-user" title="Información de usuario"></i>
            <div id="u_result">
                <h4><?php echo ($_SESSION['username']) ?></h4>
            </div>
</div>
<!--fin icono del usuario-->
    <!--Inicio Menu opciones-->
    <div class="options__menu">
        <!--1.-Opcion de Inicio-->
        <a id="op_home">
            <!--Para las direcciones entre paginas-->
            <div class="option activo">
                <i class="fa-solid fa-house" title="Inicio"></i>
                <h4 class="h4">Inicio</h4>
            </div>
        </a>
        <!--2.-Opcion de Salir-->
        <a id="op_salir">
            <div class="option">
                <i class="fa-solid fa-arrow-right-from-bracket" title="Salir"></i>
                <h4>Salir</h4>
            </div>
        </a>

    </div>
    <!--Fin del opciones del menu-->

<!--Barra lateral(Vertical) Fin cambiar-->

    </div>
    <!--Barra lateral(Vertical) Fin cambiar-->

    <!--Aca puedes poner el contenido de la pagina-->
    <main>
        <!-- Formulario de registro de reportes -->
        <div class="content">
            <h1>Nuevo reporte</h1>
                <p>
                    
                    <h4>Tipo de problema</h4>
                    <select name="tipo" id="tipo" class="form-reporte-select in">
                        <option value="0">Seleccione</option>
                    </select>
                   
                </p>
                <p>
                    <h4>Descripción del problema</h4>
                    <textarea placeholder="Describa el problema" maxlength="250" class="describe form-reporte-txtarea" id="describe" required></textarea>
                    <span class="counter">250</span>
                </p>
                <br>
                <br>
                <p>
                    <button type="submit" class="btn" id="btn-add"> <i class="fa-solid fa-floppy-disk"></i> Guardar reporte</button>
                </p>

        </div>
    </main>
    <script src="../js/mlateral.js"></script>
</body>

</html>
<?php
}else{
    header("Location: ../index.php");
    die();
}
?>