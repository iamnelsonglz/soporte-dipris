$(document).ready(function () {
    estadoSolicitud();
    fecha();
    verHistorialEspera();

    // Rellenar estados de solicitud
    function estadoSolicitud() {
        $.ajax({
            url: '../bdd/scriptusuario.php?verestados',
            type: 'GET',
            success: function (response) {
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    template += `
                    <option value="${persona.idEstado}">${persona.nombre}</option>
                `
                    $('#where').html(template);
                })
            }
        });
    }

    // Mostrar fecha actual en filtro de fecha
    function fecha(){
        var fecha = new Date();
        document.getElementById("fechainicio").value = fecha.toJSON().slice(0,10);
        document.getElementById("fechafin").value = fecha.toJSON().slice(0,10);
    }

    // Mostrar solicitudes con el estado Espera
    function verHistorialEspera(){
        let template = '';
        $.ajax({
            url: '../bdd/scriptusuario.php?historial=true&estado=1',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes en espera en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    template = '';
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
                                <thead class="headt">
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody class="bodyt">
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
    }

    // Mostrar solicitudes con el estado Atención
    function verHistorialAtencion(){
        $.ajax({
            url: '../bdd/scriptusuario.php?historial=true&estado=2',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template = '';
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes en atención en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    template = '';
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
                                <thead class="headt">
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody class="bodyt">
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

    // Mostrar solicitudes con el estado Finalizado
    function verHistorialFinalizado(){
        $.ajax({
            url: '../bdd/scriptusuario.php?historial=true&estado=3',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template = '';
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes finalizadas en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    template = '';
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
                                <thead class="headt">
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody class="bodyt">
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

    // Mostrar solicitudes con el estado Cancelado
    function verHistorialCancelado(){
        $.ajax({
            url: '../bdd/scriptusuario.php?historial=true&estado=4',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template = '';
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes canceladas en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    template = '';
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
                                <thead class="headt">
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody class="bodyt">
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

    // Filtrar solicitudes con el estado Espera
    function filtrarHistorialEspera(fechainicio,fechafin){
        let template = '';
        $.ajax({
            url: '../bdd/scriptusuario.php?filtrar=true&estado=1&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes en espera en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    template = '';
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
                                <thead class="headt">
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody class="bodyt">
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
    }

    // Filtrar solicitudes con el estado Atención
    function filtrarHistorialAtencion(fechainicio,fechafin){
        $.ajax({
            url: '../bdd/scriptusuario.php?filtrar=true&estado=2&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template = '';
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes en atención en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    template = '';
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
                                <thead class="headt">
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody class="bodyt">
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

    // Filtrar solicitudes con el estado Finalizado
    function filtrarHistorialFinalizado(fechainicio,fechafin){
        $.ajax({
            url: '../bdd/scriptusuario.php?filtrar=true&estado=3&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template = '';
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes finalizadas en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    template = '';
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
                                <thead class="headt">
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody class="bodyt">
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

    // Filtrar solicitudes con el estado Cancelado
    function filtrarHistorialCancelado(fechainicio,fechafin){
        $.ajax({
            url: '../bdd/scriptusuario.php?filtrar=true&estado=4&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template = '';
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes canceladas en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    template = '';
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
                                <thead class="headt">
                                    <tr id="header">
                                        <th>MENSAJE ENVIADO</th>
                                        <th>RESPUESTA</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody class="bodyt">
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

    // filtrar solicitudes por estado
    $(document).on('click', '#estado-filter', function (e) {
        let filtro = $('#where').val();
        if(filtro == 1){
            verHistorialEspera();
        }else if(filtro == 2){
            verHistorialAtencion();
        }else if(filtro == 3){
            verHistorialFinalizado();
        }else if(filtro == 4){
            verHistorialCancelado();
        }else{

        }
         
    })

    // filtrar solicitudes por fecha
    $(document).on('click', '#filter-button', function (e) {
        let fechainicio = $("#fechainicio").val();
        let fechafin = $("#fechafin").val();
        let filtro = $('#where').val();

        if(fechainicio.length <= 0 || fechafin.length <= 0){
            e.preventDefault();
            alert("Es necesario seleccionar fecha de inicio y fecha de fin");
            
        }else{
            if(Date.parse(fechafin) < Date.parse(fechainicio)) {
                e.preventDefault();
                alert("La fecha final debe ser mayor o igual a la fecha de inicio");
               
            }else{
                if(filtro == 1){
                    filtrarHistorialEspera(fechainicio,fechafin);
                }else if(filtro == 2){
                    filtrarHistorialAtencion(fechainicio,fechafin);
                }else if(filtro == 3){
                    filtrarHistorialFinalizado(fechainicio,fechafin);
                }else if(filtro == 4){
                    filtrarHistorialCancelado(fechainicio,fechafin);
                }else{

                }
            }
        }
    })

    // nuevo reporte
    $(document).on('click', '#add-button', function (e) {
        window.location.href = "../reportes/nuevo.php";
    })

    // cancelar reporte
    $(document).on('click', '#btn-cancelar', function (e) {
        e.preventDefault();
        let element = $(this)[0];
        let folio = $(element).attr('folio');
        if (confirm('¿Desea cancelar el reporte con folio '+folio+'?, Esta acción es irreversible')){
            const postData = {
                cancelar_reporte: folio
            };
            $.post('../bdd/scriptusuario.php', postData, function (response) {
                alert(response);
                verHistorialEspera();
            });         
        }else{
            
        }
    })
});