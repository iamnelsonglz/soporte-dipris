<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['tipo'])) {
    header("Location: inicio.php");
    die();
} else {
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Solicitud Informática</title>
        <link rel="icon" type="image/x-icon" href="imagenes/favicon.ico"/>
        <link rel="stylesheet" href="/css/styleLogin.css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/Login.js"></script>
    </head>

    <body>
        <main>
            <!--Contiene todo los formularios y la caja trasera-->
            <div class="contenedor__todo">
                <div class="caja_trasera">

                    <div class="caja_trasera_login">
                        <h3 id="btn_iniciar_sesion">Bienvenido</h3>
                        <img src="../imagenes/salud.png">
                    </div>

                    <div class="caja_trasera_registrer">
                        <h3 class="title">Bienvenido</h3>
                        
                        <button id="btn__register">Iniciar sesión</button>
                    </div>

                </div>

                <div class="contenedor__login-registrer">
                    <!--Formulario del login-->
                    <form action="" class="formulario_login" id="form-login">
                        <h2>Solicitud Informática</h2>
                    </form>
                    <!--Formulario del login-->
                    <form class="formulario_registre">
                        <h2>Inicio de sesión</h2>
                        <input type="text" placeholder="Nombre de usuario" name="username" id="username">
                        <input type="password" placeholder="Contraseña" name="password" id="password">
                        <button type="submit" value="Iniciar sesión" class="log" name="action">Iniciar sesión</button>
                    </form>
                </div>
            </div>
        </main>
        <script src="/js/script.js"></script>
    </body>

    </html>
<?php
}
?>