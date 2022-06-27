$(document).ready(function () {
    saludar();

    function saludar(){
        var tiempo = new Date();
        var hora, cad;
        with (tiempo){
        hora = getHours();
        cad += hora + ":" + getMinutes()+":"+getSeconds();
        }
        if (hora >= 5 && hora < 12){
            cad = "Buenos días";
        }else if (hora >= 12 && hora < 19){
            cad = "Buenas tardes";
        }else{
            cad = "Buenas noches";
        } 
        
        $(".caja_trasera_registrer .title").html(cad);
    // Iniciar sesión
    }

    $(document).on('click', '.log', function (e) {
        e.preventDefault();
        let username = $('#username').val();
        let password = $('#password').val();
        let type = '';
        if ((username.trim()).length <= 0 || (password.trim()).length <= 0) {
            alert('Uno o varios campos estan vacios');
        } else {
            const postData = {
                username: $('#username').val(),
                password: $('#password').val()
            };
            $.post('../bdd/scriptlogin.php', postData, function (response) {
                if (response === "") {
                    alert("Usuario o contraseña incorrectos");
                } else {
                    window.location.href = "/inicio.php";
                    /*
                    let personal = JSON.parse(response);
                    personal.forEach(persona => {
                        type = persona.tipo;
                    });
                    // Abre la página según el tipo de usuario
                    switch (type) {
                        case "1":
                            window.location.href = "/Inicio.php";
                            break;
                        case "2":
                            window.location.href = "/Inicio.php";
                            break;
                        case "3":
                            window.location.href = "/Inicio.php";
                            break;
                        default:
                            alert("Error en datos de usuario");
                            break;
                    }
                    */
                    $('.formulario_registre').trigger('reset');
                }

            });
        }
        //window.location.href = "../Departamentos/Index.php"; 
    })
});
