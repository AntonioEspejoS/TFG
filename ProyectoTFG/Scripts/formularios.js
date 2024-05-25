$(function () {
    //Verificaciones de datos en los input
    $("#dni").on("blur", verificarDni);
    $("#nombre").on("blur", verificarNombre);
    $("#primerApellido").on("blur", verificarPrimerApellido);
    $("#apellido").on("blur", verificarSegundoApellido);
    $("#contra").on("blur", verificarPass);
    $("#correo").on("blur", verificarCorreo);
    $("#licencia").on("blur", verificarLicencia);    
    $("#correoConfirmacion").on("blur", verificarCorreoConfirmacion);
    $("#contraConfirmacion").on("blur", verificarContraConfirmacion);
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

function verificarDni() {
    var dni = $("#dni").val();
    var formato = /^\d{8}[A-Z]$/;

    if (formato.test(dni)) {
        // Cálculo de la letra del DNI
        var numero = dni.substring(0, dni.length - 1);
        var letra = dni.charAt(dni.length - 1);
        var letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
        var letraCalculada = letrasValidas.charAt(numero % 23);

        if (letraCalculada === letra) {
            $("#errorDNI").text("");
            $('#enviar').attr("disabled", false);
        } else {
            $("#errorDNI").text(mensajesError.dni);
            $('#enviar').attr("disabled", true);
        }
    } else {
        // El formato no es válido
        $("#errorDNI").text(mensajesError.dni);
        $('#enviar').attr("disabled", true);
    }
    validarFormulario();
}
function verificarNombre() {
    var formato = /^([A-Z][a-záéíóúñ]+)((\s(de|del|de\ los|de\ las|de\ la)\s[A-Z][a-záéíóúñ]+)*|\s?[A-Z][a-záéíóúñ]+|\s?-\s?[A-Z][a-záéíóúñ]+)*$/;
    if (formato.test($("#nombre").val())) {
        $("#errorNombre").text("");
        $('#enviar').attr("disabled", false);
    } else {
        $("#errorNombre").text(mensajesError.nombre);
        $('#enviar').attr("disabled", true);
    }
    validarFormulario();
}
function verificarPrimerApellido() {
    var formato = /^([A-Z][a-záéíóúñ]+)(\s*-\s*[A-Z]?[a-záéíóúñ]*)*$/;
    if (formato.test($("#primerApellido").val())) {
        $("#errorPrimerApellido").text(""); // No hay error
        $('#enviar').attr("disabled", false);
    } else {
        $("#errorPrimerApellido").text(mensajesError.primerApellido);
        $('#enviar').attr("disabled", true);
    }
    validarFormulario();
}
function verificarSegundoApellido() {
    var formato = /^$|^[A-Z][a-záéíóúñ]+$/; // Permite cadena vacía o palabra con primera letra mayúscula
    if (formato.test($("#apellido").val())) {
        $("#errorApellido").text(""); // No hay error
        $('#enviar').attr("disabled", false);
    } else {
        $("#errorApellido").text(mensajesError.apellido);
        $('#enviar').attr("disabled", true);
    }
    validarFormulario();
}
function verificarPass() {
    var formato = /^[a-z A-Z á-ú Á-Ú 1-9]{8,50}$/;
    if (formato.test($("#contra").val())) {
        $("#errorPass").text("");
        $('#enviar').attr("disabled", false);
    } else {
        $("#errorPass").text(mensajesError.pass);
        $('#enviar').attr("disabled", true);
    }
    validarFormulario();
}
function verificarCorreo() {
    var formato = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/;
    if (formato.test($("#correo").val())) {
        $("#errorEmail").text("");
        $('#enviar').attr("disabled", false);
    } else {
        $("#errorEmail").text(mensajesError.correo);
        $('#enviar').attr("disabled", true);
    }
    validarFormulario();
}


function verificarCorreoConfirmacion() {
    var correo = $("#correo").val();
    var correoConfirmacion = $("#correoConfirmacion").val();
    if (correo !== correoConfirmacion) {
        $("#errorEmailConfirmacion").text(mensajesError.correoConfirmacion);
        $('#enviar').attr("disabled", true);
    } else {
        $("#errorEmailConfirmacion").text("");
    }
    validarFormulario();

}

function verificarContraConfirmacion() {
    var contra = $("#contra").val();
    var contraConfirmacion = $("#contraConfirmacion").val();
    console.log(contra);
    console.log(contraConfirmacion);
    if (contra !== contraConfirmacion) {
        $("#errorPassConfirmacion").text(mensajesError.passConfirmacion);
        $('#enviar').attr("disabled", true);
    } else {
        $("#errorPassConfirmacion").text("");
    }
    validarFormulario();
}

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
function esDniValido(dni) {
    var formato = /^\d{8}[A-Z]$/;
    if (formato.test(dni)) {
        var numero = dni.substring(0, 8);
        var letra = dni.charAt(8);
        var letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
        var letraCalculada = letrasValidas.charAt(parseInt(numero, 10) % 23);
        return letra === letraCalculada;
    }
    return false;
}

function validarFormulario() {
    var rolSeleccionado = $('#rol').val();
    var dniValido = esDniValido($("#dni").val()); 
    var nombreValido = /^([A-Z][a-záéíóúñ]+)((\s(de|del|de\ los|de\ las|de\ la)\s[A-Z][a-záéíóúñ]+)*|\s?[A-Z][a-záéíóúñ]+|\s?-\s?[A-Z][a-záéíóúñ]+)*$/.test($("#nombre").val());
    var primerApellido = /^([A-Z][a-záéíóúñ]+)(\s*-\s*[A-Z]?[a-záéíóúñ]*)*$/.test($("#primerApellido").val());
    var apellidoValido = /^$|^[A-Z][a-záéíóúñ]+$/.test($("#apellido").val());
    var passValido = /^[a-z A-Z á-ú Á-Ú 1-9]{8,50}$/.test($("#contra").val());
    var correoValido = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test($("#correo").val());
    var licenciaValida = true; 
    var passConfirmacionValido = $("#contra").val() === $("#contraConfirmacion").val();
    var correoConfirmacionValido = $("#correo").val() === $("#correoConfirmacion").val();

    if ($("#contraConfirmacion").val() !== "") { // Verifica si el campo de confirmación de contraseña no está vacío
        if ($("#contra").val() === $("#contraConfirmacion").val()) {
            $("#errorPassConfirmacion").text("");
        } else {
            $("#errorPassConfirmacion").text(mensajesError.passConfirmacion);
        }
    } else {
        $("#errorPassConfirmacion").text(""); // Si está vacío, no muestra el mensaje de error
    }

    if ($("#correoConfirmacion").val() !== "") { // Verifica si el campo de confirmación de correo no está vacío
        if ($("#correo").val() === $("#correoConfirmacion").val()) {
            $("#errorEmailConfirmacion").text("");
        } else {
            $("#errorEmailConfirmacion").text(mensajesError.correoConfirmacion);
        }
    } else {
        $("#errorEmailConfirmacion").text(""); // Si está vacío, no muestra el mensaje de error
    }

  
    // Validar licencia solo si el rol es competidor o coach
    if (rolSeleccionado === 'competidor' || rolSeleccionado === 'coach') {
        licenciaValida = /^\d{1,10}$/.test($("#licencia").val());
    }

    // Habilitar o deshabilitar el botón basado en todas las validaciones
    if (dniValido && nombreValido && apellidoValido && passValido && correoValido && licenciaValida && passConfirmacionValido && correoConfirmacionValido && primerApellido) {
        $('#enviar').attr("disabled", false);
    } else {
        $('#enviar').attr("disabled", true);
    }
}
