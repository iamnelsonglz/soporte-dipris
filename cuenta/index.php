<?php
// Session
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['tipo'])) {
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
    <link href="../css/style-informacion.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/mlateral.css">
    <script src="https://kit.fontawesome.com/25f7695136.js" crossorigin="anonymous"></script>
    <!-- Script's para Jquery y Ajax -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/Cuenta.js"></script>
    <title>Cuenta</title>
</head>

<body id="body">
        <!--barra del icono del menu-->
        <header>
            <div class="icon_menu" title="Menu">
                <i class="fa-solid fa-align-justify" id="btn_open"></i>
            </div>
            <p class="hola">Inicio</p>
        </header>
        <!--Fin de la barra del icono del menu-->

        <!--Barra lateral(Vertical) Inicio-->
        <div class="menu__side" id="menu_side">
            <!--Inicio del menu lateral(Vertical)-->
            <!--Donde ira el icono usuario-->
            <div class="name__page" id="op_cuenta">
            <i username="<?php echo ($_SESSION['username']) ?>" class="fa-solid fa-circle-user" title="Información de usuario"></i>
                <div id="u_result">
                    <h4><?php echo ($_SESSION['username']) ?></h4>
                </div>
            </div>
            <!--fin icono del usuario-->

            <?php
            /* ************ Si el usuario es de tipo Administrador **************** */
            if ($_SESSION['tipo'] == '1') { 
            ?>
            
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

                    <!--2.-Opcion de Departamentos-->
                    <a id="op_depto">
                        <div class="option">
                            <i class="fa-solid fa-building" title="Departamentos"></i>
                            <h4 class="h4">Departamentos</h4>
                        </div>
                    </a>
                    <!--3.-Opcion de Personal-->
                    <a id="op_person">
                        <div class="option">
                            <i class="fa-solid fa-users" title="Personal"></i>
                            <h4 class="h4">Personal</h4>
                        </div>
                    </a>

                    <!--4.-Opcion de Tipo de problema -->
                    <a id="op_tipo_problem">
                        <div class="option">
                            <i class="fa-solid fa-wrench" title="Tipo de reporte"></i>
                            <h4 class="h4">Tipo de reporte</h4>
                        </div>
                    </a>

                    <!--5.-Opcion de Salir-->
                    <a id="op_salir">
                        <div class="option">
                            <i class="fa-solid fa-arrow-right-from-bracket" title="Salir"></i>
                            <h4>Salir</h4>
                        </div>
                    </a>
                </div>
                <!--Fin del opciones del menu-->

            <?php
            /* *********** Si el usuario es de tipo Soporte ********** */
            } else if ($_SESSION['tipo'] == '2') {
            ?>
                <!--Inicio Menu opciones-->
                <div class="options__menu">
                    <!--1.-Opcion de Inicio-->
                    <a id="op_home" >
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

            <?php
            /* ***************  Si el usuario es de tipo General *************** */
            } else if ($_SESSION['tipo'] == '3') {
            ?>
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
            <?php
            }else{
                session_destroy();
                header("Location: ../index.php");
                die();
            }
            ?>
        </div>
        <!--Barra lateral(Vertical) Fin cambiar-->
        <main class="main">
            <div class="card">
                <div class="tools">
                    <div class="circle">
                        <span class="red box"></span>
                    </div>
                    <div class="circle">
                        <span class="yellow box"></span>
                    </div>
                    <div class="circle">
                        <span class="green box"></span>
                    </div>
                </div>
                <div class="card__content">
                    <div class="body"></div>
                    <div class="footer"></div>  
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