$(document).ready(function () {
    verReporte();

    function verReporte(){
        // Leer variable GET
        let params = new URLSearchParams(location.search);
        var folio = params.get('folio');
        if ((folio.length <= 0) || (folio === '0')){
            alert('Folio invalido');
        }else{
            let template = '';
            $.ajax({
                url: '../bdd/scriptsoporte.php?respuestaver='+folio,
                type: 'GET',
                success: function (response) {
                    if (response === '[]') {
                        console.log("Sin resultados");
                        template += `<br>
                        <h2 class="titulo_reporte">No existe el reporte</h2>
                        <br>
                        <br>`;
                        $('#content-enviado').html(template);
                    }else{
                        const personas = JSON.parse(response);
                        //template = '';
                        personas.forEach(persona => {
                            template += `
                            <div class="cuerpo-resp">
                            <table>
                                <!-- Encabezado de tabla -->
                                <thead>
                                    <tr id="header">
                                        <th>MENSAJE RECIBIDO</th>
                                    </tr>
                                </thead>
                                <!-- Contenido de la tabla  -->
                                <tbody>
                                <tr>
                                    <td><b>FECHA Y HORA DE ENVIO:</b> ${persona.fecha}</td>
                                </tr>
                                <td><b>TIPO DE REPORTE:</b> ${persona.tipo}</td>
                                <tr>
                                </tr>
                                <tr>
                                    <td><b>MENSAJE:</b> ${persona.descripcion}</td>
                                <tr/>
                                <tr>
                                    <td><b>PERSONA QUE REPORTA:</b> ${persona.nombre} ${persona.paterno} ${persona.materno}</td>
                                <tr/>
                                <tr>
                                    <td><b>DEPARTAMENTO:</b> ${persona.departamento}, ubicado en la planta ${persona.planta}</td>
                                <tr/>
                                </tbody>
                            </table>
                            </div>
                            <br>
                            `
                            let resp = '';
                            resp += `${persona.respuesta}`
                            $('#content-enviado').html(template);
                            $('#answer').html(resp);
                        })
                    }
                } 
            });
        }                                                                            
    }

// Redimensionar el text area
const textarea = document.querySelector("textarea");
textarea.addEventListener("keyup", e => {
    textarea.style.height = "5rem";
    let scHeight = e.target.scrollHeight;
    textarea.style.height = `${scHeight}px`
})

});