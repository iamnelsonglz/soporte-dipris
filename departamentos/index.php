<?php
// Session
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == '1') {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Icono en pestaña -->
            <link rel="icon" type="image/x-icon" href="../imagenes/favicon.ico" />
            <!-- Fuentes -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,300&display=swap" rel="stylesheet">
            <!-- Estilos -->
            <link href="../css/stylemodal.css" rel="stylesheet" />
            <link href="../css/style.css" rel="stylesheet" />
            <link href="../css/stylethings.css" rel="stylesheet" />
            <link href="../css/styletable.css" rel="stylesheet" />
            <link rel="stylesheet" href="../css/mlateral.css">
            <script src="https://kit.fontawesome.com/25f7695136.js" crossorigin="anonymous"></script>
            <!-- Script's para Jquery y Ajax -->
            <script src="../js/jquery.min.js"></script>
            <script src="../js/Departamento.js"></script>
            <title>Departamentos</title>
        </head>

        <body id="body">
            <!--barra del icono del menu-->
            <header>
                <div class="icon_menu" title="Menu">
                    <i class="fa-solid fa-align-justify" id="btn_open"></i>
                </div>
                <p class="hola">Departamentos</p>
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

                    <!--2.-Opcion de Departamentos-->
                    <a id="op_depto" class="selected">
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

                    <!--Opcion de Salir-->
                    <a id="op_salir">
                        <div class="option">
                            <i class="fa-solid fa-arrow-right-from-bracket" title="Salir"></i>
                            <h4>Salir</h4>
                        </div>
                    </a>

                </div>
                <!--Fin del opciones del menu-->

            </div>
            <!--Barra lateral(Vertical) Fin cambiar-->

            <!--Aca puedes poner el contenido de la pagina-->
            <main>
                <!-- Tabla con personas registradas -->
                <div class="content">
                    <!-- Se agrupa todo el formulario -->
                    <div class="wrapper">
                        <div class="form">
                            <button class="btn add" id="add-button"><i class="fa-solid fa-plus"></i> Agregar Departamento</button>
                            <p><br></p>   
                            <div id="loadtabla" class="loading">
                                <svg viewBox="25 25 50 50">
                                <circle r="20" cy="50" cx="50"></circle>
                                </svg>
                            </div> 
                            <table>
                                
                                
                                <!-- Encabezado de tabla -->
                                <thead>
                                    <tr id="header">
                                        <th>NOMBRE</th>
                                        <th>PLANTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody id="table">
                                    <tr>
                                        <td>Sin resultados</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Formulario -->
                    <div class="modal" id="modalDepto">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="btn-modal close"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
                                <h2 class="modal-title"><b>Departamento</b></h2>
                            </div>
                            <div class="modal-body fragment-modal" id="modal-body">
                                
                            </div>
                            <div class="modal-footer fragment-modal" id="modal-footer">
                                
                            </div>
                        </div>
                    </div>
            </main>
            <script src="../js/mlateral.js"></script>
        </body>

        </html>
<?php
    }
} else {
    header("Location: ../index.php");
    die();
}
?>