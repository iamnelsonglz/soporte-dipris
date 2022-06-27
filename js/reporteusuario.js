$(document).ready(function () {
    verHistorial();

    function verHistorial(){
        let template = '';
        $.ajax({
            url: '../bdd/scriptusuario.php?historialespera',
            type: 'GET',
            success: function (response) {
                if (response === '[]') {
                    template += `
                    <h2 class="titulo_reporte">No hay reportes pendientes en este momento</h2>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    //template = '';
                    personas.forEach(persona => {
                        template += `
                        <div class="cabecera">
                            <h2 class="titulo_reporte">FECHA QUE SE REPORTO: ${persona.fecha}</h2>
                            <h2 class="estado_reporte ${persona.estado}">Estado: ${persona.estado}</h2>
                            <h2 class="titulo_reporte">FOLIO DEL REPORTE: ${persona.folio}</h2>
                        </div>
                        <div class="cuerpo">
                            <table>
                                <!-- Encabezado de tabla -->
                                <thead>
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody>
                                    <tr>
                                        <td>${persona.descripcion}</td>
                                        <td>${persona.respuesta}</td>
                                    <tr/>
                                    <tr>
                                        <td>FECHA DE ENVIO: ${persona.fecha}</td>
                                        <td>FECHA DE RESPUESTA: ${persona.fecha_respuesta}</td>
                                    </tr>
                                    <tr>
                                        <td>TIPO DE REPORTE: ${persona.tipo}</td>
                                        <td>USUARIO QUE RESPONDE: ${persona.usuario}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button id="btn-cancelar" class="btn estado_reporte" folio="${persona.folio}"> <i class="fa-solid fa-ban"></i> Cancelar Reporte</button>
                        </div>
                        `
                        $('#card').html(template);
                    })
                }
            } 
        });

        $.ajax({
            url: '../bdd/scriptusuario.php?historial',
            type: 'GET',
            success: function (response) {
                if (response === '[]') {
                    template += `<h2 class="titulo_reporte">No hay reportes anteriores</h2>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    //template = '';
                    personas.forEach(persona => {
                        template += `
                        <div class="cabecera">
                            <h2 class="titulo_reporte">FECHA QUE SE REPORTO: ${persona.fecha}</h2>
                            <h2 class="estado_reporte ${persona.estado}">Estado: ${persona.estado}</h2>
                            <h2 class="titulo_reporte">FOLIO DEL REPORTE: ${persona.folio}</h2>
                        </div>
                        <div class="cuerpo">
                            <table>
                                <!-- Encabezado de tabla -->
                                <thead>
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody>
                                    <tr>
                                        <td>${persona.descripcion}</td>
                                        <td>${persona.respuesta}</td>
                                    <tr/>
                                    <tr>
                                        <td><b>FECHA DE ENVIO:</b> ${persona.fecha}</td>
                                        <td><b>FECHA DE RESPUESTA:</b> ${persona.fecha_respuesta}</td>
                                    </tr>
                                    <tr>
                                        <td><b>TIPO DE REPORTE:</b> ${persona.tipo}</td>
                                        <td><b>USUARIO QUE RESPONDE:</b> ${persona.usuario}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--button id="btn-imprimir" class="btn estado_reporte" folio="${persona.folio}"> <i class="fa-solid fa-download"></i> Generar PDF de reporte</button-->
                        </div>
                        `
                        $('#card').html(template);
                    })
                }
            }
        });       
    } 

    // nuevo reporte
    $(document).on('click', '#add-button', function (e) {
        window.location.href = "../reportes/nuevo.php";
    })

    // cancelar reporte
    $(document).on('click', '#btn-cancelar', function (e) {
        let element = $(this)[0];
        let folio = $(element).attr('folio');
        if (confirm('¿Desea cancelar el reporte con folio '+folio+'?, Esta acción es irreversible')){
            const postData = {
                cancelar_reporte: folio
            };
            $.post('../bdd/scriptusuario.php', postData, function (response) {
                alert(response);
            }); 
            e.preventDefault();
            verHistorial();
        }else{
            e.preventDefault();
        }
    })
});