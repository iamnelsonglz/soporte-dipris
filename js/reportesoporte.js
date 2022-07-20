$(document).ready(function () {
    finish();
    wait();
    attention();
    verEsperaAtencion();
    fecha();

    function finish(){
        $.ajax({
            url: '../bdd/scriptsoporte.php?finish',
            type: 'GET',
            beforeSend: function (xhr) {
                
            },
            success: function (response) {
                
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    console.log("-->"+persona);
                    template += `
                    <label class="txt"> <i class="fa-solid fa-circle-check"></i> Total: ${persona.total}</label>
                    `;
                    $('.scoreboard-fin').html(template);
                    
                })
            }    
        }); 
    }

    function wait(){
        $.ajax({
            url: '../bdd/scriptsoporte.php?wait',
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
            url: '../bdd/scriptsoporte.php?attention',
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

    function fecha(){
        var fecha = new Date();
        document.getElementById("fechainicio").value = fecha.toJSON().slice(0,10);
        document.getElementById("fechafin").value = fecha.toJSON().slice(0,10);
    }

    // Ver historial Espera y Atención
    function verEsperaAtencion(){
        let template = '';

        $.ajax({
            url: '../bdd/scriptsoporte.php?atencion',           
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    console.log("Sin resultados");
                    template = `
                        <tr>
                            <td>No tiene reportes pendientes de respuesta</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        `
                        ;
                    $('#table-support').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    personas.forEach(persona => {
                        template += `
                        <tr folio="${persona.folio}" class="selected">
                            <td>${persona.fecha}</td>
                            <td>${persona.tipo}</td>
                            <td>${persona.usuario}</td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="answer-button btn" title="Presione para responder este reporte"> <i class="fa-solid fa-share"></i> Responder </button>  
                            </td>
                        </tr>
                    `
                        $('#table-support').html(template);
                    })
                }
            }
            
        });

        $.ajax({
            url: '../bdd/scriptsoporte.php?pendientes',
            type: 'GET',
            beforeSend: function (xhr) {
               
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    console.log("Sin resultados");
                        template += `
                        <tr>
                                <td>No hay reportes pendientes para asignar</td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                         
                    `
                        $('#table-support').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    personas.forEach(persona => {
                        template += `
                        <tr folio="${persona.folio}" class="selected">
                            <td>${persona.fecha}</td>
                            <td>${persona.tipo}</td>
                            <td>${persona.usuario}</td>
                            <td>
                                <button type="submit" folio="${persona.folio}" class="btn previsualizar__solicitud" title="Presione para ver la solicitud "> <i class="fa-solid fa-eye"></i> Ver solicitud</button>
                            </td>
                        </tr>
                    `
                        $('#table-support').html(template);
                    })
                }
            }
        }); 
    }

    function verFinalizado(){
        let template = '';
        
        $.ajax({
            url: '../bdd/scriptsoporte.php?finalizado',           
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    console.log("Sin resultados");
                    template += `
                        <tr>
                            <td>No tiene reportes respondidos</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <tr/>`;
                    $('#table-support').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    personas.forEach(persona => {
                        template += `
                        <tr folio="${persona.folio}" class="selected">
                            <td>${persona.fecha}</td>
                            <td>${persona.tipo}</td>
                            <td>${persona.usuario}</td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="btn view-answer-button l-media-btn" title="Presione para ver respuesta este reporte"> <i class="fa-solid fa-eye"></i> Ver respuesta </button>  
                            <button type="submit" folio="${persona.folio}" class="btn assign-button l-media-btn" title="Presione para generar pdf "> <i class="fa-solid fa-file-pdf"></i> Generar </button>
                            </td>
                        </tr>
                    `
                        $('#table-support').html(template);
                    })
                }
            }
            
        });
    }

    // filtrar reporte
    $(document).on('click', '#where-support', function (e) {
        let filtro = $('#where-support').val();
        if(filtro == 1){
            verReportes();
        }else{
            $.ajax({
                url: '../bdd/scriptsoporte.php?atencion',
                
                type: 'GET',
                success: function (response) {
                    if (response === '[]') {
                        console.log("Sin resultados");
                    }
                    else {
                        const personas = JSON.parse(response);
                        let template = '';
                        personas.forEach(persona => {
                            template += `
                            <tr folio="${persona.folio}" class="selected">
                                <td>${persona.fecha}</td>
                                <td>${persona.tipo}</td>
                                <td>${persona.usuario}</td>
                                <td>
                                    
                                </td>
                            </tr>
                        `
                            $('#table-support').html(template);
                        })
                    }
                }
                
            });
        }
         
    })

    // Ver historial
    function filtrarEsperaAtencion(fechainicio,fechafin){
        let template = '';
        $.ajax({
            url: '../bdd/scriptsoporte.php?atencionfiltro=true&inicio='+fechainicio+'&fin='+fechafin,           
            type: 'GET',
            
            success: function (response) {
                
                if (response === '[]') {
                    console.log("Sin resultados");
                    template = `
                        <tr>
                            <td>No tiene reportes pendientes de respuesta</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <tr/>`;
                    $('#table-support').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    personas.forEach(persona => {
                        template += `
                        <tr folio="${persona.folio}" class="selected">
                            <td>${persona.fecha}</td>
                            <td>${persona.tipo}</td>
                            <td>${persona.usuario}</td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="btn answer-button l-media-btn" title="Presione para responder este reporte"> <i class="fa-solid fa-share"></i> Responder </button>  
                            </td>
                        </tr>
                    `
                        $('#table-support').html(template);
                    })
                }
            }
            
        });

        $.ajax({
            url: '../bdd/scriptsoporte.php?pendientesfiltro=true&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            
            success: function (response) {
                
                if (response === '[]') {
                    console.log("Sin resultados");
                        template += `
                        <tr>
                                <td>No hay reportes pendientes para asignar</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            <tr/>
                    `
                        $('#table-support').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    personas.forEach(persona => {
                        template += `
                        <tr folio="${persona.folio}" class="selected">
                            <td>${persona.fecha}</td>
                            <td>${persona.tipo}</td>
                            <td>${persona.usuario}</td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="btn previsualizar__solicitud" title="Presione para ver la solicitud "> <i class="fa-solid fa-eye"></i> Ver solicitud</button>
                            </td>
                        </tr>
                    `
                        $('#table-support').html(template);
                    })
                }
            }
        }); 
    }

    function filtrarFinalizado(fechainicio,fechafin){
        let template='';
        $.ajax({
            url: '../bdd/scriptsoporte.php?finalizadofiltro=true&inicio='+fechainicio+'&fin='+fechafin,           
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    console.log("Sin resultados");
                    template += `
                        <tr>
                            <td>No tiene reportes respondidos</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <tr/>`;
                    $('#table-support').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    personas.forEach(persona => {
                        template += `
                        <tr folio="${persona.folio}" class="selected">
                            <td>${persona.fecha}</td>
                            <td>${persona.tipo}</td>
                            <td>${persona.usuario}</td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="btn view-answer-button l-media-btn" title="Presione para ver respuesta este reporte"> <i class="fa-solid fa-eye"></i> Ver respuesta </button>  
                            <button type="button" folio="${persona.folio}" class="btn pdf-button l-media-btn" title="Presione para generar pdf "> <i class="fa-solid fa-file-pdf"></i> Generar </button>
                            </td>
                        </tr>
                    `;
                        $('#table-support').html(template);
                    })
                }
            }
            
        });
    }

    // Autoasignar tarea
    $(document).on('click', '.assign-button', function (e) {
        // Extraer folio del reporte
        let element = $(this)[0];
        let folio = $(element).attr('folio');

        // Comprobar que se haya seleccionado una opción del select
        if ((folio.length <= 0) || (folio === '0')){
            alert('Folio de reporte invalido');
        }else{
            if (confirm('¿Desea autoasignarse esta tarea?')){
                const postData = {
                    autoasignar: folio
                };
                $.post('../bdd/scriptsoporte.php', postData, function (response) {
                    alert(response);
                    cerrarModal();
                    finish();
                    wait();
                    attention();
                    verEsperaAtencion();
                });   
            } else { 
            }
        }
    })

    // Generar pdf de reporte
     $(document).on('click', '.pdf-button', function (e) {
        // Extraer folio del reporte
        let element = $(this)[0];
        let folio = $(element).attr('folio');
        window.location.href = "../reportes/solicitud.php?folio="+folio;
    })


    // Responder reporte
    $(document).on('click', '.answer-button', function (e) {
        // Extraer folio del reporte
        let element = $(this)[0];
        let folio = $(element).attr('folio');

        // Comprobar que se haya seleccionado una opción del select
        if ((folio.length <= 0) || (folio === '0')){
            alert('Folio de reporte invalido');
        }else{
            window.location.href = "../reportes/responder.php?folio="+folio;
        }
    })

    // ver respuesta reporte
    $(document).on('click', '.view-answer-button', function (e) {
        // Extraer folio del reporte
        let element = $(this)[0];
        let folio = $(element).attr('folio');

        // Comprobar que se haya seleccionado una opción del select
        if ((folio.length <= 0) || (folio === '0')){
            alert('Folio de reporte invalido');
        }else{
            window.location.href = "../reportes/respuesta.php?folio="+folio;
        }
    })

    // Filtrar solicitudes
    let seleccion = document.querySelectorAll('input[name=radOverclock]');
    $(document).on('click', '#estado-filter', function (e) {
        e.preventDefault();
        if (seleccion[0].checked) {
            verEsperaAtencion();
        } else if (seleccion[1].checked) {
            verFinalizado();
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
                    filtrarFinalizado(fechainicio,fechafin);
                }
            }
        } else {
            
        }   
    }) 
    
    $(document).on('click', '.close', function (e) {
        modal.style.display = "none";
    })

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var modal = document.getElementById("modalPrevisual");
    function cerrarModal(){
        modal.style.display = "none";
    }

    // Previsualizar solicitud
    $(document).on('click', '.previsualizar__solicitud', function (e) {
        modal.style.display = "block";
        let template = '';
        e.preventDefault();   
            let element = $(this)[0];
            let folio = $(element).attr('folio');
            $.ajax({
                url: '../bdd/scriptsoporte.php?previsual='+folio,
                type: 'GET',
                success: function (response) {
                        console.log(response);
                        const personas = JSON.parse(response);
                        personas.forEach(persona => {
                            template = '';
                            template += `
                            <div>
                                <label class="txt" for="reporta"><b>Persona que reporta:</b> </label>
                                <label class="txt" name="reporta" id="p_reporta">${persona.nombre} ${persona.paterno} ${persona.materno}</label>
                            </div>
                            <div>
                                <label class="txt" for="tipop"><b>Tipo de usuario: </b></label>
                                <label class="txt" name="tipop" id="tipo_reporta">${persona.categoria}</label>
                            </div>
                            <div>
                                <label class="txt" for="reporta"><b>Departamento:</b> </label>
                                <label class="txt" name="reporta" id="p_reporta">${persona.departamento}, ubicado en la planta ${persona.planta}</label>
                            </div>
                            <div>
                                <label class="txt" for="msj"><b>Mensaje:</b> </label>
                                <label class="txt" name="msj" id="msj_solicitud">${persona.descripcion}</label>
                            </div>
                            `;
                            $('#modalbody__espera').html(template);
                            $('#modalbody__espera').show();
                        })

                        personas.forEach(persona => {
                            template = '';
                            template += `
                            <div>
                                
                            </div>
                            <div>
                            <button type="submit" folio="${persona.folio}" class="assign-button btn" title="Presione para asignarse esta solicitud "> <i class="fa-solid fa-check"></i> Asignarmelo </button>
                            </div>
                            `;
                            $('#modalfooter__espera').html(template);
                            $('#modalfooter__espera').show();
                        })
                        
                } 
            });
    })
});