$(function () {
    //Verificaciones de datos en los input
    $("#licencia").on("blur", verificarLicencia);    
    //Campos para los diferentes roles
    $('#rol').change(function () {
        // Ocultamos todos los campos específicos para resetear el estado visible según la selección anterior
        $('#camposCompetidor1, #camposCompetidor2, #bloqueLicencia, #camposCoach').addClass('oculto');
        //Poner los campos no requeridos
        $('#camposCompetidor1, #camposCompetidor2, #bloqueLicencia, #camposCoach').hide().find(':input').prop('required', false);
        
        // Obtenemos el rol seleccionado del menú desplegable
        var rolSeleccionado = $(this).val();

        // Comprobamos el rol y mostramos los campos correspondientes y los ponemos requeridos
        if (rolSeleccionado === 'competidor') {
            $('#camposCompetidor1, #camposCompetidor2, #bloqueLicencia').show().find(':input').prop('required', true);

        } else if (rolSeleccionado === 'coach') {
            $('#camposCoach, #bloqueLicencia').show().find(':input').prop('required', true);
        }
        validarFormulario();
    });

    //Cambiar pesos según sexos
    
    $('input[type=radio][name=sexo]').change(function () {
        if (this.value === 'm') {
            $('#peso option').remove();
            $('#peso').append("<option value='' selected='true' disabled='disabled'>" + mensajesError.seleccionaTuPeso + "...</option>");
            $('#peso').append("<option value='64'><64kg</option>");
            $('#peso').append("<option value='69'><69kg</option>");
            $('#peso').append("<option value='74'><74kg</option>");
            $('#peso').append("<option value='79'><79kg</option>");
            $('#peso').append("<option value='84'><84kg</option>");
            $('#peso').append("<option value='90'>>90kg</option>");
        } else if (this.value === 'f') {
            $('#peso option').remove();
            $('#peso').append("<option value='' selected='true' disabled='disabled'>" + mensajesError.seleccionaTuPeso + "...</option>");
            $('#peso').append("<option value='49'><49kg</option>");
            $('#peso').append("<option value='59'><59kg</option>");
            $('#peso').append("<option value='64'><64kg</option>");
            $('#peso').append("<option value='69'><69kg</option>");
            $('#peso').append("<option value='74'><74kg</option>");
            $('#peso').append("<option value='79'>>79kg</option>");

        }
    });
    $('#club').change(function () {
        if ($(this).val() === 'nuevo') {
            // Mostrar los campos para el nuevo club y localidad
            $('#nuevo_club_container').show().find(':input').prop('required', true);
        } else {
            // Ocultar los campos para el nuevo club y localidad
            $('#nuevo_club_container').hide().find(':input').prop('required', false);
        }
    });
});

function verificarLicencia() {
    var formato = /^\d{1,10}$/;
    if (formato.test($("#licencia").val())) {
        $("#errorLicencia").text("");
        $('#enviar').attr("disabled", false);
    } else {
        $("#errorLicencia").text(mensajesError.licencia);
        $('#enviar').attr("disabled", true);
    }
    validarFormulario();
}


function validarFormulario() {
    var rolSeleccionado = $('#rol').val();
    var licenciaValida = true; 
 
    // Validar licencia solo si el rol es competidor o coach
    if (rolSeleccionado === 'competidor' || rolSeleccionado === 'coach') {
        licenciaValida = /^\d{1,10}$/.test($("#licencia").val());
    }

    // Habilitar o deshabilitar el botón basado en todas las validaciones
    if ( licenciaValida) {
        $('#enviar').attr("disabled", false);
    } else {
        $('#enviar').attr("disabled", true);
    }
}
