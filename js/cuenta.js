$(document).ready(function () {
    obtenerUsuario();

    // Mostrar todos los registros
    function obtenerUsuario() {
        $.ajax({
            url: '../bdd/scriptcuenta.php?select',
            type: 'GET',
            success: function (response) {
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    template += `
                    <div>
                    <label class="txt" for="username">Nombre de usuario: </label>
                    <input type="text" class="in" name="username" readonly value="${persona.username}" id="username">
                    </div>
                    <br>
                    <div  class="pass">
                    <label class="txt" for="password">Contraseña: </label>
                    <input type="password" class="in" name="password" value="${persona.password}" id="password">
                    <span id="show">Mostrar</span>
                    </div>
                    <div>
                    <label class="txt" for="nombre">Nombre(s): </label>
                    <input type="text" class="in" name="nombre" value="${persona.nombre}" id="nombre">
                    </div>
                    <br>
                    <div>
                    <label class="txt" for="paterno">Apellido paterno: </label>
                    <input type="text" class="in" name="paterno" value="${persona.paterno}" id="paterno">
                    </div>
                    <br>
                    <div>
                    <label class="txt" for="materno">Apellido materno: </label>
                    <input type="text" class="in" name="materno" value="${persona.materno}" id="materno">
                    </div>
                    <br>
                    `;
                    $('.body').html(template);
                    $('.body').show();
                    
                    template = '';
                    template += `
                    <br>
                    <div>
                    <button type="submit" user="${persona.username}" id="btn-mod" class="btn btn-mod btn-modal"> <i class="fa-regular fa-floppy-disk"></i> Guardar modificación</button>
                    </div>
                    `;
                    $('.footer').html(template);
                    $('.footer').show();
                    
                })
            }
        });
    }

    // Enviar modificación al registro
    $(document).on('click', '#btn-mod', function (e) {
        e.preventDefault();
        let element = $(this)[0];
        let username_mod = $(element).attr('user');
        let password = $('#password').val();
        let nombre = $('#nombre').val();
        let paterno = $('#paterno').val();
        let materno = $('#materno').val();

        if ((username_mod.trim()).length <= 0 || (password.trim()).length <= 0 ||
            (nombre.trim()).length <= 0 || (paterno.trim()).length <= 0 || (materno.trim()).length <= 0) {
            alert('Uno o varios campos estan vacios');
        } else {
            if (confirm('¿Esta seguro de modificar los datos del usuario?')) {
                const postData = {
                    password: password,
                    nombre_mod: nombre,
                    paterno: paterno,
                    materno: materno
                };
                $.post('../bdd/scriptcuenta.php', postData, function (response) {
                    alert(response);
                });
            } else {
                
            }
            obtenerUsuario();
        }
    })

    $(document).on('click', '#show', function (e) {
        const passwordInput = document.querySelector('#password');
        if (e.target.classList.contains('show')) {
            e.target.classList.remove('show');
            e.target.textContent = 'Ocultar';
            passwordInput.type = 'text';
        } else {
            e.target.classList.add('show');
            e.target.textContent = 'Mostrar';
            passwordInput.type = 'password';
        }
    });
});