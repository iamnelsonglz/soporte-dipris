$(document).ready(function () {
    finish();
    wait();
    attention();
    where();
    fecha();
    obtenerReportesEspera();

    function finish(){
        $.ajax({
            url: '../bdd/scriptreportes.php?finish',
            type: 'GET',
            beforeSend: function (xhr) {
                
            },
            success: function (response) {
                
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    console.log("-->"+persona);
                    template += `
                    <li> <i class="fa-solid fa-clipboard-user"></i> ${persona.total} | ${persona.nombre}</li>
                    `;
                    $('.scoreboard-fin').html(template);
                    
                })
            }    
        }); 
    }

    function wait(){
        $.ajax({
            url: '../bdd/scriptreportes.php?wait',
            type: 'GET',
            success: function (response) {
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    template += `
                    <label class="txt"> <i class="fa-solid fa-clipboard-list"></i> Total: ${persona.total}</label>
                    `;
                    $('#totalespera').html(template);
                })
            }    
        }); 
    }

    function attention(){
        $.ajax({
            url: '../bdd/scriptreportes.php?attention',
            type: 'GET',
            beforeSend: function (xhr) {
                
            },
            success: function (response) {
                
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    console.log("-->"+persona);
                    template += `
                    <li> <i class="fa-solid fa-clipboard-user"></i> ${persona.total} | ${persona.nombre}</li>
                    `;
                    $('.scoreboard-aten').html(template);
                    
                })
            }    
        }); 
    }

    // Rellenar estados de solicitud
    function where() {
        $.ajax({
            url: '../bdd/scriptreportes.php?where',
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

    function fecha(){
        var fecha = new Date();
        document.getElementById("fechainicio").value = fecha.toJSON().slice(0,10);
        document.getElementById("fechafin").value = fecha.toJSON().slice(0,10);
    }

    // Mostrar las solicitudes en Espera
    function obtenerReportesEspera() {
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?espera',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <tr>
                    <td>No hay reportes pendientes de atención</td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr/>`;
                    $('#table-admin').html(template);
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
                            <select name="user-soporte" id="${persona.folio}" class="support-user in">
                            </select>
                            </td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="assign-button btn" title="Presione para asignar tarea "> <i class="fa-solid fa-check"></i> Asignar </button>
                            </td>
                        </tr>
                    `;
                        $('#table-admin').html(template);
                    })
                    selectSoporte();
                }

            }
        });
        
    }

    // Mostrar las solicitudes en Atención
    function obtenerReportesAtencion() {
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?atencion',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <tr>
                    <td>No hay reportes en atención</td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr/>`;
                    $('#table-admin').html(template);
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
                            <select name="user-soporte" id="${persona.folio}" class="support-user">
                            <option value="${persona.user}">${persona.responde}</option>
                            </select>
                            <button type="submit" folio="${persona.folio}" class="assign-button btn" title="Presione para asignar tarea "> <i class="fa-solid fa-check"></i> Re-asignar </button>
                            </td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="pdf-button btn" title="Presione para generar pdf "> <i class="fa-solid fa-file-pdf"></i> Descargar solicitud</button>
                            </td>
                        </tr>
                    `;
                        $('#table-admin').html(template);
                    })
                }

            }
        });
    }

    // Mostrar las solicitudes Finalizadas
    function obtenerReportesFinalizado() {
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?finalizado',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <tr>
                    <td>No hay reportes finalizados</td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr/>`;
                    $('#table-admin').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    personas.forEach(persona => {
                        template += `
                        <tr folio="${persona.folio}" class="selected">
                            <td>${persona.fecha}</td>
                            <td>${persona.tipo}</td>
                            <td>${persona.usuario}</td>
                            <td></td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="pdf-button btn" title="Presione para generar pdf "> <i class="fa-solid fa-file-pdf"></i> Descargar solicitud</button>
                            </td>
                        </tr>
                    `
                        $('#table-admin').html(template);
                    })
                }

            }
        });
    }

    // Mostrar los reportes Caneladas
    function obtenerReportesCancelado() {
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?cancelado',
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <tr>
                    <td>No hay reportes cancelados</td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr/>`;
                    $('#table-admin').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    personas.forEach(persona => {
                        template += `
                        <tr folio="${persona.folio}" class="selected">
                            <td>${persona.fecha}</td>
                            <td>${persona.tipo}</td>
                            <td>${persona.usuario}</td>
                            <td>No asignado</td>
                            <td>Sin acción</td>
                        </tr>
                    `
                        $('#table-admin').html(template);
                    })
                }

            }
        });
    }

    // Rellenar select con usuarios de soporte
    function selectSoporte(){
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?soporte',
            type: 'GET',
            success: function (response) {
                if (response === '[]') {
                    template += `
                    <option>
                    No existen opciones
                    </option>`;
                    $('.support-user').html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    template = '<option value="0">Seleccione una opción</option>';
                    personas.forEach(persona => {
                        template += `
                            <option value="${persona.usuario}" usr="${persona.usuario}">
                                ${persona.nombre}
                            </option>
                         
                    `;
                        $('.support-user').html(template);
                    })
                }

            }
        });
    }

    // Rellenar select con usuarios de soporte
    function reselectSoporte(id){
       
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?soporte',
            type: 'GET',
            success: function (response) {
                if (response === '[]') {
                    template += `
                    <option>
                    No existen opciones
                    </option>`;
                    $('#'+id).html(template);
                }
                else {
                    const personas = JSON.parse(response);
                    template = '<option value="0">Seleccione una opción</option>';
                    personas.forEach(persona => {
                        template += `
                            <option value="${persona.usuario}" usr="${persona.usuario}">
                                ${persona.nombre}
                            </option>
                         
                    `;
                        $('#'+id).html(template);
                    })
                }

            }
        });
    }

    // Filtrar solicitudes Espera
    function filtrarReportesEspera(fechainicio,fechafin){
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?esperafiltro=true&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <tr>
                    <td>No hay reportes pendientes de atención</td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr/>`;
                    $('#table-admin').html(template);
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
                            <select name="user-soporte" id="${persona.folio}" class="support-user in">
                            </select>
                            </td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="assign-button btn" title="Presione para asignar tarea "> <i class="fa-solid fa-check"></i> Asignar </button>
                            </td>
                        </tr>
                    `;
                        $('#table-admin').html(template);
                    })
                    selectSoporte();
                }

            }
        });
    }

    // Filtrar solicitudes Atención
    function filtrarReportesAtencion(fechainicio,fechafin){
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?atencionfiltro=true&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <tr>
                    <td>No hay reportes pendientes de atención</td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr/>`;
                    $('#table-admin').html(template);
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
                            <select name="user-soporte" id="${persona.folio}" class="support-user in">
                            </select>
                            </td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="assign-button btn" title="Presione para asignar tarea "> <i class="fa-solid fa-check"></i> Asignar </button>
                            </td>
                        </tr>
                    `;
                        $('#table-admin').html(template);
                    })
                    selectSoporte();
                }

            }
        });
    }

    // Filtrar solicitudes Finalizado
    function filtrarReportesFinalizado(fechainicio,fechafin){
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?finalizadofiltro=true&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <tr>
                    <td>No hay reportes pendientes de atención</td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr/>`;
                    $('#table-admin').html(template);
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
                            <select name="user-soporte" id="${persona.folio}" class="support-user in">
                            </select>
                            </td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="assign-button btn" title="Presione para asignar tarea "> <i class="fa-solid fa-check"></i> Asignar </button>
                            </td>
                        </tr>
                    `;
                        $('#table-admin').html(template);
                    })
                    selectSoporte();
                }

            }
        });
    }

    // Filtrar solicitudes Cancelado
    function filtrarReportesCancelado(fechainicio,fechafin){
        let template = '';
        $.ajax({
            url: '../bdd/scriptreportes.php?canceladofiltro=true&inicio='+fechainicio+'&fin='+fechafin,
            type: 'GET',
            beforeSend: function (xhr) {
                $("#loadtabla").fadeIn("slow");
            },
            success: function (response) {
                $("#loadtabla").fadeOut("slow");
                if (response === '[]') {
                    template += `
                    <tr>
                    <td>No hay reportes pendientes de atención</td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr/>`;
                    $('#table-admin').html(template);
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
                            <select name="user-soporte" id="${persona.folio}" class="support-user in">
                            </select>
                            </td>
                            <td>
                            <button type="submit" folio="${persona.folio}" class="assign-button btn" title="Presione para asignar tarea "> <i class="fa-solid fa-check"></i> Asignar </button>
                            </td>
                        </tr>
                    `;
                        $('#table-admin').html(template);
                    })
                    selectSoporte();
                }

            }
        });
    }

    $(document).on('click', '.support-user', function (e) {
        // var s = document.querySelector(".support-user");
        const id = e.target.getAttribute("id");
        const l = e.target.length;
        
        if(l <= 1){
            reselectSoporte(id);
        }else{
            
        }
    })

    /* nuevo reporte
    $(document).on('click', '.add-button', function (e) {
        window.location.href = "../reportes/nuevo.php";
    })*/

    // Asignar tarea
    $(document).on('click', '.assign-button', function (e) {
        e.preventDefault();
        // Extraer folio del reporte
        let element = $(this)[0];
        let folio = $(element).attr('folio');

        // Extraer datos del select para asignar tarea
        let id_select = $('#'+folio).val();

        // Comprobar que se haya seleccionado una opción del select
        if ((id_select.length <= 0) || (id_select === '0')){
            alert('Seleccione una opción valida');
        }else{
            if (confirm('¿Desea asignar esta tarea a '+id_select+'?')){
                const postData = {
                    add_soporte: id_select,
                    folio_reporte: folio
                };
                $.post('../bdd/scriptreportes.php', postData, function (response) {
                    alert(response);
                    obtenerReportesEspera();
                });   
                   
            } else {
              
            }
        }
    })

    // filtrar reporte
    $(document).on('click', '#estado-filter', function (e) {
        let filtro = $('#where').val();
        if(filtro == 1){
            obtenerReportesEspera();
        }else if(filtro == 2){
            obtenerReportesAtencion();
        }else if(filtro == 3){
            obtenerReportesFinalizado();
        }else if(filtro == 4){
            obtenerReportesCancelado();
        }else{

        }
         
    })

    // Generar pdf de reporte
    $(document).on('click', '.pdf-button', function (e) {
        // Extraer folio del reporte
        let element = $(this)[0];
        let folio = $(element).attr('folio');
        window.location.href = "../reportes/solicitud.php?folio="+folio;
    })

    // filtrar solicitudes
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
                    filtrarReportesEspera(fechainicio,fechafin);
                }else if(filtro == 2){
                    filtrarReportesAtencion(fechainicio,fechafin);
                }else if(filtro == 3){
                    filtrarReportesFinalizado(fechainicio,fechafin);
                }else if(filtro == 4){
                    filtrarReportesCancelado(fechainicio,fechafin);
                }else{

                }
            }
        }
    })

    // Generar pdf de solicitudes filtradas
    $('#filter-pdf-button').on('click', function(e){
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
                
            }
        }
    
})

});