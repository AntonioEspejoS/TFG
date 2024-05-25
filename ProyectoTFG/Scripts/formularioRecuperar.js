$(function () {
    //Verificaciones de datos en los input
    $("#dni").on("blur", verificarDni);
    $("#correo").on("blur", verificarCorreo);

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
    var dniValido = esDniValido($("#dni").val()); 
    var correoValido = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test($("#correo").val());

    // Habilitar o deshabilitar el botón basado en todas las validaciones
    if (dniValido && correoValido) {
        $('#enviar').attr("disabled", false);
    } else {
        $('#enviar').attr("disabled", true);
    }
}
