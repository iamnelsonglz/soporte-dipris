<?php
// Session
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['tipo']) && $_SESSION['tipo'] == '2' && isset($_GET['folio'])) {
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
    <link href="../css/stylethings.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/styletable.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/mlateral.css">
    <script src="https://kit.fontawesome.com/25f7695136.js" crossorigin="anonymous"></script>
    <!-- Script's para Jquery y Ajax -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/reporterespuesta.js"></script>
    <title>Respuesta Reporte</title>
</head>

<body id="body">
    <!--barra del icono del menu-->
    <header>
        <div class="icon_menu" title="Menu">
            <i class="fa-solid fa-align-justify" id="btn_open"></i>
        </div>
        <p class="hola">Responder</p>
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
        <!--2.-Opcion de Personal-->
        <a id="op_person">
                        <div class="option">
                            <i class="fa-solid fa-users" title="Personal"></i>
                            <h4 class="h4">Personal</h4>
                        </div>
                    </a>
        <!--3.-Opcion de Salir-->
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
        <div class="content fragment">
                <div class="content-enviado" id="content-enviado">

                </div>
                <div class="content-respuesta">
                
                    <h4>Respuesta</h4>
                    <textarea placeholder="Escriba la respuesta" maxlength="250" class="form-reporte-txtarea" id="answer" readonly></textarea>
                </div>
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