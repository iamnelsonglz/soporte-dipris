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
        <link href="../css/style.css" rel="stylesheet" />
        <link href="../css/styleTable.css" rel="stylesheet" />
        <link href="../css/stylethings.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/mlateral.css">
        <script src="https://kit.fontawesome.com/25f7695136.js" crossorigin="anonymous"></script>
        <!-- Script's para Jquery y Ajax -->
        <script src="../js/jquery.min.js"></script>
        <title>Inicio</title>
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
                    <a id="op_home" class="selected">
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
                    <a id="op_home" class="selected">
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
                    <a id="op_home" class="selected">
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
            <?php
            // Si el usuario es administrador 
            if ($_SESSION['tipo'] == '1') {
            ?>
                
                <!-- Tabla con reportes registrados -->
                <div class="content">
                <div>
                <fieldset>
                    <legend class="txt"> <i class="fa-solid fa-circle-check"></i> Solicitudes finalizadas hoy</legend>
                    <div id="totalfinal"></div>
                    
                   
                    <ul class="scoreboard-fin txt in">
                        <li>0 solicitudes finalizadas</li>
                    </ul>
                
                </fieldset>
                <fieldset>
                    <legend class="txt"> <i class="fa-solid fa-clock"></i> Solicitudes pendientes</legend>
                    <div id="totalespera"><label class="txt"> <i class="fa-solid fa-clipboard-list"></i> Total: 0</label></div>
                
                </fieldset>    
                </div>
                <br>
                    <fieldset>
                        <legend class="txt">Filtar solicitudes por estado</legend>
                            <select name="where" class="in" id="where"></select>
                            <button type="submit" class="btn" id="estado-filter"><i class="fa-solid fa-filter"></i> Filtrar</button>
                    </fieldset>
                    <fieldset>
                        <legend class="txt">Filtrar solicitudes por fecha</legend>
                            <form action="/reportes/" method="POST" id="formulario">
                            <label for="fechainicio" class="txt">Fecha inicio</label>
                            <input type="date" class="in" name="fechainicio" id="fechainicio"/>
                            <label for="fechafin" class="txt">Fecha fin</label>
                            <input type="date" class="in" name="fechafin"  id="fechafin"/>
                            <button type="button" class="btn" id="filter-button"><i class="fa-solid fa-filter"></i> Filtrar</button>
                            <button type="submit" class="btn" id="filter-pdf-button"><i class="fa-solid fa-file-pdf"></i> Generar documento</button>
                            </form>
                    </fieldset>
                    
                    <p><br></p>   
                    <div id="loadtabla" class="loading">
                        <svg viewBox="25 25 50 50">
                        <circle r="20" cy="50" cx="50"></circle>
                        </svg>
                    </div> 
                    <table id="tabla-admin">          
                        <!-- Encabezado de tabla -->
                        <thead>
                            <tr id="header">
                                <th>FECHA</th>
                                <th>REPORTE</th>
                                <th>REPORTA</th>
                                <th>RESPONDE</th>
                                <th>ACCIÓN</th>
                            </tr>
                        </thead>
                        <!-- Contenido de la tabla  -->
                        <tbody id="table-admin">
                        </tbody>
                    </table>
                    <script src="../js/reporteadmin.js"></script>
                </div>

            <?php
                // Si el usuario es de informatica
            } else if ($_SESSION['tipo'] == 2) {
            ?>
                <!-- Tabla con reportes registrados -->
                
                <div class="content">
                
                    <table>  
                        <!-- Encabezado de tabla -->
                        <thead>
                            <tr id="header">
                                <th>FECHA</th>
                                <th>REPORTE</th>
                                <th>REPORTA</th>
                                <th>ACCIÓN</th>
                            </tr>
                        </thead>
                        <!-- Contenido de la tabla  -->
                        <tbody id="table-support">
                            <tr>
                                <td>Sin Resultados.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            <tr/>
                        </tbody>
                    </table>
                    <script src="../js/reportesoporte.js"></script>
                </div>
            <?php
                // Si el usuario es cualquier otro
            } else if ($_SESSION['tipo'] == 3) {
            ?>
            <div class="content">
            <button type="submit" class="btn" id="add-button"><i class="fa-solid fa-plus"></i> Agregar reporte</button>
            <br>
            <br>
                <div id="card" class="card">
                    <h2 class="titulo_reporte">No hay reportes pendientes en este momento</h2>
                    <h2 class="titulo_reporte">No hay reportes anteriores</h2>
                </div>
                
                <script src="../js/reporteusuario.js"></script>
            </div>
            <?php
            }
            ?>

        </main>
        <script src="../js/mlateral.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
    die();
}
?>