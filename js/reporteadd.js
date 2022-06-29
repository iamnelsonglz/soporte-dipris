$(document).ready(function () {
obtenerTipo();

// Rellenar select
function obtenerTipo() {
    $.ajax({
        url: '../bdd/scriptaddsolicitud.php?tipo',
        type: 'GET',
        success: function (response) {
            const personas = JSON.parse(response);
            let template = '<option value="0">Seleccione una opción</option>';
            personas.forEach(persona => {
                template += `
                    <option value="${persona.id}">${persona.nombre}</option>
                `
                $('#tipo').html(template);
            })
        }
    });
}

// Registrar 
$(document).on('click', '#btn-add', function (e) {
    e.preventDefault();
    let tipo = $('#tipo').val();
    let describe = $('#describe').val();
    if ((tipo.val <= 0) || (describe.trim()).length <= 0) {
        snackno();
    } else {
        const postData = {
            tipo: $('#tipo').val(),
            describe: $('#describe').val(),
        };
        $.post('../bdd/scriptaddsolicitud.php', postData, function (response) {
            alert(response);
            window.location.href = "../inicio.php";
        });
    }
})

// Redimensionar el text area
const textarea = document.querySelector("textarea");
textarea.addEventListener("keyup", e => {
    textarea.style.height = "5rem";
    let scHeight = e.target.scrollHeight;
    textarea.style.height = `${scHeight}px`
})

// Contador de caracteres
counter = document.querySelector(".counter"),
maxLength = textarea.getAttribute("maxlength");
textarea.onkeyup = () => {
    counter.innerText = maxLength - textarea.value.length;
}

});