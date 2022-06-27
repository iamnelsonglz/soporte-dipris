$(document).ready(function () {
    obtenerTipo();
    where();
    obtenerHistorial();


    // Rellenar select
    function where() {
        $.ajax({
            url: '../bdd/ScriptReportes.php?where',
            type: 'GET',
            success: function (response) {
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    template += `
                    <option value="${persona.idEstado}">${persona.nombre}</option>
                `
                    $('#where-u').html(template);
                })
            }
        });
    }

    // Rellenar select
    function obtenerTipo() {
        $.ajax({
            url: '../bdd/ScriptReportes.php?tipo',
            type: 'GET',
            success: function (response) {
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    template += `
                        <option value="${persona.id}">${persona.nombre}</option>
                    `
                    $('#tipo').html(template);
                })
            }
        });
    }

    // Historial reportes
    function obtenerHistorial() {
        $.ajax({
            url: '../bdd/ScriptReportes.php?historial',
            type: 'GET',
            success: function (response) {
                const personas = JSON.parse(response);
                let template = '';
                personas.forEach(persona => {
                    template += `
                    <div class="parent-tab">
                        <input type="radio" name="tab" id="tab-${persona.folio}">
                        <label for="tab-${persona.folio}" title="Presione para ver más detalles de">
                            <span><b>Reporte: ${persona.tipo_problema} Fecha: ${persona.fecha_reporte}<b></span>
                            <div class="icon"><i class="fas fa-plus"></i></div>
                        </label>
                        <div class="history">
                        <p>
                            <label><b>Folio<b></label>
                            <input readonly value="${persona.folio}">
                        </p>
                        <p>
                            <label><b>Fecha de reporte<b></label>
                            <input readonly value="${persona.fecha_reporte}">
                        </p>
                        <p>
                            <label><b>Tipo de problema<b></label>
                            <input readonly value="${persona.tipo_problema}">
                        </p>
                        <p>
                            <label><b>Descripcion<b></label>
                            <input readonly value="${persona.descripcion}">
                        </p>
                        <p>
                            <label><b>Atendido por<b></label>
                            <input readonly value="${persona.personal}">
                        </p>
                        <p>
                            <label><b>Fecha de respuesta<b></label>
                            <input readonly value="${persona.fecha_respuesta}">
                        </p>
                        <p>
                            <label><b>Respuesta<b></label>
                            <input readonly value="${persona.respuesta}">
                        </p>
                        <p>
                            <label><b>Estado del reporte<b></label>
                            <input readonly value="${persona.estado}">
                        </p>
                        </div>
                    </div>                      
                    `
                    $('#content-history').html(template);
                })
            }
        });
    }
});