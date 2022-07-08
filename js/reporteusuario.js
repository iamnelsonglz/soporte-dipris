$(document).ready(function () {
    wait();
    attention();
    fecha();
    verEsperaAtencion();

    function wait(){
        $.ajax({
            url: '../bdd/scriptusuario.php?wait',
            type: 'GET',
            success: function (response) {
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    template += `
                    <label class="txt"> <i class="fa-solid fa-clock"></i> Total: ${persona.total}</label>
                    `;
                    $('.scoreboard-esp').html(template);
                })
            }    
        }); 
    }

    function attention(){
        $.ajax({
            url: '../bdd/scriptusuario.php?attention',
            type: 'GET',
            beforeSend: function (xhr) {
                
            },
            success: function (response) {
                
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    console.log("-->"+persona);
                    template += `
                    <label class="txt"> <i class="fa-solid fa-bell-concierge"></i> Total: ${persona.total}</label>
                    `;
                    $('.scoreboard-aten').html(template);
                    
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
    function verEsperaAtencion(){
        let template = '';
        $.ajax({
            url: '../bdd/scriptusuario.php?historial=true&estado=1',
            type: 'GET',
            
            success: function (response) {
                
                if (response === '[]') {
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes en espera en este momento</h2>
                    </div>
                    <br>
                    <br>
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

        $.ajax({
            url: '../bdd/scriptusuario.php?historial=true&estado=2',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes en atención en este momento</h2>
                    </div>
                   
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    
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
    function verFinalizadoCancelado(){
        $.ajax({
            url: '../bdd/scriptusuario.php?historial=true&estado=3',
            type: 'GET',
            beforeSend: function (xhr) {
                
            },
            success: function (response) {
                
                if (response === '[]') {
                    template = '';
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes finalizadas en este momento</h2>
                    </div>
                    <br>
                    <br>
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
        
        $.ajax({
            url: '../bdd/scriptusuario.php?historial=true&estado=4',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes canceladas en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    
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
    function filtrarEsperaAtencion(fechainicio,fechafin){
        let template = '';
        $.ajax({
            url: '../bdd/scriptusuario.php?filtrar=true&estado=1&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            
            success: function (response) {
                
                if (response === '[]') {
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes en espera en este momento</h2>
                    </div>
                    <br>
                    <br>
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

        $.ajax({
            url: '../bdd/scriptusuario.php?filtrar=true&estado=2&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes en atención en este momento</h2>
                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    
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
    function filtrarFinalizadoCancelado(fechainicio,fechafin){
        $.ajax({
            url: '../bdd/scriptusuario.php?filtrar=true&estado=3&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
           
            success: function (response) {
                
                if (response === '[]') {
                    template = '';
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes finalizadas en este momento</h2>
                    </div>
                    <br>
                    <br>
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

        $.ajax({
            url: '../bdd/scriptusuario.php?filtrar=true&estado=4&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    
                    template += `
                    <div class="cabecera">
                    <h2 class="titulo_reporte">No hay solicitudes canceladas en este momento</h2>

                    </div>
                    `;
                    $('#card').html(template);
                }else{
                    const personas = JSON.parse(response);
                    
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

    // Filtrar solicitudes
    let seleccion = document.querySelectorAll('input[name=radOverclock]');
    $(document).on('click', '#estado-filter', function (e) {
        e.preventDefault();
        if (seleccion[0].checked) {
            verEsperaAtencion();
        } else if (seleccion[1].checked) {
            verFinalizadoCancelado();
        } else {
            
        }
    })

    // filtrar solicitudes por fecha
    $(document).on('click', '#filter-button', function (e) {
        e.preventDefault();
        let fechainicio = $("#fechainicio").val();
        let fechafin = $("#fechafin").val();
        if (seleccion[0].checked) {
            if(fechainicio.length <= 0 || fechafin.length <= 0){
                alert('Es necesario seleccionar fecha de inicio y fecha de fin');  
            }else{
                if(Date.parse(fechafin) < Date.parse(fechainicio)) {
                    alert('La fecha final debe ser mayor o igual a la fecha de inicio'); 
                }else{
                    filtrarEsperaAtencion(fechainicio,fechafin);
                }
            }
        } else if (seleccion[1].checked) {
            if(fechainicio.length <= 0 || fechafin.length <= 0){
                alert('Es necesario seleccionar fecha de inicio y fecha de fin');  
            }else{
                if(Date.parse(fechafin) < Date.parse(fechainicio)) {
                    alert('La fecha final debe ser mayor o igual a la fecha de inicio'); 
                }else{
                    filtrarFinalizadoCancelado(fechainicio,fechafin);
                }
            }
        } else {
            
        }   
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
                verEsperaAtencion();
            });         
        }else{
            
        }
    })

    // nuevo reporte
     $(document).on('click', '#add-button', function (e) {
        window.location.href = "../reportes/nuevo.php";
    })
});