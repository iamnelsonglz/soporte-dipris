//ejecutar funcion en el evento click
//Ejecutar función en el evento click
document.getElementById("btn_open").addEventListener("click", open_close_menu);

//Declaramos variables
var side_menu = document.getElementById("menu_side");
var btn_open = document.getElementById("btn_open");
var body = document.getElementById("body");

//Evento para mostrar y ocultar menú
    function open_close_menu(){
        body.classList.toggle("body_move");
        side_menu.classList.toggle("menu__side_move");
    }

    //Si el ancho de la página es menor a 760px, ocultará el menú al recargar la página

if (window.innerWidth < 760){

    body.classList.add("body_move");
    side_menu.classList.add("menu__side_move");
}

//Haciendo el menú responsive(adaptable)

window.addEventListener("resize", function(){

    if (window.innerWidth > 760){

        body.classList.remove("body_move");
        side_menu.classList.remove("menu__side_move");
    }

    if (window.innerWidth < 760){

        body.classList.add("body_move");
        side_menu.classList.add("menu__side_move");
    }

});

/* OPCIONES DEL MENU */
$(document).on('click', '#op_home', function (e) {
    window.location.href = "../inicio.php";
})

$(document).on('click', '#op_depto', function (e) {
    window.location.href = "../departamentos/";
})
/*
$(document).on('click', '#op_tipo_person', function (e) {
    window.location.href = "../personal/tipo.php";
})
*/
$(document).on('click', '#op_person', function (e) {
    window.location.href = "../personal/";
})

$(document).on('click', '#op_tipo_problem', function (e) {
    window.location.href = "../reportes/tipo.php";
})

$(document).on('click', '#op_cuenta', function (e) {
    window.location.href = "../cuenta/";
})

$(document).on('click', '#op_salir', function (e) {
    if (confirm('¿Seguro que desea cerrar sesión?')) {
    $.ajax({
        url: '../bdd/scriptlogin.php?logout',
        type: 'GET',
        success: function (response) {
            window.location.href = "../index.php/";
        }
    });
}
})