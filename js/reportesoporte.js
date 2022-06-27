$(document).ready(function () {
    verReportes();

    // Ver historial
    function verReportes(){
        let template = '';

        $.ajax({
            url: '../bdd/scriptsoporte.php?atencion',           
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
                            <button type="submit" folio="${persona.folio}" class="answer-button" title="Presione para responder este reporte"> <i class="fa-solid fa-share"></i> Responder </button>  
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
                                <button type="submit" folio="${persona.folio}" class="assign-button" title="Presione para asignarse esta tarea "> <i class="fa-solid fa-check"></i> Asignarmelo </button>
                            </td>
                        </tr>
                    `
                        $('#table-support').html(template);
                    })
                }
            }
        }); 
        
        $.ajax({
            url: '../bdd/scriptsoporte.php?finalizado',           
            type: 'GET',
            success: function (response) {
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
                            <button type="submit" folio="${persona.folio}" class="view-answer-button" title="Presione para ver respuesta este reporte"> <i class="fa-solid fa-eye"></i> Ver respuesta </button>  
                            </td>
                        </tr>
                    `
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
                });   
                e.preventDefault();
                verReportes();
            } else {
                e.preventDefault();
            }
        }
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
            if (confirm('¿Desea responder este reporte?')){
                window.location.href = "../reportes/responder.php?folio="+folio;
            } else {
                e.preventDefault();
            }
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
            if (confirm('¿Desea ver la respuesta de este reporte?')){
                window.location.href = "../reportes/respuesta.php?folio="+folio;
            } else {
                e.preventDefault();
            }
        }
    })

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
});